<?php

namespace App\Http\Controllers\V2;

use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\User\UserStageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddOnToSubscriptionRequest;
use App\Http\Requests\ChangeSubscriptionPlanRequest;
use App\Http\Requests\SelectSubscriptionPlanRequest;
use App\Models\Company;
use App\Models\InvoicePayment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Repositories\Contracts\InvoicePaymentRepositoryInterface;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptionRepository,
        private readonly InvoicePaymentRepositoryInterface $invoicePaymentRepository
    )
    {
    }

    public function selectSubscriptionPlan(SelectSubscriptionPlanRequest $request, Company $company)
    {
        $user = $company->users[0];

        if ($user->stage == UserStageEnum::VERIFICATION->value || $user->stage == UserStageEnum::COMPANY_DETAILS) {
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.wrong-user-stage'));
        }

        $dto = $request->getDTO();

        $dto->setCompanyId($company->id)
            ->setTenantId($company->tenant_id);

        $subscription = $this->subscriptionRepository->createSubscription($dto);

        $user->update(['stage' => UserStageEnum::USERS]);

        return $this->response(Response::HTTP_OK, __('messages.subscription-selected'), $subscription);
    }

    public function confirmInvoicePayment(InvoicePayment $payment)
    {

        $verifyPayment = $this->invoicePaymentRepository->verifyPayment($payment);

        if (!$verifyPayment) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __('Payment cannot be verified at the moment.'), $payment->fresh());
        }

        return $this->response(Response::HTTP_OK, __('Payment Confirmed'), $payment->fresh());
    }

    public function confirmSubscriptionPayment(SubscriptionPayment $payment, Request $request)
    {
        $payment->complete();

        return $this->response(Response::HTTP_OK, __('Subscription Confirmed'), $payment->fresh());
    }

    public function getSubscription(Company $company, Subscription $subscription)
    {
        $subscription = $this->subscriptionRepository->firstWithRelation(SubscriptionConstant::ID, $subscription->id, ['payment', 'plan.prices', 'addOns.feature', 'invoice']);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $subscription);
    }

    public function getActiveSubscription(Company $company, Subscription $subscription)
    {
        $subscription = $this->subscriptionRepository->getCompanySubscription($company);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $subscription);
    }

    public function getSubscriptions(Company $company)
    {
        $subscriptions = $company->subscriptions()->get();

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $subscriptions);
    }

    public function addAddonsToSubscription(Company $company, Subscription $subscription, AddOnToSubscriptionRequest $request)
    {
        $payment = $this->subscriptionRepository->addAddOnsToSubsciption($subscription, $request->dto());

        return $this->response(Response::HTTP_OK, 'Payment link generated', $payment);
    }

    public function changeSubscription(Company $company, SelectSubscriptionPlanRequest $request)
    {
        $activeSubscription = $company->activeSubscription()->firstOrFail();
        $activeSubscriptionPlan = $activeSubscription->plan;

        if ($activeSubscriptionPlan->id == $request->plan_id) {
            throw ValidationException::withMessages(['plan_id' => "You are currently on this plan"]);
        }

        $newCompanyPlan = Plan::find($request->plan_id);

        $dto = $request->getDTO();
        $dto->setTenantId($company->tenant_id)
            ->setCompanyId($company->id);

        $message = $this->subscriptionRepository->changeSubscription($activeSubscription, $newCompanyPlan, $dto);

        return $this->response(Response::HTTP_OK, __('Invoice created'), $message);
    }

    public function upgradeSubscription(Company $company, SelectSubscriptionPlanRequest $request)
    {
        $activeSubscription = $company->activeSubscription()->firstOrFail();
        $activeSubscriptionPlan = $activeSubscription->plan;
        $newPlan = Plan::find($request->plan_id);

        if ($activeSubscriptionPlan->rank <= $newPlan) {
            throw ValidationException::withMessages(['plan_id' => "Selected plan is not available for upgrade"]);
        }

        $dto = $request->getDTO();
        $dto->setTenantId($company->tenant_id)
            ->setCompanyId($company->id);

        $plan = $this->subscriptionRepository->upgradeSubscription($activeSubscription, $newPlan, $dto);

        return $this->response(Response::HTTP_OK, __('messages.record-created'), $plan);
    }

    public function downgradeSubscription(Company $company, SelectSubscriptionPlanRequest $request)
    {
        $activeSubscription = $company->activeSubscription()->firstOrFail();
        $activeSubscriptionPlan = $activeSubscription->plan;
        $newPlan = Plan::find($request->plan_id);

        if ($activeSubscriptionPlan->rank >= $newPlan) {
            throw ValidationException::withMessages(['plan_id' => "Selected plan is not available for downgrade"]);
        }

        $startDate = Carbon::createFromFormat('Y-m-d', $activeSubscription->end_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $activeSubscription->end_date);

        if ($this->input('billing_cycle') == BillingCycleEnum::MONTHLY->value) {
            $endDate = $startDate->addMonth();
        } elseif ($this->input('billing_cycle') == BillingCycleEnum::YEARLY->value) {
            $endDate = $startDate->addYear();
        }

        $dto = $request->getDTO();
        $dto->setTenantId($company->tenant_id)
            ->setCompanyId($company->id)
            ->setStartDate($startDate)
            ->setEndDate($endDate);

        $plan = $this->subscriptionRepository->downgradeSubscription($activeSubscription, $newPlan, $dto);

        return $this->response(Response::HTTP_OK, __('messages.record-created'), $plan);
    }
}

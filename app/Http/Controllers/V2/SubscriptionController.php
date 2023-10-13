<?php

namespace App\Http\Controllers\V2;

use App\Domains\Enum\User\UserStageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SelectSubscriptionPlanRequest;
use App\Models\Company;
use App\Models\SubscriptionPayment;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    public function __construct(private readonly SubscriptionRepositoryInterface $subscriptionRepository)
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

    public function confirmSubscriptionPayment(SubscriptionPayment $payment, Request $request)
    {
        $payment->complete();

        return $this->response(Response::HTTP_OK, __('Subscription Confirmed'), $payment->fresh());
    }

    public function getSubscriptions(Company $company)
    {
        $subscriptions = $company->subscriptions()->get();

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $subscriptions);
    }
}

<?php

namespace App\Http\Controllers\v2;

use App\Domains\Enum\User\UserStageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SelectSubscriptionPlanRequest;
use App\Models\Company;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    public function __construct(private readonly SubscriptionRepositoryInterface $subscriptionRepository)
    {
    }

    public function selectSubscriptionPlan(SelectSubscriptionPlanRequest $request, Company $company)
    {
        $user = $company->users[0];

        if($user->stage != UserStageEnum::SUBSCRIPTION_PLAN->value){
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.wrong-user-stage'));
        }

        $dto = $request->getDTO();

        $dto->setCompanyId($company->id)
            ->setTenantId($company->tenant_id);

        $this->subscriptionRepository->create($dto->toArray());

        $user->update(['stage' => UserStageEnum::USERS]);

        return $this->response(Response::HTTP_OK, __('messages.subscription-selected'));
    }
}

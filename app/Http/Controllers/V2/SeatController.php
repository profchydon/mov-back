<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\RevokeSeatFromUserRequest;
use App\Http\Requests\User\AssignSeatToUserRequest;
use App\Http\Resources\User\UserSeatCollection;
use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeatController extends Controller
{
    public function index(Company $company, Request $request)
    {
        $users = $company->seats;
        $plan = $company->activeSubscription->plan;
        $planSeat = $plan->planSeat->first();

        $users = $users->load(['roles', 'departments', 'teams', 'office']);
        // $users = User::appendToQueryFromRequestQueryParameters($users);
        // $users = $users->paginate();
        // $users = User::appendToQueryFromRequestQueryParameters($users);

        // $users = UserSeatCollection::make($users);

        // $userCollect = UserSeatCollection::make($users);

        $response = [
            'seats' => $users,
            'seatLimit' => $planSeat?->value,
        ];

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $response);
    }

    public function delete(RevokeSeatFromUserRequest $request, Company $company)
    {
        $user_companies = collect($request->user_ids)->map(fn ($user_id) => UserCompany::where('user_id', $user_id)->where('company_id', $company->id)->first());
        $user_companies->each(fn ($relation) => $relation->revokeSeat());

        return $this->response(Response::HTTP_OK, __('messages.records-updated'), $user_companies);
    }

    public function store(AssignSeatToUserRequest $request, Company $company)
    {
        $user_companies = collect($request->user_ids)->map(fn ($user_id) => UserCompany::where('user_id', $user_id)->where('company_id', $company->id)->first());
        $user_companies->each(fn ($relation) => $relation->assignSeat());

        return $this->response(Response::HTTP_OK, __('messages.records-updated'), $user_companies);
    }
}

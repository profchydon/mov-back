<?php

namespace App\Http\Controllers\V2;

use App\Domains\Constant\UserCompanyConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\RevokeSeatFromUserRequest;
use App\Http\Requests\User\AssignSeatToUserRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeatController extends Controller
{
    public function index(Company $company, Request $request)
    {
        $users = UserCompany::with(['user'])->where(UserCompanyConstant::COMPANY_ID, $company->id)->where(UserCompanyConstant::HAS_SEAT, true)->simplePaginate();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $users);
    }

    public function delete(RevokeSeatFromUserRequest $request, Company $company)
    {
        $user_companies = collect($request->user_ids)->map(fn($user_id) => UserCompany::where('user_id', $user_id)->where('company_id', $company->id)->first());
        $user_companies->each(fn($relation) => $relation->revokeSeat());

        return $this->response(Response::HTTP_OK, __('messages.records-updated'), $user_companies);
    }

    public function store(AssignSeatToUserRequest $request, Company $company)
    {
        $user_companies = collect($request->user_ids)->map(fn($user_id) => UserCompany::where('user_id', $user_id)->where('company_id', $company->id)->first());
        $user_companies->each(fn($relation) => $relation->assignSeat());

        return $this->response(Response::HTTP_OK, __('messages.records-updated'), $user_companies);
    }
}

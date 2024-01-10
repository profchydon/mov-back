<?php

namespace App\Http\Middleware;

use App\Exceptions\Company\InvalidCompanyIDException;
use App\Models\Company;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class UserBelongsToCompany
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            throw new AuthenticationException();
        }

        $company_id = $request->header('x-company-id');

        if (empty($company_id)) {
            throw new InvalidCompanyIDException(__('messages.headers.company_id.missing'));
        }

        try {
            $company = Company::findOrfail($company_id);

            if (!$company->users()->where('users.id', Auth::id())->exists()) {
                throw new UnauthorizedException("User does not belong to {$company->name}");
            }

            return $next($request);
        } catch (ModelNotFoundException $exception) {
            throw new InvalidCompanyIDException(__('messages.headers.company_id.invalid'), \Illuminate\Http\Response::HTTP_BAD_REQUEST, $exception);
        }
    }
}

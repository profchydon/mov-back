<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    protected $levels = [
        //
    ];


    protected $dontReport = [
        //
    ];


    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Integration::captureUnhandledException($e);

            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });

        $this->renderable(function (AccessDeniedHttpException|AuthorizationException $ex) {
            if ($ex->getStatusCode() === Response::HTTP_FORBIDDEN) {
                return $this->authorizationError($ex->getMessage());
            }

            return $this->error($ex->getStatusCode(), $ex->getMessage());
        });

        $this->renderable(function (NotFoundHttpException|ModelNotFoundException $ex) {
            if ($ex->getStatusCode() === Response::HTTP_NOT_FOUND) {
                return $this->error(Response::HTTP_NOT_FOUND, $ex->getMessage());
            }

            return $this->error($ex->getStatusCode(), $ex->getMessage());
        });

        $this->renderable(function (ValidationException $ex) {
            return $this->validationError($ex->errors());
        });

        $this->renderable(function (AuthenticationException $ex) {
            return $this->authenticationError($ex->getMessage());
        });

        $this->renderable(function (ConflictHttpException $ex) {
            return $this->error(Response::HTTP_CONFLICT, $ex->getMessage());
        });

        //** ALWAYS KEEP THIS SECTION AT THE BOTTOM OF THIS FILE */
        $this->renderable(function (Throwable $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());

            if (App::environment('local')) {
                $response = parent::prepareJsonResponse(request(), $ex);

                return $response->setData(
                    $this->serverError()->getOriginalContent()
                    + ['details' => $response->getData()]
                );
            }


            return $this->serverError();
        });
    }
}

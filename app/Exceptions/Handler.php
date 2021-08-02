<?php

namespace App\Exceptions;

use Flugg\Responder\Exceptions\ConvertsExceptions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ConvertsExceptions;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    /**
     * @param Request $request
     * @param Throwable $exception
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return $this->formatResponse('unauthorized', "This action is unauthorized", 401);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->formatResponse('authentication_error', "Unauthenticated", 401);
        }
        if ($exception instanceof HttpApiValidationException) {
            return $this->renderResponse($exception);
        }

        return parent::render($request, $exception);
    }
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    //format exception response to responder
    protected function formatResponse($code, $message, $statusCode = 500)
    {
        return responder()->error($code, $message)->respond($statusCode);
    }
}

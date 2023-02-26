<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {

        /**
         * catch bad request http exception
         */
        $this->renderable(function (BadRequestHttpException $e) {
            return sendResponse(
                httpCode: $e->getStatusCode(),
                statusCode: 'ERROR',
                error: null,
                message: $e->getMessage(),
            );
        });


        /**
         * catch global validation exception
         */

        $this->renderable(function (ValidationException $e) {
            return sendResponse(
                httpCode: $e->status,
                statusCode: 'ERROR',
                error: $e->errors(),
                message: null,
            );
        });


        $this->reportable(function (Throwable $e) {
            //
        });
    }
}

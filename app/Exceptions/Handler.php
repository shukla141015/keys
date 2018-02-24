<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception. This is a great spot to send exceptions to Sentry, Bugsnag, etc
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}

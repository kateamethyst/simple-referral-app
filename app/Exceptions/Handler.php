<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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

     /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'success' => false,
                'error_code' => null,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], 422);
        } else if ($exception instanceof \Illuminate\Http\Client\RequestException) {
            return response()->json([
                'success' => false,
                'error_code' => null,
                'message' => 'Internal server error.',
            ], 500);
        } elseif ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->json([
                'success' => false,
                'error_code' => null,
                'message' => $exception->getMessage(),
            ], 403);
        } elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'success' => false,
                'error_code' => null,
                'message' => $exception->getMessage(),
                'data' => [],
            ], 401);
        }

        return parent::render($request, $exception);
    }
}

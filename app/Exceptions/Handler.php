<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            $errorMessage = "";
            foreach ($exception->errors() as $err)
                foreach ($err as $errMsg)
                    $errorMessage .= $errMsg;

            return response()->json([
                "status" => "fail",
                "message" => $errorMessage,
                "error" => [
                    "code" => $exception->status,
                    "message" => $errorMessage,
                    "errors" => $exception->errors()
                ]
            ], $exception->status);
        }

        if ($exception instanceof NotFoundHttpException) {

            return response()->json([
                "status" => "error",
                "error" => [
                    "code" => 404,
                    "message" => "Not Found"
                ]
            ], 404);
        }

       

        return parent::render($request, $exception);
    }
}

<?php

namespace App\Exceptions;

use App\Traits\Jsonify;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Stripe\Exception\CardException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use Jsonify;

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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return self::jsonError(message: 'No record(s) found against this ID.', code: 404);
        });
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            return self::jsonError(message: 'This action is unauthorized.', code: 403);
        });
        $this->renderable(function (CardException $e, $request) {
            return self::jsonError(message: 'Cannot charge a customer that has no active card.', code: 500);
        });
    }
}

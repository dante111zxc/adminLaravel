<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
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
        });
    }

    public function report(Throwable $e)
    {
         parent::report($e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'code' => 400,
                'message' => 'Vui lòng đăng nhập để tiếp tục',
                'type' => 'error'
            ], 401);
        }
        $guard = Arr::get($exception->guards(), 0);
        switch ($guard) {
            case 'admin' :
                $login = 'admin.login';
                break;
            default :
                $login = 'login';
                break;
        }

        return redirect()->guest(route($login));

    }

}

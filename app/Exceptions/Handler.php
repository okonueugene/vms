<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('admin/*')) {
            return parent::render($request, $exception);
        }
        if($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response(['status' => 401, 'message' => 'Unauthorized'], 401);
        }
        if ($exception instanceof TokenMismatchException) {
            return redirect()->route('login')->withErrors(['message' => 'CSRF token mismatch. Please log in again.']);
        }
        if ($exception instanceof NotFoundHttpException) {
            return back()->withErrors([
                'delayMessage' => 'Page not found. Redirecting in 3 seconds...', // Your delay message
                'delaySeconds' => 3, // Delay in seconds
            ]);
        }
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
                return redirect()->route('login')->withErrors(['message' => 'You are not authorized to access this page.']);
            });
        }

        return parent::render($request, $exception);
    }
}

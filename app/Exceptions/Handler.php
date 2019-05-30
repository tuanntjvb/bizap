<?php

namespace App\Exceptions;

use App\Traits\RESTActions;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use RESTActions;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $requestUri = $request->getRequestUri();
        if (isset($requestUri) && starts_with($requestUri, '/api/')) {
            if ($exception instanceof NotFoundHttpException) {
                return $this->respondNotfound($exception->getMessage());
            }
            if ($exception instanceof MethodNotAllowedHttpException) {
                return $this->respondFail($exception->getMessage(), null, Response::HTTP_METHOD_NOT_ALLOWED);
            }
            if ($exception instanceof ValidationException) {
                return $this->respondFailValidation(trans('messages.validation_error'), $exception->errors());
            }
            if ($exception instanceof HttpException) {
                if ($exception->getStatusCode() == Response::HTTP_FORBIDDEN) {
                    return $this->respondFailForbidden($exception->getMessage());
                } else if ($exception->getStatusCode() == Response::HTTP_TOO_MANY_REQUESTS) {
                    return $this->respondFail(__('messages.too_many_attempts'));
                }

                return $this->respondFail($exception->getMessage());
            }
            if ($exception instanceof AuthenticationException) {
                return $this->respondAuthFail($exception->getMessage());
            }
            if (config('app.env') != 'production') {
                if ($exception instanceof QueryException) {
                    return $this->respondFail('Error DB: ' . $exception->getMessage() . $exception->getTraceAsString());
                }

                if ($exception instanceof Exception) {
                    return $this->respondFail('Error: ' . $exception->getMessage() . $exception->getTraceAsString());
                }

            } else {
                if ($exception instanceof Exception) {
                    return $this->respondFail(__('messages.server_error'));
                }
            }

        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}

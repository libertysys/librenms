<?php

namespace App\Exceptions;

use App\Checks;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use LibreNMS\Exceptions\DatabaseConnectException;
use LibreNMS\Exceptions\DuskUnsafeException;

class Handler extends ExceptionHandler
{
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

    public function render($request, Exception $exception)
    {
        // If for some reason Blade hasn't been registered, try it now
        try {
            if (!app()->bound('view')) {
                app()->register(\App\Providers\ViewServiceProvider::class);
                app()->register(\Illuminate\Translation\TranslationServiceProvider::class);
            }
        } catch (\Exception $e) {
            // continue without view
        }

        if ($fpe = Checks::filePermissionsException($exception)) {
            $exception = $fpe;
        } elseif ($dbe = $this->checkDatabaseException($exception)) {
            // handle database exceptions
            $exception = $dbe;
        } elseif ($exception->getMessage() == 'It is unsafe to run Dusk in production.') {
            // dusk in production
            $exception = new DuskUnsafeException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson() || $request->is('api/*')
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    protected function checkDatabaseException(Exception $e)
    {
        if ($e instanceof QueryException) {
            // connect exception, convert to our standard connection exception
            if (config('app.debug')) {
                // get message form PDO exception, it doesn't contain the query
                $message = $e->getMessage();
            } else {
                $message = $e->getPrevious()->getMessage();
            }

            if (in_array($e->getCode(), [1044, 1045, 2002])) {
                // this Exception has it's own render function
                return new DatabaseConnectException($message, $e->getCode(), $e);
            }
        }

        return false;
    }
}

<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Catch the Spatie UnauthorizedException
        if ($exception instanceof UnauthorizedException) {
            // Redirect back with a flash error message
            return redirect()->back()->with('error', 'Permission Denied.');
        }

        return parent::render($request, $exception);
    }
}

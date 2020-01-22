<?php

namespace Shalvah\LaravelJsend;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

/**
 * @mixin \App\Exceptions\Handler
 */
trait JsendExceptionFormatter
{
    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return jsend_fail(
            $exception->errors(),
            $exception->status
        );
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception $e
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function prepareJsonResponse($request, Exception $e)
    {
        $message = 'Server Error';
        if (config('app.debug') || $this->isHttpException($e)) {
            $message = $e->getMessage();
        }

        $data = config('app.debug') ? [
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : null;

        return jsend_error(
            $message,
            $e->getCode(),
            $data,
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            $this->isHttpException($e) ? $e->getHeaders() : []
        );
    }
}

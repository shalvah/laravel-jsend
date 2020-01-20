<?php

namespace Shalvah\LaravelJsend;

use Exception;
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
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, Exception $e)
    {
        return jsend_error(
            $e->getMessage(),
            $e->getCode(),
            null,
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            $this->isHttpException($e) ? $e->getHeaders() : []
        );
    }
}

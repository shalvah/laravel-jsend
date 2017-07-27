<?php

if (!function_exists("jsend_error")) {
    /**
     * @param string $message Error message
     * @param string $code Optional custom error code
     * @param string | array $data Optional data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_error($message, $code = "", $data = "", $status = 500, $extraHeaders = [])
    {
        $response = [
            "status" => "error",
            "message" => $message
        ];
        if ($code) $response['code'] = $code;
        if ($data) $response['data'] = $data;

        return response()->json($response, $status, $extraHeaders);
    }
}

if (!function_exists("jsend_fail")) {
    /**
     * @param array $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_fail($data, $status = 400, $extraHeaders = [])
    {
        $response = [
            "status" => "fail",
            "data" => $data
        ];

        return response()->json($response, $status, $extraHeaders);
    }
}

if (!function_exists("jsend_success")) {
    /**
     * @param array | Illuminate\Database\Eloquent\Model $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_success($data = [], $status = 200, $extraHeaders = [])
    {
        $data = ($data instanceof Illuminate\Database\Eloquent\Model) ? $data->toArray() : $data;
        $response = [
            "status" => "success",
            "data" => $data
        ];

        return response()->json($response, $status, $extraHeaders);
    }
}
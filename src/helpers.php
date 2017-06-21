<?php

if (!function_exists("jsend_error")) {
    /**
     * @param $message Error message
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
        $response = json_encode($response);
        $headers = array_merge(["Content-type" => "application/json"], $extraHeaders);
        return response($response, $status, $headers);
    }
}

if (!function_exists("jsend_fail")) {
    /**
     * @param $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_fail($data, $status = 400, $extraHeaders = [])
    {
        $response = json_encode([
            "status" => "fail",
            "data" => $data
        ]);
        $headers = array_merge(["Content-type" => "application/json"], $extraHeaders);
        return response($response, $status, $headers);
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
        $response = json_encode([
            "status" => "success",
            "data" => $data
        ]);
        $headers = array_merge(["Content-type" => "application/json"], $extraHeaders);
        return response($response, $status, $headers);
    }
}
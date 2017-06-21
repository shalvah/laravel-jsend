<?php

if (!function_exists("jsend_error")) {
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
    function jsend_success($data = [], $status = 200, $extraHeaders = [])
    {
        $response = json_encode([
            "status" => "success",
            "data" => $data
        ]);
        $headers = array_merge(["Content-type" => "application/json"], $extraHeaders);
        return response($response, $status, $headers);
    }
}
<?php

namespace App\Helpers;

/**
 * Format response.
 */
class ResponseFormatter
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'metadata' => [
            'path' => null,
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'pagination' => [
            'current_page' => 1,
            'current_item' => 1,
            'total_page' => 1,
            'total_item' => 1,
        ],
        'data' => null,
    ];

    /**
     * Give success response.
     */
    public static function success($path = null, $data = null, $message = null, $code = 200, $status = 'OK', $current_page = 1, $current_item = 1, $total_page = 1, $total_item = 1)
    {
        self::$response['metadata']['path'] = $path;
        self::$response['metadata']['code'] = $code;
        self::$response['metadata']['status'] = $status;
        self::$response['metadata']['message'] = $message;
        self::$response['pagination']['current_page'] = $current_page;
        self::$response['pagination']['current_item'] = $current_item;
        self::$response['pagination']['total_page'] = $total_page;
        self::$response['pagination']['total_item'] = $total_item;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['metadata']['code']);
    }

    /**
     * Give error response.
     */
    public static function error($path = null, $data = null, $message = null, $code = 404, $status = "Not Found")
    {
        self::$response['metadata']['path'] = $path;
        self::$response['metadata']['code'] = $code;
        self::$response['metadata']['status'] = $status;
        self::$response['metadata']['message'] = $message;
        self::$response['pagination']['current_page'] = 1;
        self::$response['pagination']['current_element'] = 0;
        self::$response['pagination']['total_page'] = 1;
        self::$response['pagination']['total_element'] = 0;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['metadata']['code']);
    }
}

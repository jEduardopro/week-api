<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private function response($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    public function responseResource($resource, $message = "")
    {
        return $resource->additional([
            "message" => $message
        ]);
    }

    public function responseData($data, $message = "", $code = 200)
    {
        $response = (object) [
            'message' => $message,
            'data' => $data,
        ];
        return $this->response($response, $code);
    }

    public function responseMessage($message, $code =  200)
    {
        return $this->response(["message" => $message], $code);
    }

    public function responseErrorMessage($error, $message = "", $code =  417)
    {
        return $this->response(["error" => $error, "message" => $message], $code);
    }

    public function responseError($exception, $message = "", $code = 417)
    {
        return $this->response([
            "exception" => $exception->getMessage(),
            "message" => $message
        ], $code);
    }
}

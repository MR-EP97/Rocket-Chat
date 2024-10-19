<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


trait JsonResponseTrait
{
    public function successJson(string $message = '',
                                mixed  $data = [],
                                int    $code = HttpResponse::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }


    public function errorJson(string $message = 'Not found',
                              mixed  $data = [],
                              int    $code = HttpResponse::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

}

<?php

namespace App\Traits;


use App\Enums\StatusResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait ArrayResponseTrait
{
    public function successArray(string $message = '',
                                 mixed  $data = [],
                                 string $status = StatusResponse::SUCCESS): array

    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }


    public
    function errorArray(
        string $message = '',
        mixed  $data = [],
        string $status = StatusResponse::FAILED): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}

<?php

namespace App\Services\ApiServices;

use App\Enums\RocketChat\Admin;
use App\Traits\ArrayResponseTrait;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


abstract class RocketChat
{
    use ArrayResponseTrait, JsonResponseTrait;

    /**
     * @throws ConnectionException
     */
    protected function tokenRequest(): array|JsonResponse
    {
        try {
            $response = Http::asForm()
                ->post(Admin::URL,
                    [
                        'username' => Admin::USERNAME,
                        'password' => Admin::PASSWORD
                    ]);

            if ($response['status'] === 'failed!') {
                throw new Exception('Invalid credentials');
            }

            return $this->successArray(data: ['access_token' => $response['access_token']]);

        } catch (Exception $exception) {
            throw new \RuntimeException($exception->getMessage(), $exception->getCode());
        }
    }

    protected function getToken(): string
    {
        return 'Bearer ' . Cache::remember(
                'admin_token',
                59 * 60 * 24 * 7,
                function () {
                    return $this->tokenRequest()['data']['access_token'];
                }
            );
    }


}

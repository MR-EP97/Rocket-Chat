<?php

namespace App\Services\ApiServices;

use App\Enums\RocketChat\Admin;
use App\Traits\ArrayResponseTrait;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

abstract class RocketChat
{
    use ArrayResponseTrait;

    protected function tokenRequest(): array
    {
        try {
            $response = Http::asForm()
                ->post(Admin::ADMIN_URL,
                    [
                        'username' => Admin::ADMIN_USERNAME,
                        'password' => Admin::ADMIN_PASSWORD
                    ]);

            if ($response['status'] === 'failed!') {
                return $this->errorArray('Invalid credentials');
            }

            return $this->successArray(data: ['access_token' => $response['access_token']]);

        } catch (ConnectionException $exception) {
            return $this->errorArray('Connection failed');
        } catch (Exception $exception) {
            return $this->errorArray($exception->getMessage());
        }
    }


}

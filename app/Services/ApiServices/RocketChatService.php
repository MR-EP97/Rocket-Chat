<?php

namespace App\Services\ApiServices;

use App\Enums\RocketChat\AddGroup;
use App\Enums\RocketChat\Admin;
use App\Enums\RocketChat\RegisterUser;
use App\Traits\ArrayResponseTrait;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Js;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class RocketChatService extends RocketChat
{

    use ArrayResponseTrait, JsonResponseTrait;

    /**
     */
    public function registerUser(array $request): JsonResponse|array
    {
        $token = $this->tokenRequest();

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token['data']['access_token'],
            ])->post(RegisterUser::URL,
                [
                    'username' => $request['username'],
                    'password' => $request['password'],
                    'name' => $request['name'],
                    'mail' => $request['mail']
                ]);
            if ($response['status']) {
                return $this->successArray(data: $response);
            }
            return $this->errorJson(
                'Invalid request',
                HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
            );
        } catch (\Exception $e) {
            return $this->errorJson(
                $e->getMessage(),
            );
        }

    }

    public function addGroup(array $request): JsonResponse|array
    {
        $token = $this->tokenRequest();

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token['data']['access_token'],
            ])->post(AddGroup::URL,
                [
                    'name' => $request['name'],
                    'users' => $request['users'],
                    'moderators' => $request['moderators'],
                ]);

            if ($response['status']) {
                return $this->successArray('Create group successfully',
                    data: $response);
            }
            return $this->errorJson(
                'Invalid request',
                HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
            );
        } catch (\Exception $e) {
            return $this->errorJson(
                $e->getMessage(),
            );
        }

    }


}

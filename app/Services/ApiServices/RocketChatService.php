<?php

namespace App\Services\ApiServices;

use App\Enums\RocketChat\AddGroup;
use App\Enums\RocketChat\Admin;
use App\Enums\RocketChat\RegisterUser;
use App\Traits\ArrayResponseTrait;
use App\Traits\JsonResponseTrait;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use function Pest\Laravel\json;

class RocketChatService extends RocketChat
{

    use ArrayResponseTrait, JsonResponseTrait;

    /**
     */
    public function registerUser(array $request): JsonResponse|array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->getToken(),
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
            throw new \Exception('Invalid request');
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode());
        }

    }

    public function addGroup(array $request): JsonResponse|array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->getToken(),
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
            throw new \RuntimeException('Invalid request');

        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function startChat(array $request): array
    {

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->getToken(),
            ])->post(AddGroup::URL,
                [
                    'userid' => $request['userid'],
                ]);
            if ($response['status']) {
                return $this->successArray('Create token successfully',
                    data: $response);
            }

            throw new \RuntimeException('Invalid request');

        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }


}

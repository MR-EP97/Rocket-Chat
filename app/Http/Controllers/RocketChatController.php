<?php

namespace App\Http\Controllers;

use App\Enums\RocketChat\AddGroup;
use App\Http\Requests\AddGroupRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\ApiServices\RocketChatService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


class RocketChatController extends Controller
{

    use JsonResponseTrait;

    public function __construct(protected RocketChatService $rocketChatService)
    {
    }

    public function addUser(UserRegisterRequest $request): JsonResponse
    {
        $user = $this->rocketChatService->registerUser((array)$request->validated());

        return $this->successJson(
            'User Created successfully',
            ['user_id' => $user['userid']],
            HttpResponse::HTTP_CREATED
        );
    }

    public function addGroup(AddGroupRequest $request): JsonResponse
    {
        $group = $this->rocketChatService->addGroup((array)$request->validated());

        return $this->successJson(
            $group['message'],
            ['group_id' => $group['data']['groupid']],
            HttpResponse::HTTP_CREATED
        );
    }


}

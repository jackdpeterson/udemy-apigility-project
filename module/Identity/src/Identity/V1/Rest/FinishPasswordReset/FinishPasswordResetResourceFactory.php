<?php
namespace Identity\V1\Rest\FinishPasswordReset;

use MyCompany\Service\UserService;

class FinishPasswordResetResourceFactory
{

    public function __invoke($services)
    {
        $userService = $services->get(UserService::class);
        return new FinishPasswordResetResource($userService);
    }
}

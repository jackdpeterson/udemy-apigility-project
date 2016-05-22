<?php
namespace Identity\V1\Rest\BeginPasswordReset;

use MyCompany\Service\UserService;

class BeginPasswordResetResourceFactory
{

    public function __invoke($services)
    {
        $userService = $services->get(UserService::class);
        return new BeginPasswordResetResource($userService);
    }
}

<?php
namespace Identity\V1\Rest\User;

use MyCompany\Service\UserService;

class UserResourceFactory
{

    public function __invoke($services)
    {
        $userService = $services->get(UserService::class);
        
        return new UserResource($userService);
    }
}

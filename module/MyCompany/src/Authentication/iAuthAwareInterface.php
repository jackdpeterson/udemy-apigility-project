<?php
namespace MyCompany\Authentication;

use MyCompany\Entity\User;

interface iAuthAwareInterface
{

    /**
     *
     * @param AuthenticationServiceInterface $authService            
     */
    public function setAuthenticatedIdentity(User $user);

    /**
     *
     * @return User
     * @throws InvalidIdentityException
     */
    public function getAuthenticatedIdentity();
}
<?php
namespace MyCompany\Service;

interface UserServiceInterface
{

    public function registerUser($emailAddress, $password);

    public function forgotPassword($emailAddress);

    public function resetPassword($emailAddress, $resetToken, $newPassword);

    public function fetchUser($email);

    public function changeEmailAddress($oldEmailAddress, $newEmailAddress);

    /**
     *
     * @param string $func            
     * @param AssertionInterface|Callable|null $assertion            
     * @return boolean
     */
    public function isMethodAllowed($func, $assertion = null);
}
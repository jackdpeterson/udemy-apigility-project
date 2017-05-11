<?php
namespace MyCompany\Assertion;

use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;
use MyCompany\Entity\User;

class AssertUserMatchesAnotherUserEntity implements AssertionInterface
{

    protected $originalUser;

    protected $resourceInQuestion;

    public function __construct(User $user)
    {
        $this->originalUser = $user;
    }

    public function setResourceInQuestion(User $user)
    {
        $this->resourceInQuestion = $user;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\Permissions\Rbac\AssertionInterface::assert()
     */
    public function assert(Rbac $rbac)
    {
        if (! $this->resourceInQuestion instanceof User)
            return false;
        
        return $this->originalUser->getId() == $this->resourceInQuestion->getId();
    }
}

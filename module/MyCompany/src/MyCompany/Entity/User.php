<?php
namespace MyCompany\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZF\OAuth2\Doctrine\Entity\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $isEmailConfirmed;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $isActivated;

    /**
     * @ORM\Column(type="array")
     */
    protected $roles;
    
    // OAUTH
    protected $client;

    protected $accessToken;

    protected $authorizationCode;

    protected $refreshToken;

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     *
     * @return the $id
     */
    public final function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $email
     */
    public final function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @return the $password
     */
    public final function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @return the $createdAt
     */
    public final function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @return the $isEmailConfirmed
     */
    public final function getIsEmailConfirmed()
    {
        return $this->isEmailConfirmed;
    }

    /**
     *
     * @return the $isActivated
     */
    public final function getIsActivated()
    {
        return $this->isActivated;
    }

    /**
     *
     * @return the $roles
     */
    public final function getRoles()
    {
        return $this->roles;
    }

    /**
     *
     * @return the $client
     */
    public final function getClient()
    {
        return $this->client;
    }

    /**
     *
     * @return the $accessToken
     */
    public final function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     *
     * @return the $authorizationCode
     */
    public final function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     *
     * @return the $refreshToken
     */
    public final function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     *
     * @param string $email            
     */
    public final function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @param field_type $password            
     */
    public final function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     *
     * @param DateTime $createdAt            
     */
    public final function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     *
     * @param boolean $isEmailConfirmed            
     */
    public final function setIsEmailConfirmed($isEmailConfirmed)
    {
        $this->isEmailConfirmed = $isEmailConfirmed;
    }

    /**
     *
     * @param boolean $isActivated            
     */
    public final function setIsActivated($isActivated)
    {
        $this->isActivated = $isActivated;
    }

    /**
     *
     * @param field_type $roles            
     */
    public final function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     *
     * @param field_type $client            
     */
    public final function setClient($client)
    {
        $this->client = $client;
    }

    /**
     *
     * @param field_type $accessToken            
     */
    public final function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     *
     * @param field_type $authorizationCode            
     */
    public final function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     *
     * @param field_type $refreshToken            
     */
    public final function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }
}
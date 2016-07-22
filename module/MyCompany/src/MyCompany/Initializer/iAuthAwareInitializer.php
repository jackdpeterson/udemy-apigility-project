<?php
namespace MyCompany\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use MyCompany\Entity\User;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use MyCompany\Authentication\iAuthAwareInterface;
use ZF\ApiProblem\ApiProblem;

class iAuthAwareInitializer implements InitializerInterface
{

    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof iAuthAwareInterface) {
            try {
                $authObj = $serviceLocator->get('api-identity');
                
                if ($authObj instanceof AuthenticatedIdentity) {
                    /**
                     *
                     * @var $orm EntityManagerInterface
                     */
                    $orm = $serviceLocator->get('doctrine.entitymanager.orm_default');
                    
                    $oauth_user_id = $serviceLocator->get('api-identity')->getAuthenticationIdentity()['user_id'];
                    
                    $userObj = $orm->find(User::class, $oauth_user_id);
                    
                    $instance->setAuthenticatedIdentity($userObj);
                }
            } catch (\exception $e) {
                return new ApiProblem(500, $e->getMessage());
            }
        }
    }
}
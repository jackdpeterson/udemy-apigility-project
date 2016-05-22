<?php
namespace MyCompany\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use MyCompany\Service\UserService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
use MyCompany\RBAC\ServiceRBAC;

class UserServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $mailImpl = $serviceLocator->get('SlmMail\Mail\Transport\SesTransport');
        
        $mailViewRenderer = new PhpRenderer();
        $resolver = new TemplateMapResolver();
        $resolver->setMap($serviceLocator->get('Config')['view_manager']['template_map']);
        $mailViewRenderer->setResolver($resolver);
        
        $serviceRBAC = new ServiceRBAC();
        $service = new UserService($em, $mailImpl, $mailViewRenderer, $serviceRBAC);
        return $service;
    }
}
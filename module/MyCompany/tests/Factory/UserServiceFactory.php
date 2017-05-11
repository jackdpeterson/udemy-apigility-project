<?php

namespace MyCompanyTest\Factory;

use Interop\Container\ContainerInterface;
use Zend\Mail\Transport\TransportInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use MyCompany\Service\UserService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
use MyCompany\RBAC\ServiceRBAC;
use Zend\Mail;

class UserServiceFactory implements FactoryInterface
{

    public function createService(ContainerInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $mockTransport = new class () implements TransportInterface
        {
            public function send(Mail\Message $message)
            {
                // uncomment this line if you want to see the contents of the e-mails :-)
                //echo "sending (via MOCK): \n\n\n" . $message->toString();
            }
        };

        $mailViewRenderer = new PhpRenderer();
        $resolver = new TemplateMapResolver();
        $resolver->setMap($serviceLocator->get('Config')['view_manager']['template_map']);
        $mailViewRenderer->setResolver($resolver);

        $serviceRBAC = new ServiceRBAC();
        $service = new UserService($em, $mockTransport, $mailViewRenderer, $serviceRBAC);

        return $service;
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createService($container);
    }


}
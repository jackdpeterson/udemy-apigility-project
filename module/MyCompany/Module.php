<?php
namespace MyCompany;

use Zend\Uri\UriFactory;
use Zend\Mvc\MvcEvent;

class Module
{
    public function __construct() {
        UriFactory::registerScheme('chrome-extension', 'Zend\Uri\Uri');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
}

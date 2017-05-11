<?php

namespace MyCompany;

use Zend\Uri\UriFactory;

class Module
{
    public function __construct()
    {
        UriFactory::registerScheme('chrome-extension', 'Zend\Uri\Uri');
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}

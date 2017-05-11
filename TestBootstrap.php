<?php

use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;

error_reporting(E_ALL | E_STRICT);

if (!defined('APPLICATION_ENV')) {
    define('APPLICATION_ENV', 'development');
}

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(__DIR__));
}

/**
 * Test bootstrap, for setting up autoloading
 */
class TestBootstrap
{

    protected static $serviceManager;

    public static function init()
    {

        require_once(__DIR__ . '/vendor/autoload.php');
        $appConfig = require __DIR__ . '/config/application.config.php';


        if (file_exists(__DIR__ . '/config/development.config.php')) {
            $appConfig = ArrayUtils::merge(
                $appConfig,
                include __DIR__ . '/config/development.config.php'
            );
        }

        if (file_exists(__DIR__ . '/module/MyCompany/tests/Config/doctrine.php')) {
            $appConfig = ArrayUtils::merge(
                $appConfig,
                include __DIR__ . '/module/MyCompany/tests/Config/doctrine.php'
            );
        }

        $application = Application::init($appConfig);
        static::$serviceManager = $application->getServiceManager();
    }

    public static function getServiceManager(): ServiceManager
    {
        return static::$serviceManager;
    }
}

TestBootstrap::init();

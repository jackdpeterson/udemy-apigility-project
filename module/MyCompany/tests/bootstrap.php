<?php
namespace MyCompany;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

if (! defined('APPLICATION_ENV')) {
    define('APPLICATION_ENV', 'development');
}

if (! defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(__DIR__ . '/../../../'));
}

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{

    protected static $serviceManager;

    public static function init()
    {
        $zf2ModulePaths = array(
            dirname(dirname(__DIR__))
        );
        if ((static::findParentPath('vendor'))) {
            $path = static::findParentPath('vendor');
            $zf2ModulePaths[] = $path;
        }
        if (($path = static::findParentPath('module')) !== $zf2ModulePaths[0]) {
            $zf2ModulePaths[] = $path;
        }
        
        static::initAutoloader();
        
        $app_config = require __DIR__ . '/../../../config/application.config.php';
        
        if (file_exists(APPLICATION_PATH . '/config/development.config.php')) {
            $app_config = \Zend\Stdlib\ArrayUtils::merge($app_config, include APPLICATION_PATH . '/config/development.config.php');
        }
        
        // use ModuleManager to load this module and it's dependencies
        $config = array(
            'module_listener_options' => array(
                'config_glob_paths' => array(
                    sprintf(__DIR__ . '/../../../config/autoload/{,*.}{global,%s,local}.php', APPLICATION_ENV)
                ),
                'module_paths' => array(
                    __DIR__ . '/../../../module',
                    __DIR__ . '/../../../vendor'
                )
            ),
            'modules' => $app_config['modules']
        );
        
        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');
        
        $zf2Path = getenv('ZF2_PATH');
        if (! $zf2Path) {
            if (defined('ZF2_PATH')) {
                $zf2Path = ZF2_PATH;
            } elseif (is_dir($vendorPath . '/ZF2/library')) {
                $zf2Path = $vendorPath . '/ZF2/library';
            } elseif (is_dir($vendorPath . '/zendframework')) {
                $zf2Path = $vendorPath . '/zendframework';
            }
        }
        
        if (! $zf2Path) {
            throw new \RuntimeException('Unable to load ZF2. Run `php composer.phar install` or' . ' define a ZF2_PATH environment variable.');
        }
        
        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }
        
        include $zf2Path . '/zend-Loader/src/AutoloaderFactory.php';
        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__
                )
            )
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (! is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();
Bootstrap::chroot();
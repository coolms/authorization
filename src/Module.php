<?php
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/authorization for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAuthorization;

use Zend\EventManager\EventInterface,
    Zend\Http\Request as HttpRequest,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\BootstrapListenerInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Exception\RuntimeException,
    Zend\ModuleManager\ModuleManager;

class Module implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface
{
    /**
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        try {
            $moduleManager->loadModule('CmsAcl');
            $moduleManager->loadModule('CmsRbac');
        } catch (RuntimeException $e) {}
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/../autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'fallback_autoloader' => true,
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $event)
    {
        if (!$event->getRequest() instanceof HttpRequest) {
            return;
        }

        /* @var $app \Zend\Mvc\ApplicationInterface */
        $app = $event->getTarget();
        /* @var $services \Zend\ServiceManager\ServiceLocatorInterface */
        $services = $app->getServiceManager();
        /* @var $options \CmsAuthorization\Options\ModuleOptionsInterface */
        $options = $services->get('CmsAuthorization\\Options\\ModuleOptions');
        /* @var $strategy \CmsAuthorization\View\Strategy\AbstractStrategy */
        $strategy = $services->get($options->getUnauthorizedStrategy());

        $app->getEventManager()->attach($strategy);
    }
}

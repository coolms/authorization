<?php
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/authorization for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAuthorization\Factory\View\Strategy;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsPermissions\Options\ModuleOptions as PermissionsModuleOptions,
    CmsAuthorization\Options\ModuleOptionsInterface,
    CmsAuthorization\Options\ModuleOptions as AuthorizationModuleOptions,
    CmsAuthorization\View\Strategy\RedirectStrategy;

class RedirectStrategyFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return RedirectStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options ModuleOptionsInterface */
        $options = $serviceLocator->get(AuthorizationModuleOptions::class);

        /* @var $authenticationService \Zend\Authentication\AuthenticationServiceInterface */
        $authenticationService = $serviceLocator->get(
            $serviceLocator->get(PermissionsModuleOptions::class)->getAuthenticationService()
        );

        return new RedirectStrategy($options, $authenticationService);
    }
}

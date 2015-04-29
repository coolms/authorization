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
    CmsAuthorization\View\Strategy\UnauthorizedStrategy;

class UnauthorizedStrategyFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return UnauthorizedStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \CmsAuthorization\Options\ModuleOptionsInterface */
        $options = $serviceLocator->get('CmsAuthorization\\Options\\ModuleOptions');
        return new UnauthorizedStrategy($options);
    }
}

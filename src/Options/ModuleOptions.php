<?php 
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/authorization for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAuthorization\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * Turn off strict options mode
     *
     * @var bool
     */
    protected $__strictMode__ = false;

    /**
     * Strategy service name for the strategy listener to be used
     * when permission-related errors are detected
     *
     * @var string
     */
    protected $unauthorizedStrategy = 'CmsAuthorization\\View\\Strategy\\UnauthorizedStrategy';

    /**
     * Template name for the unauthorized strategy
     *
     * @var string
     */
    protected $template = 'error/403';

    /**
     * @var string
     */
    protected $authenticatedIdentityRedirectRoute;

    /**
     * @var string
     */
    protected $unauthenticatedIdentityRedirectRoute = 'cms-authentication/login';

    /**
     * @var string
     */
    protected $redirectKey = 'redirect';

    /**
     * @var bool
     */
    protected $useRedirectParameter = true;

    /**
     * {@inheritDoc}
     */
    public function setUnauthorizedStrategy($unauthorizedStrategy)
    {
        $this->unauthorizedStrategy = $unauthorizedStrategy;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUnauthorizedStrategy()
    {
        return $this->unauthorizedStrategy;
    }

    /**
     * {@inheritDoc}
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthenticatedIdentityRedirectRoute($route)
    {
        $this->authenticatedIdentityRedirectRoute = (string) $route;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthenticatedIdentityRedirectRoute()
    {
        return $this->authenticatedIdentityRedirectRoute;
    }

    /**
     * {@inheritDoc}
     */
    public function setUnauthenticatedIdentityRedirectRoute($route)
    {
        $this->unauthenticatedIdentityRedirectRoute = (string) $route;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUnauthenticatedIdentityRedirectRoute()
    {
        return $this->unauthenticatedIdentityRedirectRoute;
    }

    /**
     * {@inheritDoc}
     */
    public function setRedirectKey($key)
    {
        $this->redirectKey = (string) $key;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectKey()
    {
        return $this->redirectKey;
    }

    /**
     * {@inheritDoc}
     */
    public function setUseRedirectParameter($flag)
    {
        $this->useRedirectParameter = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUseRedirectParameter()
    {
        return $this->useRedirectParameter;
    }
}

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

interface ModuleOptionsInterface
{
    /**
     * @param string $strategy
     */
    public function setUnauthorizedStrategy($strategy);

    /**
     * @return string
     */
    public function getUnauthorizedStrategy();

    /**
     * @param string $template
     */
    public function setTemplate($template);

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * Sets redirect key
     *
     * @param string $key
     * @return self
     */
    public function setRedirectKey($key);

    /**
     * Retrieves redirect key
     *
     * @return string
     */
    public function getRedirectKey();

    /**
     * Sets redirect route for authenticated users
     *
     * @param string $route
     * @return self
     */
    public function setAuthenticatedIdentityRedirectRoute($route);

    /**
     * Retrieves redirect route for authenticated users
     *
     * @return string
     */
    public function getAuthenticatedIdentityRedirectRoute();

    /**
     * Set use redirect param.
     *
     * @param bool $flag
     * @return self
     */
    public function setUseRedirectParameter($flag);

    /**
     * Get use redirect param.
     *
     * @return bool
     */
    public function getUseRedirectParameter();

    /**
     * Sets redirect route for unauthenticated identity
     *
     * @param string $route
     * @return self
     */
    public function setUnauthenticatedIdentityRedirectRoute($route);

    /**
     * Retrieves redirect route for unauthenticated identity
     *
     * @return string
     */
    public function getUnauthenticatedIdentityRedirectRoute();
}

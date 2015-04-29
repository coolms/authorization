<?php
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/authorization for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAuthorization\View\Strategy;

use Zend\Authentication\AuthenticationServiceInterface,
    Zend\Http\Response as HttpResponse,
    Zend\Mvc\MvcEvent,
    CmsAuthorization\Options\ModuleOptionsInterface;

/**
 * Dispatch error handler, catches exceptions related with authorization and
 * redirects the user agent to a configured location
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class RedirectStrategy extends UnauthorizedStrategy
{
    /**
     * @var string route to be used to handle redirects
     */
    protected $redirectRoute;

    /**
     * @var string URI to be used to handle redirects
     */
    protected $redirectUri;

    /**
     * @var AuthenticationServiceInterface
     */
    protected $authenticationService;

    /**
     * {@inheritDoc}
     */
    public function __construct(
        ModuleOptionsInterface $options,
        AuthenticationServiceInterface $authenticationService
    ) {
        parent::__construct($options);
        $this->authenticationService = $authenticationService;
    }

    /**
     * Handles redirects in case of dispatch errors caused by unauthorized access
     *
     * @param \Zend\Mvc\MvcEvent $event
     * @return void
     */
    public function onError(MvcEvent $event)
    {
        if (!($routeMatch = $event->getRouteMatch())) {
            return;
        }

        if (null === $this->redirectUri) {
            if (null === $this->redirectRoute) {
                if ($this->authenticationService->hasIdentity()) {
                    $this->setRedirectRoute($this->options->getAuthenticatedIdentityRedirectRoute());
                } else {
                    $this->setRedirectRoute($this->options->getUnauthenticatedIdentityRedirectRoute());
                }
            }

            if (!($this->redirectRoute && $this->redirectRoute !== $routeMatch->getMatchedRouteName())) {
                return parent::onError($event);
            }

            $params = ['name' => $this->redirectRoute];
            if ($this->options->getUseRedirectParameter()) {
                $redirectKey = $this->options->getRedirectKey();
            	$params['query'][$redirectKey] = $event->getRequest()->getUriString();
            }

            $this->setRedirectUri($event->getRouter()->assemble([], $params));
        }

        $response = $event->getResponse() ?: new HttpResponse;

        $response->getHeaders()->addHeaderLine('Location', $this->redirectUri);
        $response->setStatusCode(302);

        $event->setResponse($response);
    }

    /**
     * @param string|null $redirectRoute
     * @return self
     */
    public function setRedirectRoute($redirectRoute)
    {
        $this->redirectRoute = $redirectRoute ? (string) $redirectRoute : null;
        return $this;
    }

    /**
     * @param string|null $redirectUri
     * @return self
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri ? (string) $redirectUri : null;
        return $this;
    }
}

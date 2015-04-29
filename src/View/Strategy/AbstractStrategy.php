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

use Zend\Http\Response as HttpResponse,
    Zend\EventManager\AbstractListenerAggregate,
    Zend\EventManager\EventManagerInterface,
    Zend\Mvc\MvcEvent,
    CmsPermissions\Exception\UnauthorizedException,
    CmsPermissions\Guard\GuardInterface;

/**
 * Abstract strategy for any unauthorized access
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
abstract class AbstractStrategy extends AbstractListenerAggregate
{
    /**
     * Event priority
     */
    const EVENT_PRIORITY = -1000;

    /**
     * MVC event to listen
     */
    const EVENT_NAME = MvcEvent::EVENT_DISPATCH_ERROR;

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(static::EVENT_NAME, [$this, 'onDispatchError'], static::EVENT_PRIORITY);
    }

    /**
     * Callback used when a dispatch error occurs. Modifies the
     * response object with an according error if the application
     * event contains an exception related with authorization.
     *
     * @access private
     * @param MvcEvent $event
     * @return void
     */
    public function onDispatchError(MvcEvent $event)
    {
        $response = $event->getResponse();

        // Do nothing if there is no error in the event or the error
        // does not match one of our predefined errors (we don't want
        // our 403 template to handle other types of errors)
        // or if response is not HTTP response
        if (!($event->getParam('exception') instanceof UnauthorizedException)
            || $event->getError() !== GuardInterface::ERROR_UNAUTHORIZED
            || $event->getResult() instanceof HttpResponse
            || ($response && !$response instanceof HttpResponse)
        ) {
            return;
        }

        $this->onError($event);
    }

    /**
     * Callback used when a dispatch error occurs. Modifies the
     * response object with an according error if the application
     * event contains an exception related with authorization.
     *
     * @access private
     * @param MvcEvent $event
     * @return void
     */
    abstract public function onError(MvcEvent $event);
}

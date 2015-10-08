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
    Zend\Mvc\MvcEvent,
    Zend\View\Model\ViewModel,
    CmsPermissions\Identity\ProviderInterface as IdentityProviderInterface,
    CmsAuthorization\Options\ModuleOptionsInterface;

/**
 * Dispatch error handler, catches exceptions related with authorization and
 * configures the application response accordingly.
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class UnauthorizedStrategy extends AbstractStrategy
{
    /**
     * @var ModuleOptionsInterface
     */
    protected $options;

    /**
     * @var string
     */
    protected $template;

    /**
     * __construct
     *
     * @param ModuleOptionsInterface $options
     * @param string $template 
     */
    public function __construct(ModuleOptionsInterface $options, $template = null)
    {
        $this->options = $options;
        if (null !== $template) {
            $this->setTemplate($template);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function onError(MvcEvent $event)
    {
        $model = new ViewModel($event->getParams());

        if (!$event->getParam('identity')) {
            /* @var $services \Zend\ServiceManager\ServiceLocatorInterface */
            $services = $event->getApplication()->getServiceManager();
            /* @var $provider IdentityProviderInterface */
            $provider = $services->get(IdentityProviderInterface::class);

            $model->setVariable('identity', $provider->getIdentity());
        }

        $model->setTemplate($this->getTemplate() ?: $this->options->getTemplate());

        $response = $event->getResponse() ?: new HttpResponse();
        $response->setStatusCode(403);

        $event->setResponse($response);
        $event->getViewModel()->addChild($model);
    }

    /**
     * @param string $template
     * @return self
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}

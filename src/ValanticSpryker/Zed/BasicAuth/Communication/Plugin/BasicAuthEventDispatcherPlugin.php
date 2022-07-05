<?php declare(strict_types = 1);

namespace ValanticSpryker\Zed\BasicAuth\Communication\Plugin;

use Pyz\Shared\BasicAuth\BasicAuthConstants;
use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\EventDispatcher\EventDispatcherInterface;
use Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @method \ValanticSpryker\Zed\BasicAuth\Business\BasicAuthFacade getFacade()
 * @method \ValanticSpryker\Zed\BasicAuth\BasicAuthConfig getConfig()
 */
class BasicAuthEventDispatcherPlugin extends AbstractPlugin implements EventDispatcherPluginInterface
{
    use LoggerTrait;

    /**
     * @inheritDoc
     */
    public function extend(
        EventDispatcherInterface $eventDispatcher,
        ContainerInterface $container
    ): EventDispatcherInterface {
        $eventDispatcher->addListener(KernelEvents::REQUEST, function (RequestEvent $event): RequestEvent {
            return $this->onKernelRequest($event);
        });

        return $eventDispatcher;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     *
     * @return \Symfony\Component\HttpKernel\Event\RequestEvent
     */
    protected function onKernelRequest(RequestEvent $event): RequestEvent
    {
        $request = $event->getRequest();

        if (
            $request->attributes->get('controller') === null
            || $this->authorize($request)
        ) {
            return $event;
        }

        $this->logInvalidLoginTry($request);

        $event->setResponse($this->getErrorResponse($request));

        return $event;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function logInvalidLoginTry(Request $request): void
    {
        $this->getLogger()->warning(
            'Basic Auth credentials invalid',
            [
                'module' => $request->attributes->get('module'),
                'controller' => $request->attributes->get('controller'),
                'action' => $request->attributes->get('action'),
                'username' => $request->getUser(),
            ]
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function getErrorResponse(Request $request): JsonResponse
    {
        $responseMessage= BasicAuthConstants::UNAUTHORIZED_ACCESS . ': ' . $request->getSchemeAndHttpHost();

        return new JsonResponse($responseMessage, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return bool
     */
    private function authorize(Request $request): bool
    {
        $controller = $request->attributes->get('_controller');

        return $this->getFacade()->authorize(
            $request->attributes->get('module'),
            $request->attributes->get('controller'),
            $request->attributes->get('action'),
            $request->getUser(),
            $request->getPassword()
        );
    }
}

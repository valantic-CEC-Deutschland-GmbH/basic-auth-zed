<?php declare(strict_types = 1);

namespace ValanticSprykerTest\Zed\BasicAuth\Integration\Communication\Plugin;

use Codeception\Test\Unit;
use Codeception\Util\HttpCode;
use Mockery;
use ValanticSpryker\Zed\BasicAuth\Business\BasicAuthFacade;
use ValanticSpryker\Zed\BasicAuth\Communication\Plugin\BasicAuthEventDispatcherPlugin;
use Spryker\Shared\EventDispatcher\EventDispatcher;
use Spryker\Zed\Kernel\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * @group Integration
 * @group BasicAuth
 */
class BasicAuthEventDispatcherPluginTest extends Unit
{
    /**
     * @return void
     */
    public function testOnKernelRequestWithPositiveAuthorization(): void
    {
        $module = 'test-module';
        $controller = 'test-controller';
        $action = 'test-action';
        $username = 'testusername';
        $password = 'testpassword';

        $listenerClosure = null;

        $eventDispatcherMock = Mockery::mock(EventDispatcher::class);
        $eventDispatcherMock->shouldReceive('addListener')
            ->with(Mockery::any(), Mockery::capture($listenerClosure));

        $facadeMock = Mockery::mock(BasicAuthFacade::class);
        $facadeMock->shouldReceive('authorize')
            ->once()
            ->with($module, $controller, $action, $username, $password)
            ->andReturns(true);

        $request = new Request(
            [],
            [],
            [
                'module' => $module,
                'controller' => $controller,
                'action' => $action,
            ],
            [],
            [],
            [
                'PHP_AUTH_USER' => $username,
                'PHP_AUTH_PW' => $password,
            ]
        );

        $eventMock = Mockery::mock(RequestEvent::class);
        $eventMock->makePartial();

        $eventMock->shouldReceive('getRequest')
            ->andReturns($request);

        $sut = new BasicAuthEventDispatcherPlugin();
        $sut->setFacade($facadeMock);

        $sut->extend($eventDispatcherMock, new Container());

        /**
         * @var \Closure $listenerClosure
         * @var \Symfony\Component\HttpKernel\Event\RequestEvent $requestEvent
         */
        $requestEvent = $listenerClosure($eventMock);

        $this->assertFalse($requestEvent->hasResponse());
    }

    /**
     * @return void
     */
    public function testOnKernelRequestNegativeAuthorization(): void
    {
        $listenerClosure = null;

        $eventDispatcherMock = Mockery::mock(EventDispatcher::class);
        $eventDispatcherMock->shouldReceive('addListener')
            ->with(Mockery::any(), Mockery::capture($listenerClosure));

        $facadeMock = Mockery::mock(BasicAuthFacade::class);
        $facadeMock->shouldReceive('authorize')
            ->once()
            ->withAnyArgs()
            ->andReturns(false);

        $request = new Request(
            [],
            [],
            [
                'module' => 'test',
                'controller' => 'test',
                'action' => 'test',
            ]
        );

        $eventMock = Mockery::mock(RequestEvent::class);
        $eventMock->makePartial();

        $eventMock->shouldReceive('getRequest')
            ->andReturns($request);

        $sut = new BasicAuthEventDispatcherPlugin();
        $sut->setFacade($facadeMock);

        $sut->extend($eventDispatcherMock, new Container());

        /**
         * @var \Closure $listenerClosure
         * @var \Symfony\Component\HttpKernel\Event\RequestEvent $requestEvent
         */
        $requestEvent = $listenerClosure($eventMock);

        $response = $requestEvent->getResponse();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(HttpCode::UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testOnKernelWithInvalidRequest(): void
    {
        $listenerClosure = null;

        $eventDispatcherMock = Mockery::mock(EventDispatcher::class);
        $eventDispatcherMock->shouldReceive('addListener')
            ->with(Mockery::any(), Mockery::capture($listenerClosure));

        $facadeMock = Mockery::mock(BasicAuthFacade::class);
        $facadeMock->shouldReceive('authorize')
            ->never();

        $request = new Request(
            [],
            [],
            [
                'module' => null,
                'controller' => null,
                'action' => null,
            ]
        );

        $eventMock = Mockery::mock(RequestEvent::class);
        $eventMock->makePartial();

        $eventMock->shouldReceive('getRequest')
            ->andReturns($request);

        $sut = new BasicAuthEventDispatcherPlugin();
        $sut->setFacade($facadeMock);

        $sut->extend($eventDispatcherMock, new Container());

        /**
         * @var \Closure $listenerClosure
         * @var \Symfony\Component\HttpKernel\Event\RequestEvent $requestEvent
         */
        $requestEvent = $listenerClosure($eventMock);

        $response = $requestEvent->getResponse();

        $this->assertNull($response);
        $this->assertSame($requestEvent, $eventMock);
    }
}

<?php declare(strict_types = 1);

namespace ValanticSprykerTest\Zed\BasicAuth\Integration\Business\Processor;

use Pyz\Shared\BasicAuth\BasicAuthConstants;
use Pyz\Zed\BasicAuth\Business\BasicAuthFacade;
use Pyz\Zed\BasicAuth\Business\Processor\Exception\InvalidBasicAuthConfigException;
use PyzTest\Shared\Base\AbstractTest;
use PyzTest\Zed\BasicAuth\BasicAuthTester;

/**
 * @group Integration
 * @group BasicAuth
 */
class BasicAuthProcessorTest extends AbstractTest
{
    protected BasicAuthTester $tester;

    /**
     * @return array
     */
    public function invalidConfigThrowsExceptionDataProvider(): array
    {
        return [
            'no module' => [
                'config' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
            ],
            'no controller' => [
                'config' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
            ],
            'no action' => [
                'config' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
            ],
            'no username' => [
                'config' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
            ],
            'no password' => [
                'config' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidConfigThrowsExceptionDataProvider
     *
     * @param array $config
     *
     * @return void
     */
    public function testInvalidConfigThrowsException(array $config): void
    {
        $this->tester->setConfig(
            BasicAuthConstants::CONFIG_KEY_ROUTE_CONFIGS,
            [
                'test_config' => $config,
            ]
        );

        $this->expectException(InvalidBasicAuthConfigException::class);

        $sut = new BasicAuthFacade();
        $sut->authorize('bla', 'bli', 'blubb', 'blo', 'blu');
    }
}

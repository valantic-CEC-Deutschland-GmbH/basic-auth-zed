<?php declare(strict_types = 1);

namespace ValanticSprykerTest\Zed\BasicAuth\Integration\Business;

use Pyz\Shared\BasicAuth\BasicAuthConstants;
use Pyz\Zed\BasicAuth\Business\BasicAuthFacade;
use PyzTest\Shared\Base\AbstractTest;
use PyzTest\Zed\BasicAuth\BasicAuthTester;

/**
 * @group Integration
 * @group BasicAuth
 */
class BasicAuthFacadeTest extends AbstractTest
{
    protected BasicAuthTester $tester;

    /**
     * @return array
     */
    public function authorizeDataProvider(): array
    {
        return [
            'valid credentials for the right endpoint' => [
                'config_values' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
                'arguments' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
                'expected result' => true,
            ],
            'invalid credentials for the right endpoint' => [
                'config_values' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
                'arguments' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'wrong username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'wrong password',
                ],
                'expected result' => false,
            ],
            'no credentials for the right endpoint' => [
                'config_values' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
                'arguments' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => null,
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => null,
                ],
                'expected result' => false,
            ],
            'valid credentials for the wrong endpoint' => [
                'config_values' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
                'arguments' => [
                    BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE => 'test-module2',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER => 'test-controller',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION => 'test-action',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME => 'test username',
                    BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD => 'test password',
                ],
                'expected result' => true,
            ],
        ];
    }

    /**
     * @dataProvider authorizeDataProvider
     *
     * @param array $config
     * @param array $arguments
     * @param bool $expectedResult
     *
     * @return void
     */
    public function testValidCredentials(array $config, array $arguments, bool $expectedResult): void
    {
        if (!empty($config)) {
            $this->tester->setConfig(BasicAuthConstants::CONFIG_KEY_ROUTE_CONFIGS, [
                'test_config' => $config,
            ]);
        }

        $sut = new BasicAuthFacade();
        $result = $sut->authorize(
            $arguments[BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE],
            $arguments[BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER],
            $arguments[BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION],
            $arguments[BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME],
            $arguments[BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD],
        );

        $this->assertSame($expectedResult, $result);
    }
}

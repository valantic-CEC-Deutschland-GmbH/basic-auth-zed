<?php declare(strict_types = 1);

namespace ValanticSpryker\Zed\BasicAuth\Business\Processor;

use Pyz\Shared\BasicAuth\BasicAuthConstants;
use Pyz\Zed\BasicAuth\BasicAuthConfig;
use Pyz\Zed\BasicAuth\Business\Processor\Exception\InvalidBasicAuthConfigException;

class BasicAuthProcessor implements BasicAuthProcessorInterface
{
    /**
     * @var \Pyz\Zed\BasicAuth\BasicAuthConfig
     */
    private BasicAuthConfig $config;

    /**
     * @param \Pyz\Zed\BasicAuth\BasicAuthConfig $config
     */
    public function __construct(BasicAuthConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function authorize(
        string $module,
        string $controller,
        string $action,
        ?string $username,
        ?string $password
    ): bool {
        $this->validateRouteConfigurations();

        $routeConfig = $this->getMatchingRouteConfigEntry($module, $controller, $action);
        if ($routeConfig === null) {
            return true;
        }

        return $this->validateCredentials($username, $password, $routeConfig);
    }

    /**
     * @throws \Pyz\Zed\BasicAuth\Business\Processor\Exception\InvalidBasicAuthConfigException
     *
     * @return void
     */
    private function validateRouteConfigurations(): void
    {
        $routeConfigs = $this->config->getRouteConfigurations();

        foreach ($routeConfigs as $routeConfigName => $routeConfig) {
            if (
                !isset(
                    $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE],
                    $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER],
                    $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION],
                    $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME],
                    $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD]
                )
            ) {
                throw new InvalidBasicAuthConfigException(
                    sprintf(
                        'Basic auth configuration with name "%s" misses one or more config entries.',
                        $routeConfigName
                    )
                );
            }
        }
    }

    /**
     * @param string $module
     * @param string $controller
     * @param string $action
     *
     * @return array|null
     */
    private function getMatchingRouteConfigEntry(string $module, string $controller, string $action): ?array
    {
        $routeConfigs = $this->config->getRouteConfigurations();

        foreach ($routeConfigs as $routeConfig) {
            if (
                $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_MODULE] === $module
                && $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_CONTROLLER] === $controller
                && $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_ACTION] === $action
            ) {
                return $routeConfig;
            }
        }

        return null;
    }

    /**
     * @param string|null $user
     * @param string|null $password
     * @param array $routeConfig
     *
     * @return bool
     */
    private function validateCredentials(?string $user, ?string $password, array $routeConfig): bool
    {
        if ($user === null || $password === null) {
            return false;
        }

        return $user === $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_USERNAME]
            && $password === $routeConfig[BasicAuthConstants::ROUTE_CONFIG_KEY_PASSWORD];
    }
}

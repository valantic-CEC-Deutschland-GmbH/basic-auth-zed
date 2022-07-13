<?php declare(strict_types = 1);

namespace ValanticSpryker\Zed\BasicAuth;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use ValanticSpryker\Shared\BasicAuth\BasicAuthConstants;

class BasicAuthConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getRouteConfigurations(): array
    {
        return $this->get(BasicAuthConstants::CONFIG_KEY_ROUTE_CONFIGS, []);
    }
}

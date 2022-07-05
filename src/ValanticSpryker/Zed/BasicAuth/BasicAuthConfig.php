<?php declare(strict_types = 1);

namespace ValanticSpryker\Zed\BasicAuth;

use Pyz\Shared\BasicAuth\BasicAuthConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

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

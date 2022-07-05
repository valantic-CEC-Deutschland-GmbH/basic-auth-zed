<?php declare(strict_types = 1);

namespace ValanticSpryker\Zed\BasicAuth\Business;

use Pyz\Zed\BasicAuth\Business\Processor\BasicAuthProcessor;
use Pyz\Zed\BasicAuth\Business\Processor\BasicAuthProcessorInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\BasicAuth\BasicAuthConfig getConfig()
 */
class BasicAuthBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\BasicAuth\Business\Processor\BasicAuthProcessorInterface
     */
    public function createBasicAuthProcessor(): BasicAuthProcessorInterface
    {
        return new BasicAuthProcessor($this->getConfig());
    }
}

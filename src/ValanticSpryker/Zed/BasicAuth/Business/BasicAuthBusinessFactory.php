<?php declare(strict_types = 1);

namespace ValanticSpryker\Zed\BasicAuth\Business;

use ValanticSpryker\Zed\BasicAuth\Business\Processor\BasicAuthProcessor;
use ValanticSpryker\Zed\BasicAuth\Business\Processor\BasicAuthProcessorInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \ValanticSpryker\Zed\BasicAuth\BasicAuthConfig getConfig()
 */
class BasicAuthBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \ValanticSpryker\Zed\BasicAuth\Business\Processor\BasicAuthProcessorInterface
     */
    public function createBasicAuthProcessor(): BasicAuthProcessorInterface
    {
        return new BasicAuthProcessor($this->getConfig());
    }
}

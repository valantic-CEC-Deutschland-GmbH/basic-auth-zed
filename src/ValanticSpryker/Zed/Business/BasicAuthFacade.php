<?php declare(strict_types = 1);

namespace ValanticSpryker\Zed\BasicAuth\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\BasicAuth\Business\BasicAuthBusinessFactory getFactory()
 */
class BasicAuthFacade extends AbstractFacade implements BasicAuthFacadeInterface
{
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
        return $this->getFactory()
            ->createBasicAuthProcessor()
            ->authorize($module, $controller, $action, $username, $password);
    }
}

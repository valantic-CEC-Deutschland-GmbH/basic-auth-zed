<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\BasicAuth\Business;

/**
 * @method \SprykerValantic\Zed\BasicAuth\Business\BasicAuthBusinessFactory getFactory()
 */
interface BasicAuthFacadeInterface
{
    /**
     * @param string $module
     * @param string $controller
     * @param string $action
     * @param string|null $username
     * @param string|null $password
     *
     * @return bool
     */
    public function authorize(
        string $module,
        string $controller,
        string $action,
        ?string $username,
        ?string $password
    ): bool;
}

<?php

declare(strict_types = 1);

namespace ValanticSpryker\Shared\BasicAuth;

class BasicAuthConstants
{
    /**
     * @var string
     */
    public const CONFIG_KEY_ROUTE_CONFIGS = 'BASIC_AUTH:ROUTE_CONFIGS';

    /**
     * @var string
     */
    public const ROUTE_CONFIG_KEY_MODULE = 'module';

    /**
     * @var string
     */
    public const ROUTE_CONFIG_KEY_CONTROLLER = 'controller';

    /**
     * @var string
     */
    public const ROUTE_CONFIG_KEY_ACTION = 'action';

    /**
     * @var string
     */
    public const ROUTE_CONFIG_KEY_USERNAME = 'username';

    /**
     * @var string
     */
    public const ROUTE_CONFIG_KEY_PASSWORD = 'password';

    /**
     * @var string
     */
    public const UNAUTHORIZED_ACCESS = 'Unauthorized access';
}

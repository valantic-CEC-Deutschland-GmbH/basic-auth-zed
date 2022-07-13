<?php

declare(strict_types = 1);

namespace ValanticSpryker\Shared\BasicAuth;

class BasicAuthConstants
{
    public const CONFIG_KEY_ROUTE_CONFIGS = 'BASIC_AUTH:ROUTE_CONFIGS';
    public const ROUTE_CONFIG_KEY_MODULE = 'module';
    public const ROUTE_CONFIG_KEY_CONTROLLER = 'controller';
    public const ROUTE_CONFIG_KEY_ACTION = 'action';
    public const ROUTE_CONFIG_KEY_USERNAME = 'username';
    public const ROUTE_CONFIG_KEY_PASSWORD = 'password';
    public const UNAUTHORIZED_ACCESS = 'Unauthorized access';
}

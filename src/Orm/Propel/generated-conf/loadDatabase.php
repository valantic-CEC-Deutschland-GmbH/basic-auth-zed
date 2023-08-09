<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'zed' => 
  array (
    'tablesByName' => 
    array (
      'spy_currency' => '\\Orm\\Zed\\Currency\\Persistence\\Map\\SpyCurrencyTableMap',
      'spy_locale' => '\\Orm\\Zed\\Locale\\Persistence\\Map\\SpyLocaleTableMap',
      'spy_queue_process' => '\\Orm\\Zed\\Queue\\Persistence\\Map\\SpyQueueProcessTableMap',
      'spy_store' => '\\Orm\\Zed\\Store\\Persistence\\Map\\SpyStoreTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\SpyCurrency' => '\\Orm\\Zed\\Currency\\Persistence\\Map\\SpyCurrencyTableMap',
      '\\SpyLocale' => '\\Orm\\Zed\\Locale\\Persistence\\Map\\SpyLocaleTableMap',
      '\\SpyQueueProcess' => '\\Orm\\Zed\\Queue\\Persistence\\Map\\SpyQueueProcessTableMap',
      '\\SpyStore' => '\\Orm\\Zed\\Store\\Persistence\\Map\\SpyStoreTableMap',
    ),
  ),
));

<?php

declare(strict_types = 1);

namespace Zed\BaiscAuth\Business;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\Container;
use ValanticSpryker\Zed\BasicAuth\BasicAuthConfig;
use ValanticSpryker\Zed\BasicAuth\Business\BasicAuthBusinessFactory;
use ValanticSpryker\Zed\BasicAuth\Business\Processor\BasicAuthProcessor;

/**
 * Auto-generated group annotations
 *
 * @group ValanticSprykerTest
 * @group Glue
 * @group UrlsRestApi
 * Add your own group annotations below this line
 */
class BasicAuthBusinessFactoryTest extends Unit
{
  /**
   * @return void
   */
    protected function _before(): void
    {
        parent::_before();
    }

  /**
   * @return void
   */
    public function testCreateElasticsearchClientFactory(): void
    {
      $basicAuthBusinessFactoryMock = $this->getMockBuilder(BasicAuthBusinessFactory::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['getConfig'])
        ->getMock();

      $basicAuthBusinessFactoryMock->expects(static::atLeastOnce())
        ->method('getConfig')
        ->willReturn(new BasicAuthConfig());

      $this->assertInstanceOf(BasicAuthProcessor::class,
          ($basicAuthBusinessFactoryMock)
            ->createBasicAuthProcessor()
        );
    }
}

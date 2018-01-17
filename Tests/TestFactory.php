<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-17
 * Time: 上午10:14
 */

namespace mmxs\Bundle\CommandLogBundle\Tests;

use mmxs\Bundle\CommandLogBundle\Model\ApiHandler;
use mmxs\Bundle\CommandLogBundle\Model\Factory;
use mmxs\Bundle\CommandLogBundle\Model\LoggerHandler;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\Container;

class TestFactory extends TestCase
{
    public function test1()
    {
        $container = new Container();
        $logger    = new ApiHandler([]);
        $container->set('test1234', $logger);
        $container->set('logger', new NullLogger());

        $this->assertTrue($container->has('test1234'));

        $factory = new Factory($container);

        $obj = $factory->create(['type' => 'test1234']);
        $this->assertSame($obj, $logger);

        $this->assertInstanceOf(ApiHandler::class, $factory->create(['type' => 'api']));

        $this->assertInstanceOf(LoggerHandler::class, $factory->create(['type' => 'logger']));

    }
}
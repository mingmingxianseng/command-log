<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-12
 * Time: 下午5:35
 */

namespace mmxs\Bundle\CommandLogBundle\Model;


use Psr\Container\ContainerInterface;

class Factory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * create
     * @author chenmingming
     * @param array $option
     * @return HandlerInterface
     */
    public function create(array $option)
    {
        switch ($option['type']) {
            case 'api':
                return new ApiHandler($option);
            default:
                return new LoggerHandler($this->container->get('logger'));
        }
    }
}
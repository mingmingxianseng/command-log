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
     *
     * @author chenmingming
     *
     * @param array $option
     *
     * @return HandlerInterface
     */
    public function create(array $option)
    {
        switch ($option['type']) {
            case 'api':
                return new ApiHandler($option);
            case 'logger':
                return new LoggerHandler($this->container->get('logger'));
            default:

                if ($this->container->has($option['type'])
                    && $this->container->get($option['type']) instanceof HandlerInterface
                ) {
                    return $this->container->get($option['type']);
                }
                throw new \InvalidArgumentException("type is invalid.[{$option['type']}]");
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-12
 * Time: 下午3:05
 */

namespace mmxs\Bundle\CommandLogBundle\Model;


use Psr\Log\LoggerInterface;

class LoggerHandler implements HandlerInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handleStart(string $token, array $data)
    {
        $this->logger->info("command start. [{$token}]", $data);
    }

    public function handleError(string $token, array $data)
    {
        $this->logger->error("command error. [{$token}]", $data);
    }

    public function handleTerminate(string $token, array $data)
    {
        $this->logger->info("command terminate. [{$token}]", $data);
    }

}
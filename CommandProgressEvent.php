<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-16
 * Time: 下午4:16
 */

namespace mmxs\Bundle\CommandLogBundle;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Console\Command\Command;

class CommandProgressEvent extends Event
{
    private $command;
    /** @var  int */
    private $percentage;
    private $data = [];

    public function __construct(Command $command, $percentage = 0, array $data = [])
    {
        $this->command    = $command;
        $this->percentage = $percentage;
        $this->data       = $data;
    }

    /**
     * @return Command
     */
    public function getCommand(): Command
    {
        return $this->command;
    }

    /**
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
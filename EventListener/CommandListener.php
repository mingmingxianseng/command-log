<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-11
 * Time: 下午4:37
 */

namespace mmxs\Bundle\CommandLogBundle\EventListener;


use mmxs\Bundle\CommandLogBundle\Model\Factory;
use mmxs\Bundle\CommandLogBundle\Model\HandlerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandListener implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    private $options = [
        'namespace' => 'command.log',
        'handler' => [
            'type' => 'logger'
        ]
    ];

    /**
     * @var HandlerInterface
     */
    private $handler;

    static private $tokens;

    /**
     * CommandListener constructor.
     * @param array $options
     * @param LoggerInterface $logger
     * @param Factory $factory
     */
    public function __construct($options = [], LoggerInterface $logger, Factory $factory)
    {
        $this->logger = $logger;
        $this->options = array_merge($this->options, $options);
        $this->handler = $factory->create($this->options['handler']);

    }

    private function getKey(Command $command)
    {
        return $this->options['namespace'] . $command->getName();
    }

    /**
     * onCommandStart
     * @author chenmingming
     * @param ConsoleCommandEvent $event
     */
    public function onCommandStart(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();
        $input = $event->getInput();

        $key = $this->getKey($command);
        if (!isset(self::$tokens[$key])) {
            self::$tokens[$key] = uniqid();
        }
        $commandStr = 'php bin/console ' . implode(" ", $input->getArguments());
        foreach ($input->getOptions() as $k => $v) {
            if ($v === false)
                continue;
            $commandStr .= " --" . $k;
            $v && $commandStr .= "={$v}";
        }

        $data = [
            'name' => $command->getName(),
            'description' => $command->getDescription(),
            'namespace' => $this->options['namespace'],
            'command' => $commandStr,
            'env' => PHP_SAPI
        ];
        $this->logger->info('command data', ['data' => $data]);
        $this->handler->handleStart(self::$tokens[$key], $data);
    }

    public function onCommandTerminate(ConsoleTerminateEvent $event)
    {
        $key = $this->getKey($event->getCommand());
        if (!isset(self::$tokens[$key])) {
            return;
        }
        $this->logger->info('exitCode:' . $event->getExitCode(), ['']);
        $this->handler->handleTerminate(self::$tokens[$key], [
            'memory_usage' => memory_get_usage(true),
            'memory_peak_usage' => memory_get_peak_usage(true)
        ]);
    }

    public function onCommandError(ConsoleErrorEvent $event)
    {
        $key = $this->getKey($event->getCommand());
        if (!isset(self::$tokens[$key])) {
            return;
        }
        $this->logger->error($event->getError()->__toString(), ['content']);
        $this->handler->handleError(self::$tokens[$key], [
            'exception' => $event->getError()->__toString()
        ]);
    }

    public static function getSubscribedEvents()
    {
        if (!class_exists(ConsoleEvents::class)) {
            return [];
        }
        // Register early to have a working dump() as early as possible
        return [
            ConsoleEvents::COMMAND => 'onCommandStart',
            ConsoleEvents::TERMINATE => 'onCommandTerminate',
            ConsoleEvents::ERROR => 'onCommandError'
        ];
    }

}
<?php

declare(strict_types=1);

namespace Meetup\Event;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\SharedEventManager;

/**
 * Class Database
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class Database implements ListenerAggregateInterface
{

    /**
     * @param \Zend\EventManager\EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        /** @var SharedEventManager $sharedManager */
        $sharedManager = $events->getSharedManager();

        $sharedManager->attach(DatabaseInterface::class, 'before_add', [$this, 'onBeforeAdd'], $priority);
    }

    /**
     * @param \Zend\EventManager\EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        $events->getSharedManager()->clearListeners(DatabaseInterface::class);
    }

    /**
     * @param EventInterface $event
     */
    public function onBeforeAdd(EventInterface $event)
    {
        file_put_contents('/tmp/zend.log', 'rftghyujikol' . PHP_EOL, FILE_APPEND);
    }
}
<?php

declare(strict_types=1);

namespace Meetup\Event;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Class Database
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class Database implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    private $listeners = [];

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param \Zend\EventManager\EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('before_add', [$this, 'onBeforeAdd'], $priority);
        $this->listeners[] = $events->attach('event_test', [$this, 'onEventTest'], $priority);
    }

    /**
     * Detach all previously attached listeners
     *
     * @param \Zend\EventManager\EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    /**
     * @param EventInterface $event
     */
    public function onBeforeAdd(EventInterface $event)
    {
        file_put_contents('/tmp/zend.log', 'rftghyujikol'. PHP_EOL, FILE_APPEND);
    }

    /**
     * @param EventInterface $event
     */
    public function onEventTest(EventInterface $event){
        file_put_contents('/tmp/zend.log', 'TEST EVENT'. PHP_EOL, FILE_APPEND);
    }
}
<?php

declare(strict_types=1);

namespace Meetup\Event;

use Meetup\Entity\Meetup;
use Zend\Log\LoggerInterface;
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Database constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

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
        $sharedManager->attach(DatabaseInterface::class, 'before_delete', [$this, 'onBeforeDelete'], $priority);
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
        /** @var Meetup $meetup */
        $meetup = $event->getParam('entity');

        $this->logger->info("New meetup : " . $meetup->getTitle());
    }

    /**
     * @param EventInterface $event
     */
    public function onBeforeDelete(EventInterface $event)
    {
        /** @var Meetup $meetup */
        $meetup = $event->getParam('entity');

        $this->logger->info("Deleted meetup : " . $meetup->getTitle());
    }
}
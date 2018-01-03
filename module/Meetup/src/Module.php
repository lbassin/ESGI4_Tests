<?php

declare(strict_types=1);

namespace Meetup;

use Meetup\Event\DatabaseInterface as DatabaseEventInterface;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Module
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class Module
{
    /**
     *
     */
    const VERSION = '1.0.0';

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @param Event $event
     */
    public function onBootstrap(Event $event)
    {
        /** @var Application $application */
        $application = $event->getTarget();
        /** @var EventManager $eventManager */
        $eventManager = $application->getEventManager();
        /** @var ServiceManager $serviceManager */
        $serviceManager = $application->getServiceManager();
        /** @var ListenerAggregateInterface $listener */
        $listener = $serviceManager->get(DatabaseEventInterface::class);

        $listener->attach($eventManager);
    }

}

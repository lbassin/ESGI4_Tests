<?php

declare(strict_types=1);

namespace Meetup\Controller\Factory;

use Interop\Container\ContainerInterface;
use Meetup\Controller\MeetupController;
use Meetup\Form\MeetupFormInterface;
use Meetup\Repository\MeetupRepositoryInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class MeetupControllerFactory
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class MeetupControllerFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return MeetupController|object
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): MeetupController
    {
        /** @var MeetupRepositoryInterface $meetupRepository */
        $meetupRepository = $container->get(MeetupRepositoryInterface::class);
        /** @var MeetupFormInterface $meetupForm */
        $meetupForm = $container->get(MeetupFormInterface::class);
        /** @var EventManagerInterface $eventManager */
        $eventManager = $container->get(EventManagerInterface::class);

        return new MeetupController($meetupRepository, $meetupForm, $eventManager);
    }
}

<?php

namespace Meetup\Controller\Factory;

use Doctrine\ORM\EntityManager;
use Meetup\Controller\MeetupController;
use Meetup\Entity\Meetup;
use Psr\Container\ContainerInterface;

class MeetupControllerFactory
{

    /**
     * @param ContainerInterface $container
     * @return MeetupController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): MeetupController
    {
        $entityManager = $container->get(EntityManager::class);
        $meetupRepository = $entityManager->getRepository(Meetup::class);

        return new MeetupController($meetupRepository);
    }

}
<?php

namespace Meetup\Controller\Factory;

use Doctrine\ORM\EntityManager;
use Meetup\Controller\MeetupController;
use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Meetup\Repository\MeetupRepository;
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
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        /** @var MeetupRepository $meetupRepository */
        $meetupRepository = $entityManager->getRepository(Meetup::class);

        /** @var MeetupForm $meetupForm */
        $meetupForm = $container->get(MeetupForm::class);

        return new MeetupController($meetupRepository, $meetupForm);
    }

}
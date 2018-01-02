<?php

declare(strict_types=1);

namespace Meetup\Repository\Factory;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Interop\Container\ContainerInterface;
use Meetup\Entity\Meetup;
use Meetup\Repository\MeetupRepository;
use Meetup\Repository\MeetupRepositoryInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class MeetupRepositoryFactory
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class MeetupRepositoryFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return MeetupRepository|object
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): MeetupRepositoryInterface
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        /** @var ClassMetadata $classMetadata */
        $classMetadata = $entityManager->getClassMetadata(Meetup::class);
        /** @var EventManagerInterface $eventManager */
        $eventManager = $container->get(EventManagerInterface::class);

        return new MeetupRepository($entityManager, $classMetadata, $eventManager);
    }
}

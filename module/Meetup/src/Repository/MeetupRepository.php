<?php

declare(strict_types=1);

namespace Meetup\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Meetup\Entity\Meetup;
use Meetup\Event\DatabaseInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Class MeetupRepository
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class MeetupRepository extends EntityRepository implements MeetupRepositoryInterface
{
    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * MeetupRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param Mapping\ClassMetadata $class
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        Mapping\ClassMetadata $class,
        EventManagerInterface $eventManager
    )
    {
        $this->eventManager = $eventManager;
        $this->eventManager->setIdentifiers([DatabaseInterface::class]);

        parent::__construct($entityManager, $class);
    }

    /**
     * @inheritdoc
     */
    public function add(Meetup $meetup): void
    {
        $this->eventManager->trigger('before_add', $this, ['entity' => $meetup]);

        $this->getEntityManager()->persist($meetup);
        $this->getEntityManager()->flush($meetup);

        $this->eventManager->trigger('after_add', $this, ['entity' => $meetup]);
    }

    /**
     * @inheritdoc
     */
    public function deleteById(string $id): void
    {
        /** @var Meetup $meetup */
        $meetup = $this->find($id);

        $this->eventManager->trigger('before_delete', $this, ['entity' => $meetup]);

        $this->getEntityManager()->remove($meetup);
        $this->getEntityManager()->flush();

        $this->eventManager->trigger('after_delete', $this, ['entity' => $meetup]);
    }

    /**
     * @inheritdoc
     */
    public function save($data): void
    {
        $meetup = new Meetup();

        /** @var DoctrineHydrator $hydrator */
        $hydrator = new DoctrineHydrator($this->getEntityManager());
        $hydrator->hydrate($data, $meetup);

        $this->add($meetup);
    }
}

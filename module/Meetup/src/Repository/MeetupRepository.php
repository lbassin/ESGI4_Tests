<?php

namespace Meetup\Repository;

use Doctrine\ORM\EntityRepository;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Meetup\Entity\Meetup;

/**
 * Class MeetupRepository
 * @author Laurent Bassin <laurent@bassin.info>
 *
 */
class MeetupRepository extends EntityRepository implements MeetupRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function add(Meetup $meetup): void
    {
        $this->getEntityManager()->persist($meetup);
        $this->getEntityManager()->flush($meetup);
    }

    /**
     * @inheritdoc
     */
    public function deleteById(string $id): void
    {
        /** @var Meetup $meetup */
        $meetup = $this->find($id);

        $this->getEntityManager()->remove($meetup);
        $this->getEntityManager()->flush();
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
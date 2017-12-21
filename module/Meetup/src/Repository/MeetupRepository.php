<?php

namespace Meetup\Repository;

use Doctrine\ORM\EntityRepository;
use Meetup\Entity\Meetup;

/**
 * Class MeetupRepository
 * @package Meetup\Repository
 */
class MeetupRepository extends EntityRepository
{
    /**
     * @param $meetup
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add($meetup): void
    {
        $this->getEntityManager()->persist($meetup);
        $this->getEntityManager()->flush($meetup);
    }
}
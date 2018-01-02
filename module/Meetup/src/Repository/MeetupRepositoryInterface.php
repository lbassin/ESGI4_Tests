<?php

namespace Meetup\Repository;

use Meetup\Entity\Meetup;


/**
 * Interface MeetupRepositoryInterface
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
interface MeetupRepositoryInterface
{
    /**
     * @param Meetup $meetup
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Meetup $meetup): void;

    /**
     * @param string $id
     * @throws \Doctrine\ORM\ORMException
     */
    public function deleteById(string $id): void;

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($data): void;

    /**
     * @return array
     */
    public function findAll();

    /**
     * @param $id
     * @return object
     */
    public function find($id);
}
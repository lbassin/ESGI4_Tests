<?php

namespace Meetup\Repository;

use Meetup\Entity\Meetup;

/**
 * Interface MeetupRepositoryInterface
 * @package Meetup\Repository
 */
interface MeetupRepositoryInterface
{
    /**
     * @param Meetup $meetup
     */
    public function add(Meetup $meetup): void;

    /**
     * @param string $id
     * @throws \Doctrine\ORM\ORMException
     */
    public function deleteById(string $id): void;

    /**
     * @param $data
     */
    public function save($data): void;
}
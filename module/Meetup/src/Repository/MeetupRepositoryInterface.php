<?php

namespace Meetup\Repository;

use Meetup\Entity\Meetup;

interface MeetupRepositoryInterface
{
    public function add(Meetup $meetup): void;

    public function deleteById(string $id): void;

    public function save($data): void;
}
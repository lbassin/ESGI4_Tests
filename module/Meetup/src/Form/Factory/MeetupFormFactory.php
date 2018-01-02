<?php

namespace Meetup\Form\Factory;

use Meetup\Form\MeetupForm;
use Meetup\Form\MeetupFormInterface;
use Psr\Container\ContainerInterface;

class MeetupFormFactory
{
    /**
     * @param ContainerInterface $container
     * @return MeetupFormInterface
     */
    public function __invoke(ContainerInterface $container): MeetupFormInterface
    {
        return new MeetupForm();
    }
}
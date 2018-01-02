<?php

namespace Meetup\Form;

/**
 * Interface MeetupFormInterface
 * @package Meetup\Form
 */
interface MeetupFormInterface
{
    /**
     * MeetupFormInterface constructor.
     * @param string|null $name
     * @param array $options
     */
    public function __construct(string $name = null, array $options = []);

    /**
     * @return array
     */
    public function getInputFilterSpecification(): array;

}
<?php

namespace Meetup\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class MeetupForm extends Form
{
    /**
     * MeetupForm constructor.
     * @param string|null $name
     * @param array $options
     */
    public function __construct(string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'title',
            'options' => [
                'label' => 'Title : '
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'description',
            'options' => [
                'label' => 'Description : '
            ]
        ]);

        $this->add([
            'type' => Element\DateTimeSelect::class,
            'name' => 'startAt',
            'options' => [
                'label' => 'Date début :'
            ]
        ]);

        $this->add([
            'type' => Element\DateTimeSelect::class,
            'name' => 'endAt',
            'options' => [
                'label' => 'Date fin : ',
                'format' => 'd/m/Y'
            ]
        ]);

        $this->add([
            'type' => Element\Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Create Meeting'
            ],
            'options' => [
                'label' => ''
            ]
        ]);
    }
}
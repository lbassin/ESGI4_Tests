<?php

namespace Meetup\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Callback;
use Zend\Validator\StringLength;

class MeetupForm extends Form implements MeetupFormInterface, InputFilterProviderInterface
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
                'label' => 'Date début :',
                'min_year' => date('Y') - 0,
                'max_year' => date('Y') + 6,
            ]
        ]);

        $this->add([
            'type' => Element\DateTimeSelect::class,
            'name' => 'endAt',
            'options' => [
                'label' => 'Date fin : ',
                'format' => 'd/m/Y',
                'min_year' => date('Y') - 0,
                'max_year' => date('Y') + 6,
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

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification(): array
    {
        return [
            'title' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 2,
                            'max' => 50
                        ]
                    ]
                ]
            ],
            'description' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 2,
                            'max' => 2000,
                        ]
                    ]
                ]
            ],
            'endAt' => [
                'validators' => [
                    [
                        'name' => Validator\DateAfter::class,
                        'options' => [
                            'startDate' => $this->get('startAt')->getValue()
                        ]
                    ]
                ]
            ]
        ];
    }
}
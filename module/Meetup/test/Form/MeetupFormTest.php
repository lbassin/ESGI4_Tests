<?php

namespace MeetupTest\Form;

use Meetup\Form\MeetupForm;
use PHPUnit\Framework\TestCase;

/**
 * Class MeetupFormTest
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
class MeetupFormTest extends TestCase
{

    /**
     * @var MeetupForm
     */
    private $form;

    /**
     *
     */
    public function setUp()
    {
        $this->form = new MeetupForm();
    }

    /**
     *
     */
    private function getFieldsValues()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'startAt' => '2018-01-01 00:00:00',
            'endAt' => '2019-01-01 00:00:00'
        ];
    }

    /**
     *
     */
    public function testFieldsOk()
    {
        /** @var array $data */
        $data = $this->getFieldsValues();
        $this->form->setData($data);

        $this->assertTrue($this->form->isValid());
    }

    /**
     *
     */
    public function testMissingTitle()
    {
        /** @var array $data */
        $data = $this->getFieldsValues();
        unset($data['title']);

        $this->form->setData($data);

        $this->assertFalse($this->form->isValid());
    }

    /**
     *
     */
    public function testMissingDescription()
    {
        /** @var array $data */
        $data = $this->getFieldsValues();
        unset($data['description']);

        $this->form->setData($data);

        $this->assertFalse($this->form->isValid());
    }

    /**
     *
     */
    public function testMissingStartDate()
    {
        $this->expectException(\Exception::class);

        /** @var array $data */
        $data = $this->getFieldsValues();
        unset($data['startAt']);

        $this->form->setData($data);

        $this->form->isValid();
    }

    public function testMissingEndDate()
    {
        /** @var array $data */
        $data = $this->getFieldsValues();
        unset($data['endAt']);

        $this->form->setData($data);

        $this->assertFalse($this->form->isValid());
    }
}
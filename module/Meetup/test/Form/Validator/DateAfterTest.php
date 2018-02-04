<?php

namespace MeetupTest\Form\Validator;

use Meetup\Form\Validator\DateAfter;
use PHPUnit\Framework\TestCase;

/**
 * Class DateAfterTest
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
class DateAfterTest extends TestCase
{
    /**
     * @var DateAfter
     */
    protected $validator;

    /**
     *
     */
    public function setUp()
    {
        $this->validator = new DateAfter();
    }

    /**
     *
     */
    public function testEndAfterBegin()
    {
        $this->validator->setOptions(['startDate' => '2018-01-01 00:10:00']);
        /** @var bool $isValid */
        $isValid = $this->validator->isValid('2018-01-01 00:12:00');

        $this->assertEquals(true, $isValid);
    }

    /**
     *
     */
    public function testEndBeforeBegin()
    {
        $this->validator->setOptions(['startDate' => '2018-01-01 00:12:00']);
        /** @var bool $isValid */
        $isValid = $this->validator->isValid('2018-01-01 00:10:00');

        $this->assertEquals(false, $isValid);
    }

    /**
     *
     */
    public function testEndEqualsBegin()
    {
        $this->validator->setOptions(['startDate' => '2018-01-01 00:12:00']);
        /** @var bool $isValid */
        $isValid = $this->validator->isValid('2018-01-01 00:12:00');

        $this->assertEquals(false, $isValid);
    }

    /**
     *
     */
    public function testErrorMessage()
    {
        $this->validator->setOptions(['startDate' => '2018-01-01 00:12:00']);
        $this->validator->isValid('2018-01-01 00:10:00');

        /** @var array $messages */
        $messages = $this->validator->getMessages();

        $this->assertEquals(true, !empty($messages[DateAfter::INVALID]));
    }
}
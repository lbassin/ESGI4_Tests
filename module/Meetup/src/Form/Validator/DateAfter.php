<?php

namespace Meetup\Form\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;


/**
 * Class DateAfter
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class DateAfter extends AbstractValidator
{
    /**
     *
     */
    const INVALID = 'invalid';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => "End date has to be later than start date",
    ];

    /**
     * @param string $endAt
     * @return bool
     */
    public function isValid($endAt)
    {
        /** @var string $startAt */
        $startAt = $this->getOption('startDate');

        if (empty($startAt)) {
            throw new Exception\RuntimeException();
        }

        /** @var \DateTime $startDate */
        $startDate = new \DateTime($startAt);
        /** @var \DateTime $endDate */
        $endDate = new \DateTime($endAt);

        if ($startDate > $endDate) {
            $this->error(self::INVALID);

            return false;
        }

        return true;
    }
}
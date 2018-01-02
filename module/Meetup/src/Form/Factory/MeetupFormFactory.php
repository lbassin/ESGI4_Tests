<?php

namespace Meetup\Form\Factory;

use Interop\Container\ContainerInterface;
use Meetup\Form\MeetupForm;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class MeetupFormFactory
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class MeetupFormFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return MeetupForm|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MeetupForm();
    }
}
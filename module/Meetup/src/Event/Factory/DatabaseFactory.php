<?php

declare(strict_types=1);

namespace Meetup\Event\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Meetup\Event\Database;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DatabaseFactory
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
class DatabaseFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Database();
    }
}
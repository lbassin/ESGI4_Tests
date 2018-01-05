<?php

declare(strict_types=1);

namespace Meetup\Event\Factory;

use Interop\Container\ContainerInterface;
use Meetup\Event\Database;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DatabaseFactory
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class DatabaseFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Logger $logger */
        $logger = $container->get(Logger::class);
        /** @var Stream $writer */
        $writer = new Stream('php://stderr');

        $logger->addWriter($writer);

        return new Database($logger);
    }
}
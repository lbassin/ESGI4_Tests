<?php

declare(strict_types=1);

namespace Application;

/**
 * Class Module
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class Module
{
    /**
     *
     */
    const VERSION = '3.0.3-dev';

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}

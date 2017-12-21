<?php

use Doctrine\DBAL\Driver\PDOMySql\Driver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => Driver::class,
                'params' => [
                    'host'     => $_ENV['SKEL_DB_HOST'],
                    'port'     => $_ENV['SKEL_DB_PORT'],
                    'user'     => $_ENV['SKEL_DB_USER'],
                    'password' => $_ENV['SKEL_DB_PASS'],
                    'dbname'   => $_ENV['SKEL_DB_NAME'],
                ],
            ],
        ],
    ],
];
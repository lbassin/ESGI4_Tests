<?php

declare(strict_types=1);

namespace Meetup;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Meetup\Controller\Factory\MeetupControllerFactory;
use Meetup\Event\DatabaseInterface as DatabaseEventInterface;
use Meetup\Event\Factory\DatabaseFactory as DatabaseEventFactory;
use Meetup\Form\Factory\MeetupFormFactory;
use Meetup\Form\MeetupFormInterface;
use Meetup\Repository\Factory\MeetupRepositoryFactory;
use Meetup\Repository\MeetupRepositoryInterface;
use Zend\Hydrator\Reflection;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'meetups' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/meetups',
                    'defaults' => [
                        'controller' => Controller\MeetupController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'new' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/new',
                            'defaults' => [
                                'action' => 'new'
                            ]
                        ]
                    ],
                    'view' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/view/:id',
                            'defaults' => [
                                'action' => 'view',
                            ]
                        ]
                    ],
                    'delete' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/delete',
                            'defaults' => [
                                'action' => 'delete'
                            ]
                        ]
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/edit/:id',
                            'defaults' => [
                                'action' => 'edit',
                            ]
                        ]
                    ]
                ]
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\MeetupController::class => MeetupControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            MeetupFormInterface::class => MeetupFormFactory::class,
            MeetupRepositoryInterface::class => MeetupRepositoryFactory::class,
            DatabaseEventInterface::class => DatabaseEventFactory::class,
            Reflection::class => InvokableFactory::class,
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'meetup/meetup/index' => __DIR__ . '/../view/meetup/index.phtml',
            'meetup/meetup/new' => __DIR__ . '/../view/meetup/form.phtml',
            'meetup/meetup/view' => __DIR__ . '/../view/meetup/view.phtml',
            'meetup/meetup/edit' => __DIR__ . '/../view/meetup/form.phtml',
        ],
    ],
    'doctrine' => [
        'driver' => [
            'application_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity/',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Meetup\Entity' => 'application_driver',
                ],
            ],
        ],
    ],
];

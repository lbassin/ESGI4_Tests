<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Meetup;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Meetup\Controller\Factory\MeetupControllerFactory;
use Meetup\Form\Factory\MeetupFormFactory;
use Meetup\Form\MeetupFormInterface;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

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
            MeetupFormInterface::class => MeetupFormFactory::class
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'meetup/meetup/index' => __DIR__ . '/../view/meetup/index.phtml',
            'meetup/meetup/new' => __DIR__ . '/../view/meetup/new.phtml',
            'meetup/meetup/view' => __DIR__ . '/../view/meetup/view.phtml',
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

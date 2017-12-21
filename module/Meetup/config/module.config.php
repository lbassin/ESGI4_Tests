<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Meetup;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Meetup\Controller\Factory\MeetupControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\MeetupController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'new' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/new',
                    'defaults' => [
                        'controller' => Controller\MeetupController::class,
                        'action' => 'new',
                    ]
                ]
            ],
            'details' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/details/:id',
                    'defaults' => [
                        'controller' => Controller\MeetupController::class,
                        'action' => 'details',
                    ]
                ]
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\MeetupController::class => MeetupControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'meetup/meetup/index' => __DIR__ . '/../view/meetup/index.phtml',
            'meetup/meetup/new' => __DIR__ . '/../view/meetup/new.phtml',
            'meetup/meetup/details' => __DIR__ . '/../view/meetup/details.phtml',
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

<?php

namespace MeetupTest\Controller;

use Meetup\Controller\MeetupController;
use Meetup\Entity\Meetup;
use Meetup\Form\MeetupFormInterface;
use Meetup\Repository\MeetupRepositoryInterface;
use Prophecy\Prophecy\ObjectProphecy;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Hydrator\Reflection as ReflectionHydrator;

/**
 * Class MeetupControllerTest
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
class MeetupControllerTest extends AbstractHttpControllerTestCase
{
    /**
     * @var ObjectProphecy
     */
    private $meetupRepository;
    /**
     * @var ObjectProphecy
     */
    private $meetupForm;
    /**
     * @var ObjectProphecy
     */
    private $reflectionHydrator;

    /**
     *
     */
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../config/application.config.php'
        );

        parent::setUp();

        $this->configureServiceManager($this->getApplicationServiceLocator());
    }

    /**
     * @param ServiceManager $services
     */
    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(MeetupRepositoryInterface::class, $this->mockMeetupRepository()->reveal());
        $services->setService(MeetupFormInterface::class, $this->mockMeetupForm()->reveal());
        $services->setService(ReflectionHydrator::class, $this->mockReflectionHydrator()->reveal());

        $services->setAllowOverride(false);
    }

    /**
     * @param $config
     * @return mixed
     */
    protected function updateConfig($config)
    {
        $config['doctrine'] = [];
        return $config;
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function mockMeetupRepository()
    {
        $this->meetupRepository = $this->prophesize(MeetupRepositoryInterface::class);
        return $this->meetupRepository;

    }

    /**
     * @return ObjectProphecy
     */
    private function mockMeetupForm()
    {
        $this->meetupForm = $this->prophesize(MeetupFormInterface::class);
        return $this->meetupForm;
    }

    /**
     * @return ObjectProphecy
     */
    private function mockReflectionHydrator()
    {
        $this->reflectionHydrator = $this->prophesize(ReflectionHydrator::class);
        return $this->reflectionHydrator;
    }

    /**
     * @throws \Exception
     */
    public function testIndexActionCanBeAccessed()
    {
        $this->meetupRepository->findAll()->willReturn([]);

        $this->dispatch('/');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Meetup');
        $this->assertControllerName(MeetupController::class);
        $this->assertMatchedRouteName('home');
    }

    /**
     *
     * @throws \Exception
     */
    public function testIndexActionDisplayMeetup()
    {
        $meetup = $this->createMock(Meetup::class);
        $this->meetupRepository->findAll()->willReturn([$meetup]);

        $this->dispatch('/');
        $this->assertResponseStatusCode(200);
        $this->assertQueryCount('.panel-title', 1);
    }
}
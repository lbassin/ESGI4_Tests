<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Meetup\Controller;

use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\View;

/**
 * Class MeetupController
 * @package Meetup\Controller
 */
class MeetupController extends AbstractActionController
{
    /**
     * @var EntityRepository
     */
    private $meetupRepository;

    /**
     * MeetupController constructor.
     * @param EntityRepository $meetupRepository
     */
    public function __construct(EntityRepository $meetupRepository)
    {
        $this->meetupRepository = $meetupRepository;
    }

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        /** @var array $meetups */
        $meetups = $this->meetupRepository->findAll();
        return new ViewModel([
            'meetups' => $meetups
        ]);
    }

    /**
     * @return ViewModel
     */
    public function newAction()
    {
        return new ViewModel();
    }

    public function detailsAction(){
        return new ViewModel();
    }
}

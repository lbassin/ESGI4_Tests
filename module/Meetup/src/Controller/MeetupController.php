<?php

namespace Meetup\Controller;

use Doctrine\ORM\ORMException;
use Meetup\Entity\Meetup;
use Meetup\Repository\MeetupRepository;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Model\ViewModel;

class MeetupController extends AbstractActionController
{
    /** @property FlashMessenger flashMessenger() */

    /**
     * @var MeetupRepository
     */
    private $meetupRepository;

    /**
     * MeetupController constructor.
     * @param MeetupRepository $meetupRepository
     */
    public function __construct(MeetupRepository $meetupRepository)
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

    /**
     * @return ViewModel
     */
    public function detailsAction()
    {
        /** @var Meetup $meetup */
        $meetup = null;

        /** @var int $id */
        $meetupId = $this->params('id');

        if (!empty($meetupId)) {
            $meetup = $this->meetupRepository->find($meetupId);
        }

        return new ViewModel([
            'meetup' => $meetup
        ]);
    }

    /**
     * @return string|\Zend\Http\Response
     */
    public function deleteAction()
    {
        /** @var FlashMessenger $flashMessenger */
        /** @noinspection PhpUndefinedMethodInspection */
        $flashMessenger = $this->flashMessenger();

        /** @var Request $request */
        $request = $this->getRequest();
        /** @var int $id */
        $id = $request->getPost('id');

        if (empty($id)) {
            $flashMessenger->addErrorMessage('An error occurred');
        }

        try {
            $this->meetupRepository->deleteById($id);
        } catch (ORMException $e) {
            $flashMessenger->addErrorMessage('An error occurred');
        }

        $flashMessenger->addSuccessMessage('Remove has been removed');

        return $this->redirect()->toRoute('home');
    }
}


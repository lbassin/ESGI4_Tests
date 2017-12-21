<?php

namespace Meetup\Controller;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\QueryException;
use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Meetup\Repository\MeetupRepository;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Model\ViewModel;

/**
 * Class {MeetupController}
 *
 * @author                 Laurent Bassin <laurent.bassin@dnd.fr>
 */
class MeetupController extends AbstractActionController
{
    /**
     * @var MeetupRepository
     */
    private $meetupRepository;
    /**
     * @var MeetupForm
     */
    private $meetupForm;

    /**
     * MeetupController constructor.
     * @param MeetupRepository $meetupRepository
     * @param MeetupForm $meetupForm
     */
    public function __construct(MeetupRepository $meetupRepository, MeetupForm $meetupForm)
    {
        $this->meetupRepository = $meetupRepository;
        $this->meetupForm = $meetupForm;
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
        /* @var $request Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            return $this->saveMeetup();
        }

        $this->meetupForm->prepare();

        return new ViewModel([
            'form' => $this->meetupForm
        ]);
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
        /** @var string $id */
        $id = (string)$request->getPost('id');

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

    private function saveMeetup()
    {
        /** @var FlashMessenger $flashMessenger */
        /** @noinspection PhpUndefinedMethodInspection */
        $flashMessenger = $this->flashMessenger();
        /** @var MeetupForm $form */
        $form = $this->meetupForm;
        /* @var $request Request */
        $request = $this->getRequest();

        $form->setData($request->getPost());
        if ($form->isValid()) {
            try {
                $this->meetupRepository->save($form->getData());
            } catch (OptimisticLockException $e) {
                $flashMessenger->addErrorMessage('An error occurred');
            } catch (ORMException $e) {
                $flashMessenger->addErrorMessage('An error occurred');
            }

            $flashMessenger->addSuccessMessage('Meet-up has been created');

            return $this->redirect()->toRoute('home');;
        }
    }
}


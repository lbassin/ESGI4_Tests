<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Meetup\Form\MeetupFormInterface;
use Meetup\Repository\MeetupRepositoryInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Model\ViewModel;

/**
 * Class MeetupController
 *
 * @author Laurent Bassin <laurent@bassin.info>
 */
final class MeetupController extends AbstractActionController
{
    /**
     * @var MeetupRepositoryInterface
     */
    private $meetupRepository;
    /**
     * @var MeetupFormInterface
     */
    private $meetupForm;
    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * MeetupController constructor.
     * @param MeetupRepositoryInterface $meetupRepository
     * @param MeetupFormInterface $meetupForm
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        MeetupRepositoryInterface $meetupRepository,
        MeetupFormInterface $meetupForm,
        EventManagerInterface $eventManager
    )
    {
        $this->meetupRepository = $meetupRepository;
        $this->meetupForm = $meetupForm;
        $this->eventManager = $eventManager;
    }

    /**
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $this->eventManager->trigger('event_test'); // DEBUG

        /** @var array $meetups */
        $meetups = $this->meetupRepository->findAll();

        return new ViewModel([
            'meetups' => $meetups
        ]);
    }

    /**
     * @return ViewModel
     */
    public function newAction(): ViewModel
    {
        /* @var $request Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->saveMeetup();
        }

        $this->meetupForm->prepare();

        return new ViewModel([
            'form' => $this->meetupForm
        ]);
    }

    /**
     * @return ViewModel
     */
    public function viewAction(): ViewModel
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
     * @return ResponseInterface
     */
    public function deleteAction(): ResponseInterface
    {
        /** @var FlashMessenger $flashMessenger */
        /** @noinspection PhpUndefinedMethodInspection */
        $flashMessenger = $this->flashMessenger();

        /** @var Request $request */
        $request = $this->getRequest();
        /** @var string $id */
        $id = (string)$request->getPost('id');

        if (empty($id)) {
            /** @var Response $response */
            $response = $this->getResponse();

            return $response->setStatusCode(404);
        }

        try {
            $this->meetupRepository->deleteById($id);
        } catch (ORMException $e) {
            $flashMessenger->addErrorMessage('An error occurred');
        }

        $flashMessenger->addSuccessMessage('Meetup has been removed');

        return $this->redirect()->toRoute('home');
    }

    /**
     * @return ResponseInterface
     */
    private function saveMeetup(): ResponseInterface
    {
        /** @var FlashMessenger $flashMessenger */
        /** @noinspection PhpUndefinedMethodInspection */
        $flashMessenger = $this->flashMessenger();

        /** @var MeetupForm $form */
        $form = $this->meetupForm;
        /* @var Request $request */
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

            return $this->redirect()->toRoute('home');
        }

        return $this->getResponse();
    }
}

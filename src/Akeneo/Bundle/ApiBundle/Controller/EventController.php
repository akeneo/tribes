<?php

namespace Akeneo\Bundle\ApiBundle\Controller;

use Akeneo\Bundle\ApiBundle\Document\Event;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EventController.
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class EventController implements ClassResourceInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var DocumentRepository
     */
    private $repository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * EventController constructor.
     *
     * @param ObjectManager        $manager
     * @param DocumentRepository   $repository
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        ObjectManager $manager,
        DocumentRepository $repository,
        FormFactoryInterface $formFactory
    ) {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->formFactory = $formFactory;
    }

    /**
     * @Rest\View
     * @Rest\QueryParam(name="longitude", default=null, nullable=true)
     * @Rest\QueryParam(name="latitude", default=null, nullable=true)
     * @Rest\QueryParam(name="from", default="now", nullable=true)
     * @Rest\QueryParam(name="to", default=null, nullable=true)
     *
     * @return array
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        return $this->repository->findAllNear(
            $paramFetcher->get('latitude'),
            $paramFetcher->get('longitude'),
            $paramFetcher->get('from'),
            $paramFetcher->get('to')
        );
    }

    /**
     * @Rest\View
     */
    public function getAction(Event $event)
    {
        return $event;
    }

    /**
     * @Rest\View
     */
    public function postAction(Request $request)
    {
        $form = $this->formFactory->create('event');
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        $event = $form->getData();
        $this->manager->persist($event);
        $this->manager->flush();

        return $event;
    }

    /**
     * @Rest\View
     */
    public function deleteAction(Event $event)
    {
        $this->manager->remove($event);
        $this->manager->flush();
    }
}

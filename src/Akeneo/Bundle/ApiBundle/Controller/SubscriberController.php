<?php

namespace Akeneo\Bundle\ApiBundle\Controller;

use Akeneo\Bundle\ApiBundle\Document\Subscriber;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SubscriberController.
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SubscriberController implements ClassResourceInterface
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
     * SubscriberController constructor.
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
     *
     * @return array
     */
    public function cgetAction()
    {
        return $this->repository->findAll();
    }

    /**
     * @Rest\View
     */
    public function getAction(Subscriber $subscriber)
    {
        return $subscriber;
    }

    /**
     * @Rest\View
     */
    public function postAction(Request $request)
    {
        $form = $this->formFactory->create('subscriber');
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        $subscriber = $form->getData();
        $this->manager->persist($subscriber);
        $this->manager->flush();

        return $subscriber;
    }

    /**
     * @Rest\View
     */
    public function deleteAction(Subscriber $subscriber)
    {
        $this->manager->remove($subscriber);
        $this->manager->flush();
    }
}

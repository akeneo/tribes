<?php

namespace Akeneo\Bundle\FrontofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Controller for Home Page
 *
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @Route(service="akeneo_frontoffice.controller.homepage")
 */
class HomePageController extends Controller
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Session */
    protected $session;

    /**
     * @param FormFactoryInterface $formFactory
     * @param Session              $session
     */
    public function __construct(FormFactoryInterface $formFactory, Session $session)
    {
        $this->formFactory = $formFactory;
        $this->session     = $session;
    }

    /**
     * @Route("/", name="index")
     * @Template
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->formFactory->create('add_event');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->session->getFlashBag()->add('success', 'Your event have been successfully added !');
        }

        return [
            'form' => $form->createView()
        ];
    }
}

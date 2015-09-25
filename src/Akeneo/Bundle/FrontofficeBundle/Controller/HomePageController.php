<?php

namespace Akeneo\Bundle\FrontofficeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Framework;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Controller for Home Page
 *
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @Framework\Route(service="akeneo_frontoffice.controller.homepage")
 */
class HomePageController extends Controller
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Session */
    protected $session;

    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /** @var RouterInterface */
    protected $router;

    /**
     * @param FormFactoryInterface          $formFactory
     * @param Session                       $session
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param RouterInterface               $router
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Session $session,
        AuthorizationCheckerInterface $authorizationChecker,
        RouterInterface $router
    ) {
        $this->formFactory          = $formFactory;
        $this->session              = $session;
        $this->authorizationChecker = $authorizationChecker;
        $this->router               = $router;
    }

    /**
     * @Framework\Route("/", name="index")
     * @Framework\Cache(smaxage="3600", maxage="3600", public=true)
     * @Framework\Template
     *
     * @return Response
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Framework\Route("/flash", name="flash")
     * @Framework\Cache(smaxage="0", maxage="0", public=false)
     * @Framework\Template
     *
     * @return Response
     */
    public function flashAction()
    {
        return [];
    }

    /**
     * @Framework\Route("/event", name="event")
     * @Framework\Cache(smaxage="0", maxage="0", public=false)
     * @Framework\Template
     *
     * @return array|Response
     */
    public function eventAction(Request $request)
    {
        if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            return new RedirectResponse($this->router->generate('hwi_oauth_connect'));
        }

        $form = $this->formFactory->create('frontoffice_event');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->session->getFlashBag()->add('success', 'Your event have been successfully added !');

            return new Response('', 201);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Framework\Route("/subscribe", name="subscribe")
     * @Framework\Cache(smaxage="0", maxage="0", public=false)
     * @Framework\Template
     *
     * @return Response
     */
    public function subscribeAction(Request $request)
    {
        if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {

            return new RedirectResponse($this->router->generate('hwi_oauth_connect'));
        }

        $form = $this->formFactory->create('frontoffice_subscriber');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->session->getFlashBag()->add('success', 'You have successfully subscribed to the events !');

            return new Response('', 201);
        }

        return [
            'form' => $form->createView()
        ];
    }
}

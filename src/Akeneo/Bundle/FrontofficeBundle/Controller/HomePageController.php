<?php

namespace Akeneo\Bundle\FrontofficeBundle\Controller;

use Akeneo\Bundle\FrontofficeBundle\Factory\PingApiClientFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

    /** @var PingApiClientFactory */
    protected $clientFactory;

    /**
     * @param FormFactoryInterface $formFactory
     * @param PingApiClientFactory $clientFactory
     */
    public function __construct(FormFactoryInterface $formFactory, PingApiClientFactory $clientFactory)
    {
        $this->formFactory   = $formFactory;
        $this->clientFactory = $clientFactory;
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

        if (!$form->isValid()) {

        }

        return [
            'form' => $form->createView()
        ];
    }
}

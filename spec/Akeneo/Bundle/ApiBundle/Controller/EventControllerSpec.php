<?php

namespace spec\Akeneo\Bundle\ApiBundle\Controller;

use Akeneo\Bundle\ApiBundle\Document\Event;
use Akeneo\Bundle\ApiBundle\Repository\EventRepository;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Request\ParamFetcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EventControllerSpec
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class EventControllerSpec extends ObjectBehavior
{
    function let(ObjectManager $manager, EventRepository $repository, FormFactoryInterface $formFactory)
    {
        $this->beConstructedWith($manager, $repository, $formFactory);
    }

    function it_should_respond_to_cget_action(ParamFetcher $paramFetcher, $repository)
    {
        $paramFetcher->get('latitude')->willReturn('foo-latitude');
        $paramFetcher->get('longitude')->willReturn('foo-longitude');
        $paramFetcher->get('from')->willReturn('foo-from');
        $paramFetcher->get('to')->willReturn('foo-to');

        $repository->findAllNear('foo-latitude', 'foo-longitude', 'foo-from', 'foo-to')->willReturn(['foo', 'bar']);

        $this->cgetAction($paramFetcher)->shouldReturn(['foo', 'bar']);
    }

    function it_should_respond_to_get_action(Event $event)
    {
        $this->getAction($event)->shouldReturn($event);
    }

    function it_should_respond_to_post_action($formFactory, $manager, Request $request, FormInterface $form)
    {
        $request->request = new ParameterBag();
        $formFactory->create('event')->willReturn($form);
        $form->submit([])->shouldBeCalled();
        $form->isValid()->willReturn(true);
        $form->getData()->willReturn('foobar');
        $manager->persist('foobar')->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->postAction($request)->shouldreturn('foobar');
    }

    function it_should_respond_to_delete_action($manager, Event $event)
    {
        $manager->remove($event)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->deleteAction($event)->shouldReturn(null);
    }
}

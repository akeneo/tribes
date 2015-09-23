<?php

namespace spec\Akeneo\Bundle\FrontofficeBundle\Form\EventSubscriber;

use Akeneo\Bundle\FrontofficeBundle\Security\Core\User\OAuthUser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class EventToApiSubscriberSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $tokenStorage)
    {
        $this->beConstructedWith($tokenStorage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Akeneo\Bundle\FrontofficeBundle\Form\EventSubscriber\EventToApiSubscriber');
    }

    function it_subscribes_to_submit_event()
    {
        $this->getSubscribedEvents()->shouldReturn([
            FormEvents::SUBMIT => 'submit'
        ]);
    }

    function it_submits_null_values(FormEvent $event)
    {
        $event->getData()->willReturn(null);
        $event->setData(Argument::any())->shouldNotBeCalled();

        $this->submit($event);
    }

    function it_submits_form_values(TokenInterface $token, OAuthUser $user, FormEvent $event, $tokenStorage)
    {
        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($user);
        $user->getUsername()->willReturn('foo');
        $user->getEmail()->willReturn('bar');

        $date = new \DateTime('now + 1 week');

        $event->getData()->willReturn([
            'tags' => ['foo', 'bar'],
            'link' => 'foo.bar',
            'plannedAt' => $date,
            'place' => 'foobar',
            'latitude' => 'fooz',
            'longitude' => 'baz',
        ]);

        $event->setData([
            'user' => ['name'  => 'foo', 'email' => 'bar'],
            'tags' => ['foo', 'bar'],
            'link' => 'foo.bar',
            'plannedAt' => $date->format(\DateTime::ISO8601),
            'place' => [
                'name'     => 'foobar',
                'location' => [
                    'latitude'  => 'fooz',
                    'longitude' => 'baz'
                ]
            ]
        ])->shouldBeCalled();

        $this->submit($event)->shouldReturn(null);
    }
}

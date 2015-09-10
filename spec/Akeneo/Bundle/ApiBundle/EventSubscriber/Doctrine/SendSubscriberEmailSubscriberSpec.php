<?php

namespace spec\Akeneo\Bundle\ApiBundle\EventSubscriber\Doctrine;

use Akeneo\Bundle\ApiBundle\Document\Event;
use Akeneo\Bundle\ApiBundle\Document\Location;
use Akeneo\Bundle\ApiBundle\Document\Place;
use Akeneo\Bundle\ApiBundle\Document\Subscriber;
use Doctrine\MongoDB\Query\Query;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Query\Builder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\TwigBundle\TwigEngine;

class SendSubscriberEmailSubscriberSpec extends ObjectBehavior
{
    function let(DocumentRepository $subscriberRepository, \Swift_Mailer $mailer, TwigEngine $templating)
    {
        $this->beConstructedWith($subscriberRepository, $mailer, $templating);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Akeneo\Bundle\ApiBundle\EventSubscriber\Doctrine\SendSubscriberEmailSubscriber');
    }

    function it_subscribes_to_the_post_persist_event()
    {
        $this->getSubscribedEvents()->shouldReturn(['postPersist']);
    }

    function it_should_not_apply_on_non_event_objects($subscriberRepository, LifecycleEventArgs $args)
    {
        $args->getDocument()->willReturn(new \stdClass());
        $subscriberRepository->createQueryBuilder()->shouldNotBeCalled();

        $this->postPersist($args);
    }

    function it_should_send_an_email_to_the_subscribers($subscriberRepository, $mailer, $templating, LifecycleEventArgs $args, Builder $queryBuilder, Query $query)
    {
        $event = new Event(new Place(new Location(4, 2), 'foobar'));
        $subscriber = new Subscriber(new Location(4, 2), 'foo@bar.com');
        $args->getDocument()->willReturn($event);

        $queryBuilder->field('location')->willReturn($queryBuilder);
        $queryBuilder->near(2, 4)->willReturn($queryBuilder);
        $queryBuilder->maxDistance(5/111.12)->willReturn($queryBuilder);
        $queryBuilder->getQuery()->willReturn($query);
        $query->execute()->willReturn([$subscriber]);

        $subscriberRepository->createQueryBuilder()->willReturn($queryBuilder);
        $templating
            ->render('ApiBundle:Email:subscriber.html.twig', ['event' => $event])
            ->willReturn('expected body');

        $mailer->send(Argument::any())->shouldBeCalled();

        $this->postPersist($args);
    }
}

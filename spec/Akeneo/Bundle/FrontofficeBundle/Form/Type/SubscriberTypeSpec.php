<?php

namespace spec\Akeneo\Bundle\FrontofficeBundle\Form\Type;

use Akeneo\Bundle\FrontofficeBundle\Validator\Constraints\Api;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriberTypeSpec extends ObjectBehavior
{
    function let(EventSubscriberInterface $subscriber)
    {
        $this->beConstructedWith($subscriber, ['foo', 'bar']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Akeneo\Bundle\FrontofficeBundle\Form\Type\SubscriberType');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('frontoffice_subscriber');
    }

    function it_configures_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'constraints' => new Api(['resource' => 'subscribers'])
        ])->shouldBeCalled();

        $this->configureOptions($resolver);
    }

    function it_builds_form(FormBuilderInterface $builder, $subscriber)
    {
        $builder->add('place', 'text')->shouldBeCalled()->willReturn($builder);
        $builder->add('latitude', 'hidden', ['required' => false])->shouldBeCalled()->willReturn($builder);
        $builder->add('longitude', 'hidden', ['required' => false])->shouldBeCalled()->willReturn($builder);
        $builder->addEventSubscriber($subscriber)->shouldBeCalled();

        $this->buildForm($builder, []);
    }
}

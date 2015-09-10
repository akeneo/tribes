<?php

namespace spec\Akeneo\Bundle\ApiBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Akeneo\Bundle\ApiBundle\Form\Type\EventType');
    }

    function it_has_name()
    {
        $this->getName()->shouldReturn('event');
    }

    function it_configures_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'Akeneo\Bundle\ApiBundle\Document\Event',
            'cascade_validation' => true,
            'csrf_protection'    => false,
        ])->shouldBeCalled();

        $this->configureOptions($resolver);
    }

    function it_builds_form(FormBuilderInterface $builder)
    {
        $builder->add('link')->shouldBeCalled()->willReturn($builder);
        $builder->add('place', 'place')->shouldBeCalled()->willReturn($builder);
        $builder->add('plannedAt', 'datetime', ['widget' => 'single_text'])->shouldBeCalled()->willReturn($builder);
        $builder->add('user', 'user')->shouldBeCalled()->willReturn($builder);
        $builder->add('tags', 'collection', [
            'allow_add' => true,
            'allow_delete' => true
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }
}

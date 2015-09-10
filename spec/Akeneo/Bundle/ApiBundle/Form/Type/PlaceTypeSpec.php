<?php

namespace spec\Akeneo\Bundle\ApiBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Akeneo\Bundle\ApiBundle\Form\Type\PlaceType');
    }

    function it_has_name()
    {
        $this->getName()->shouldReturn('place');
    }

    function it_configures_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'Akeneo\Bundle\ApiBundle\Document\Place',
            'cascade_validation' => true,
            'csrf_protection'    => false,
        ])->shouldBeCalled();

        $this->configureOptions($resolver);
    }

    function it_builds_form(FormBuilderInterface $builder)
    {
        $builder->add('name')->shouldBeCalled()->willReturn($builder);
        $builder->add('location', 'location')->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }
}

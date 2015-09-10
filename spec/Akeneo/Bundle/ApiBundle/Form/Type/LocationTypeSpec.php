<?php

namespace spec\Akeneo\Bundle\ApiBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Akeneo\Bundle\ApiBundle\Form\Type\LocationType');
    }

    function it_has_name()
    {
        $this->getName()->shouldReturn('location');
    }

    function it_configures_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'Akeneo\Bundle\ApiBundle\Document\Location',
            'cascade_validation' => true,
            'csrf_protection'    => false,
        ])->shouldBeCalled();

        $this->configureOptions($resolver);
    }

    function it_builds_form(FormBuilderInterface $builder)
    {
        $builder->add('latitude')->shouldBeCalled()->willReturn($builder);
        $builder->add('longitude')->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }
}

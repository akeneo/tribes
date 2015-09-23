<?php

namespace spec\Akeneo\Bundle\FrontofficeBundle\Security\Core\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OAuthUserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo', 'bar');
    }

    function it_is_a_user_interface()
    {
        $this->beAnInstanceOf('Symfony\Component\Security\Core\User\UserInterface');
    }

    function it_should_have_an_email()
    {
        $this->getEmail()->shouldReturn('bar');
    }
}

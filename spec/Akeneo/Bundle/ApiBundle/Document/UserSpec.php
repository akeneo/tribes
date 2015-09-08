<?php

namespace spec\Akeneo\Bundle\ApiBundle\Document;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Akeneo\Bundle\ApiBundle\Document\User');
    }

    function it_has_group_akeneo_if_email_match()
    {
        $this->setEmail('foobar@akeneo.com');
        $this->getGroup()->shouldReturn('akeneo');
    }

    function it_has_group_community_if_email_match()
    {
        $this->setEmail('akeneo@foobar.com');
        $this->getGroup()->shouldReturn('community');
    }
}

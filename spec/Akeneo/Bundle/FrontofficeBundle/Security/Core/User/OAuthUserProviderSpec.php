<?php

namespace spec\Akeneo\Bundle\FrontofficeBundle\Security\Core\User;

use Akeneo\Bundle\FrontofficeBundle\Security\Core\User\OAuthUser;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\User\UserInterface;

class OAuthUserProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Akeneo\Bundle\FrontofficeBundle\Security\Core\User\OAuthUserProvider');
    }

    function it_throw_an_exception_when_loading_user_by_username()
    {
        $this->shouldThrow('\LogicException')->during('loadUserByUsername', ['foobar']);
    }

    function it_loads_user_by_oauth_response(UserResponseInterface $response)
    {
        $response->getNickname()->willReturn('foo');
        $response->getEmail()->willReturn('bar');

        $this->loadUserByOAuthUserResponse($response)->shouldReturnAUserLike('foo', 'bar');
    }

    function it_refreshes_oauth_users(OAuthUser $user)
    {
        $user->getUsername()->willReturn('foo');
        $user->getEmail()->willReturn('bar');

        $this->refreshUser($user)->shouldReturnAUserLike('foo', 'bar');
    }

    function it_dont_refresh_simple_users(UserInterface $user)
    {
        $this->shouldThrow('Symfony\Component\Security\Core\Exception\UnsupportedUserException')
            ->during('refreshUser', [$user]);
    }

    function it_supports_akeneo_oauth_ser_class()
    {
        $this->supportsClass('Akeneo\Bundle\FrontofficeBundle\Security\Core\User\OAuthUser')->shouldReturn(true);
    }

    function it_does_not_support_base_oauth_ser_class()
    {
        $this->supportsClass('HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser')->shouldReturn(false);
    }

    function getMatchers()
    {
        return array(
            'returnAUserLike' => function($result, $username, $email) {
                return $result instanceof OAuthUser
                    && $username === $result->getUsername()
                    && $email === $result->getEmail();
            }
        );
    }
}

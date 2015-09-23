<?php

namespace Akeneo\Bundle\FrontofficeBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class OAuthUserProvider
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class OAuthUserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        throw new \LogicException('This method should not be called as HWIOauthBundle use an other interface');
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return new OAuthUser($response->getNickname(), $response->getEmail());
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof OAuthUser) {
            throw new UnsupportedUserException(sprintf('Unsupported user class "%s"', get_class($user)));
        }

        return new OAuthUser($user->getUsername(), $user->getEmail());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Akeneo\\Bundle\\FrontofficeBundle\\Security\\Core\\User\\OAuthUser';
    }
}

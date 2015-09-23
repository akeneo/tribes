<?php

namespace Akeneo\Bundle\FrontofficeBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser as BaseOAuthUser;

/**
 * Class OAuthUser
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class OAuthUser extends BaseOAuthUser
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @param string $username
     */
    public function __construct($username, $email)
    {
        parent::__construct($username);

        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

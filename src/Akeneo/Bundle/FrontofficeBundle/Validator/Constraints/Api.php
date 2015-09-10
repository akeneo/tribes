<?php

namespace Akeneo\Bundle\FrontofficeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Api constraint
 *
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Api extends Constraint
{
    /** @var string */
    public $resource;

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'api';
    }
}

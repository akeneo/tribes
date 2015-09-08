<?php

namespace Akeneo\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class EventController
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class EventController implements ClassResourceInterface
{
    /**
     * @return array
     */
    public function cgetAction()
    {
        return $this->get('doctrine_mongodb')
            ->getRepository('AkeneoApiBundle:Event')
            ->findAll();
    }
}

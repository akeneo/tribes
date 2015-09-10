<?php

namespace Akeneo\Bundle\ApiBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EventRepository
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class EventRepository extends DocumentRepository
{
    /**
     * @param float  $longitude
     * @param float  $latitude
     * @param string $from
     * @param string $to
     *
     * @return array
     */
    public function findAllNear($longitude = null, $latitude = null, $from = null, $to = null)
    {
        $qb = $this->createQueryBuilder();

        if (!empty($latitude) && !empty($longitude)) {
            $qb->field('place.location')
                ->near((float) $longitude, (float) $latitude)
                ->maxDistance(5/111.12); // 5km in radius
        }

        if (!empty($from)) {
            $qb->field('plannedAt')->gte(new \DateTime($from));
        }

        if (!empty($to)) {
            $qb->field('plannedAt')->lte(new \DateTime($to));
        }

        $qb->limit(100);
        $qb->sort('createdAt', 'desc');

        return array_values($qb->getQuery()->execute()->toArray());
    }
}

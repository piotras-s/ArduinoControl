<?php

namespace KGzocha\ArduinoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KGzocha\ArduinoBundle\Service\Statistics\StatisticableRepositoryInterface;

/**
 * TemperatureLogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TemperatureLogRepository extends EntityRepository implements StatisticableRepositoryInterface
{
    /**
     * Will return X and Y values
     *
     * @param int       $id
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return mixed
     */
    public function getValues($id, \DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $query = $this->createQueryBuilder('tl')
            ->select('tl.date as x')
            ->addSelect('tl.value as y')
            ->join('tl.thermometer', 't')
            ->where('t.id = :id')
            ->setParameter('id', $id);

        if ($dateFrom) {
            $query->andWhere('tl.date >= :dateFrom');
            $query->setParameter(':dateFrom', $dateFrom->format('Y-m-d 00:00:00'));
        }

        if ($dateTo) {
            $query->andWhere('tl.date <= :dateTo');
            $query->setParameter(':dateTo', $dateTo->format('Y-m-d 23:59:59'));
        }

        return $query
            ->getQuery()
            ->useResultCache(true, 60)
            ->getArrayResult();
    }

}

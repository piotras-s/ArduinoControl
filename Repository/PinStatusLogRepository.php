<?php

namespace KGzocha\ArduinoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KGzocha\ArduinoBundle\Service\Statistics\StatisticableRepositoryInterface;

/**
 * PinStatusLogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PinStatusLogRepository extends EntityRepository implements StatisticableRepositoryInterface
{

    const MAX_VOLTAGE = 5;
    const RESOLUTION = 1024;

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
        $query = $this->createQueryBuilder('ps')
            ->select('ps.date as x')
            ->addSelect('ps.value * :factor as y')
            ->join('ps.pin', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->setParameter('factor', self::MAX_VOLTAGE / self::RESOLUTION);

        if ($dateFrom) {
            $query->andWhere('ps.date >= :dateFrom');
            $query->setParameter(':dateFrom', $dateFrom);
        }

        if ($dateTo) {
            $query->andWhere('ps.date <= :dateTo');
            $query->setParameter(':dateTo', $dateTo);
        }

        return $query
            ->getQuery()
            ->useResultCache(true, 60)
            ->getArrayResult();
    }

}

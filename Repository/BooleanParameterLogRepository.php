<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KGzocha\ArduinoBundle\Service\Statistics\StatisticableRepositoryInterface;

class BooleanParameterLogRepository extends EntityRepository implements StatisticableRepositoryInterface
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
    public function getValues($id, \DateTime $dateFrom, \DateTime $dateTo)
    {
        $query = $this->createQueryBuilder('bp')
            ->select('bp.date as x')
            ->addSelect('bp.value as y')
            ->join('bp.booleanParameter', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id);

        if ($dateFrom) {
            $query->andWhere('bp.date >= :dateFrom');
            $query->setParameter(':dateFrom', $dateFrom->format('Y-m-d 00:00:00'));
        }

        if ($dateTo) {
            $query->andWhere('bp.date <= :dateTo');
            $query->setParameter(':dateTo', $dateTo->format('Y-m-d 23:59:59'));
        }

        return $query
            ->getQuery()
            ->useResultCache(true, 60)
            ->getArrayResult();
    }
}

<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BooleanParameterRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function findFirst()
    {
        return $this->createQueryBuilder('bp')
            ->orderBy('bp.systemId', 'asc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return \Doctrine\ORM\AbstractQuery
     */
    public function findAllQuery()
    {
        return $this->createQueryBuilder('bp')
            ->orderBy('bp.systemId', 'asc')
            ->getQuery()
            ->useResultCache(true);
    }

}

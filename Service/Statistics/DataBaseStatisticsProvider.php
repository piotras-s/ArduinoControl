<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Service\Statistics\StatisticableRepositoryInterface;
use KGzocha\ArduinoBundle\Service\Statistics\Model\ChartVariables;
use KGzocha\ArduinoBundle\Service\Statistics\Model\StatisticsException;
use KGzocha\ArduinoBundle\Service\Statistics\Model\Variable2D;

class DataBaseStatisticsProvider implements StatisticsProviderInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string    $entity
     * @param int       $id
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return array|ChartVariables
     */
    public function giveStatistics($entity, $id, \DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $repository = $this->getRepository($entity);

        $result = new ChartVariables();
        foreach ($repository->getValues($id, $dateFrom, $dateTo) as $variable) {
            $result->insert(
                (new Variable2D())
                    ->setX($variable['x'])
                    ->setY($variable['y'])
            );
        }

        return $result;
    }

    /**
     * @param           $entity
     * @param           $id
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return ChartVariables|ChartVariables
     */
    public function giveSquareWaveStatistics($entity, $id, \DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        /** @var Variable2D $previous */
        $previous = null;
        $repository = $this->getRepository($entity);
        $result = new ChartVariables();

        foreach ($repository->getValues($id, $dateFrom, $dateTo) as $variable) {

            $nextVariable = (new Variable2D())
                ->setX($variable['x'])
                ->setY($variable['y']);

            if (null !== $previous) {
                if ($previous->getY() == 1 && $variable['y']==0) {
                    $result->insert(
                        $this->getVariableAfter($previous)
                    );
                } else if ($previous->getY()==0 && $variable['y']==1) {
                    $result->insert(
                        $this->getVariableBefore($nextVariable)
                    );
                }
            }

            $result->insert($nextVariable);
            $previous = $nextVariable;
        }

        return $result;
    }

    /**
     * @param Variable2D $previousVariable
     *
     * @return Variable2D
     */
    protected function getVariableAfter(Variable2D $previousVariable)
    {
        /** @var \DateTime $date */
        $date = clone $previousVariable->getX();
        return (new Variable2D())->setY(0)->setX(
            $date->add(
                new \DateInterval('PT1S')
            ));
    }

    /**
     * @param Variable2D $nextVariable
     *
     * @return Variable2D
     */
    protected function getVariableBefore(Variable2D $nextVariable)
    {
        /** @var \DateTime $date */
        $date = clone $nextVariable->getX();
        return (new Variable2D())->setY(0)->setX(
            $date->sub(
                new \DateInterval('PT1S')
            ));
    }

    /**
     * @param $entity
     *
     * @return \Doctrine\ORM\EntityRepository
     * @throws Model\StatisticsException
     */
    protected function getRepository($entity)
    {
        $repository = $this->entityManager->getRepository($entity);
        if (!$repository instanceof StatisticableRepositoryInterface) {
            throw new StatisticsException('Given entity doesnt have proper repository');
        }

        return $repository;
    }
}

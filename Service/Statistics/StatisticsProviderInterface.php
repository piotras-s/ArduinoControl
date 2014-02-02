<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics;

interface StatisticsProviderInterface
{
    /**
     * @param string    $entity
     * @param int       $id
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return array
     */
    public function giveStatistics($entity, $id, \DateTime $dateFrom = null, \DateTime $dateTo);

    /**
     * @param           $entity
     * @param           $id
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return ChartVariables
     */
    public function giveSquareWaveStatistics($entity, $id, \DateTime $dateFrom = null, \DateTime $dateTo = null);
}

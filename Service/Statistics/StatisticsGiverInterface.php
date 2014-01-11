<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics;

interface StatisticsGiverInterface
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
}

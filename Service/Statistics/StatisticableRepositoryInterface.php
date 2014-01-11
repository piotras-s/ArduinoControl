<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics;

interface StatisticableRepositoryInterface
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
    public function getValues($id, \DateTime $dateFrom, \DateTime $dateTo);

}

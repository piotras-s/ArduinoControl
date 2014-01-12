<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;

interface StatisticsFormInterface
{

    /**
     * Returns entity name which will be used to get render statistics.
     * Its repository has to implements StatisticableRepositoryInterface
     * @return string|null
     */
    public function getStatisticsEntityName();

    /**
     * Returns entity name which will be used to let user pick one specific.
     * For example "ArduinoBundle:Thermometer" will let user to pick specific thermometer
     * @return string|null
     */
    public function getFormEntityName();

    /**
     * Returns form label which can be printed
     * @return string
     */
    public function getFormLabel();

}

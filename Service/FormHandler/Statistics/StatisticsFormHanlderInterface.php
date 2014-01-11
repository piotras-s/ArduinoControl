<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;

interface StatisticsFormHanlderInterface
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
     * Will return form entity ID number from user
     * @return int
     */
    public function getId();

    /**
     * Will return picked by user date time from which statistics will start
     * @return \DateTime
     */
    public function getDateFrom();

    /**
     * Will return picked by user date time till which statistics will end
     * @return \DateTime
     */
    public function getDateTo();
}

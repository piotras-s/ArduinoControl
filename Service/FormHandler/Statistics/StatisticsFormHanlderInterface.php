<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;

interface StatisticsFormHanlderInterface
{
    public function getStatisticsEntityName();
    public function getId();
    public function getDateFrom();
    public function getDateTo();
}

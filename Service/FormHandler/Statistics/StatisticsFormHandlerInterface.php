<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;

interface StatisticsFormHandlerInterface
{
    public function getStatisticsEntityName();
    public function getFormEntityName();
    public function getId();
    public function getDateFrom();
    public function getDateTo();
}

<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;


class ThermometerFormHandler extends AbstractStatisticsFormHandler
{
    /**
     * {@inheritDoc}
     */
    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:TemperatureLog';
    }

    /**
     * {@inheritDoc}
     */
    public function getFormEntityName()
    {
        return 'ArduinoBundle:Thermometer';
    }

}

<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;


class PinsFormHandler extends AbstractStatisticsFormHandler
{
    /**
     * @return string
     */
    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:PinStatusLog';
    }

    /**
     * @return string
     */
    public function getFormEntityName()
    {
        return 'ArduinoBundle:Pin';
    }

}

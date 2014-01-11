<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;


class ResponseTimeFormHandler extends AbstractStatisticsFormHandler
{

    /**
     * {@inheritDoc}
     */
    public function getFormEntityName()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:ResponseLog';
    }

}
 
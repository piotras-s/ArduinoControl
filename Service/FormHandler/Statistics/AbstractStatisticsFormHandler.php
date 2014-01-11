<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;

use KGzocha\ArduinoBundle\Service\FormHandler\AbstractFormHandler;

abstract class AbstractStatisticsFormHandler extends AbstractFormHandler
{
    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->getForm()->getData()->getDateFrom();
    }

    /**
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->getForm()->getData()->getDateTo();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getForm()->getData()->getEntity()->getId();
    }
}

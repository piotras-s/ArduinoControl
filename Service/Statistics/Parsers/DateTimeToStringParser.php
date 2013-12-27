<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics\Parsers;

use KGzocha\ArduinoBundle\Service\Statistics\Model\Variable2D;

class DateTimeToStringParser implements StatisticParserInterface
{
    /**
     * @param Variable2D $variable
     */
    public function parse(Variable2D $variable)
    {
        if ($variable->getX() instanceof \DateTime) {
            $variable->setX($variable->getX()->format('Y-m-d H:i:s'));
        }
        if ($variable->getY() instanceof \DateTime) {
            $variable->setY($variable->getY()->format('Y-m-d H:i:s'));
        }
    }

    /**
     * @param Variable2D $variable
     *
     * @return bool
     */
    public function support(Variable2D $variable)
    {
        return ($variable->getX() instanceof \DateTime
            || $variable->getY() instanceof \DateTime);
    }

}

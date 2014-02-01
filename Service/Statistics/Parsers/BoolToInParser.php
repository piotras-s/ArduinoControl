<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Service\Statistics\Parsers;

use KGzocha\ArduinoBundle\Service\Statistics\Model\Variable2D;

class BoolToInParser implements StatisticParserInterface
{
    /**
     * @param Variable2D $variable
     */
    public function parse(Variable2D $variable)
    {
        if (is_bool($variable->getX())) {
            $variable->setX(
                $variable->getX() ? 1 : 0
            );
        }
        if (is_bool($variable->getY())) {
            $variable->setY(
                $variable->getY() ? 1 : 0
            );
        }
    }

    /**
     * @param Variable2D $variable
     *
     * @return bool
     */
    public function support(Variable2D $variable)
    {
        return (is_bool($variable->getX()) || is_bool($variable->getY()));
    }
}

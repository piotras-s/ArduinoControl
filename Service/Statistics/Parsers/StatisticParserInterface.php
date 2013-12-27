<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics\Parsers;

use KGzocha\ArduinoBundle\Service\Statistics\Model\Variable2D;

interface StatisticParserInterface
{
    /**
     * @param Variable2D $variable
     */
    public function parse(Variable2D $variable);

    /**
     * @param Variable2D $variable
     *
     * @return bool
     */
    public function support(Variable2D $variable);
}

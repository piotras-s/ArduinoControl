<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics\Parsers;


use KGzocha\ArduinoBundle\Service\Statistics\Model\Variable2D;

class RoundFloatValuesParser implements StatisticParserInterface
{
    /**
     * @var string
     */
    protected $roundFormat;

    public function __construct($roundFormat)
    {
        $this->roundFormat = $roundFormat;
    }

    /**
     * @param Variable2D $variable
     */
    public function parse(Variable2D $variable)
    {
        $variable->setY(sprintf($this->roundFormat, $variable->getY()));
    }

    /**
     * @param Variable2D $variable
     *
     * @return bool
     */
    public function support(Variable2D $variable)
    {
        return preg_match('/\d\.[\d]{3,}/', $variable->getY());
    }

}
 
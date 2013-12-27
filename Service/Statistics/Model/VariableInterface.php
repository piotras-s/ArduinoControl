<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics\Model;

interface VariableInterface
{
    /**
     * @return mixed
     */
    public function getX();

    /**
     * @return mixed
     */
    public function getY();
}

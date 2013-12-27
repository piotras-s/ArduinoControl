<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics\Model;

class Variable2D implements VariableInterface
{
    public $x;

    public $y;

    /**
     * @param mixed $x
     *
     * @return Variable2D
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $y
     *
     * @return Variable2D
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

}

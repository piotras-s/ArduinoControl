<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics\Model;

class ChartVariables extends \SplMinHeap
{

    /**
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return int|void
     */
    protected function compare($value1, $value2)
    {
        if ($value1->getX() > $value2->getX()) {
            return -1;
        } elseif ($value1->getX() < $value2->getX()) {
            return 1;
        }

        return 0;
    }

    /**
     * @param mixed $value
     *
     * @throws StatisticsException
     */
    public function insert($value)
    {
        if (!$value instanceof VariableInterface) {
            throw new StatisticsException("Variable class should implement VariableInterface");
        }

        return parent::insert($value);
    }

}

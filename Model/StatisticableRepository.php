<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Model;

interface StatisticableRepository
{
    /**
     * Will return X and Y values
     *
     * @param null $id
     *
     * @return mixed
     */
    public function getValues($id = null);

}

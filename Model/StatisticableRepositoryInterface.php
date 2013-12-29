<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Model;

interface StatisticableRepositoryInterface
{
    /**
     * Will return X and Y values
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getValues($id);

}

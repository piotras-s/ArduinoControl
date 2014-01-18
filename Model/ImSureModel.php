<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ImSureModel
{

    /**
     * @Assert\NotNull(message="You have to agree")
     */
    protected $imSure;

    /**
     * @param boolean $imSure
     *
     * @return ImSureModel
     */
    public function setImSure($imSure)
    {
        $this->imSure = $imSure;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getImSure()
    {
        return $this->imSure;
    }

}

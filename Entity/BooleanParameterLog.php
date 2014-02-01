<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * Class BooleanParameterLog
 * @package KGzocha\ArduinoBundle\Entity
 * @ORM\Table(name="bool_parameter_log")
 * @ORM\Entity(repositoryClass="KGzocha\ArduinoBundle\Repository\BooleanParameterLogRepository")
 */
class BooleanParameterLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    protected $date;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="KGzocha\ArduinoBundle\Entity\BooleanParameter",
     *      inversedBy="booleanParameterLog",
     *      cascade={"persist"}
     * )
     */
    protected $booleanParameter;

    /**
     * @ORM\Column(name="value", type="boolean", nullable=false)
     */
    protected $value;

    /**
     * @param mixed $booleanParameter
     *
     * @return BooleanParameterLog
     */
    public function setBooleanParameter($booleanParameter)
    {
        $this->booleanParameter = $booleanParameter;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBooleanParameter()
    {
        return $this->booleanParameter;
    }

    /**
     * @param mixed $date
     *
     * @return BooleanParameterLog
     */
    public function setDate(DateTime $date = null)
    {
        if (!$date) {
            $date = new DateTime();
        }
        $this->date = $date;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param bool $value
     *
     * @return BooleanParameterLog
     */
    public function setValue($value)
    {
        $this->value = (bool) $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getValue()
    {
        return (bool) $this->value;
    }

}

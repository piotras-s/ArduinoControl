<?php

namespace KGzocha\ArduinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TemperatureLog
 *
 * @ORM\Table(name="temperature_log")
 * @ORM\Entity(repositoryClass="KGzocha\ArduinoBundle\Repository\TemperatureLogRepository")
 */
class TemperatureLog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var Thermometer
     *
     * @ORM\ManyToOne(targetEntity="Thermometer")
     */
    private $thermometer;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param  \DateTime      $date
     * @return TemperatureLog
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set thermometer
     *
     * @param  \stdClass      $thermometer
     * @return TemperatureLog
     */
    public function setThermometer($thermometer)
    {
        $this->thermometer = $thermometer;

        return $this;
    }

    /**
     * Get thermometer
     *
     * @return \stdClass
     */
    public function getThermometer()
    {
        return $this->thermometer;
    }

    /**
     * Set value
     *
     * @param  float          $value
     * @return TemperatureLog
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

}

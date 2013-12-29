<?php

namespace KGzocha\ArduinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PinStatusLog
 *
 * @ORM\Table(name="pin_status_log")
 * @ORM\Entity(repositoryClass="KGzocha\ArduinoBundle\Repository\PinStatusLogRepository")
 */
class PinStatusLog
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
     * @var Pin
     *
     * @ORM\ManyToOne(targetEntity="Pin")
     */
    private $pin;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

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
     * Set pinNumber
     *
     * @param  Pin          $pin
     * @return PinStatusLog
     */
    public function setPin(Pin $pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin
     *
     * @return Pin
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set value
     *
     * @param  integer      $value
     * @return PinStatusLog
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set date
     *
     * @param  \DateTime    $date
     * @return PinStatusLog
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
}

<?php

namespace KGzocha\ArduinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Thermometer
 *
 * @ORM\Table(name="thermometer")
 * @ORM\Entity(repositoryClass="KGzocha\ArduinoBundle\Repository\ThermometerRepository")
 * @UniqueEntity("systemId")
 */
class Thermometer
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="systemId", type="integer", unique=true)
     * @Assert\Range(min=1, max=128)
     */
    private $systemId;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TemperatureLog", mappedBy="thermometer", fetch="EXTRA_LAZY", cascade={"remove"})
     */
    private $temperatureLog;

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
     * Set name
     *
     * @param  string      $name
     * @return Thermometer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set systemId
     *
     * @param  integer     $systemId
     * @return Thermometer
     */
    public function setSystemId($systemId)
    {
        $this->systemId = $systemId;

        return $this;
    }

    /**
     * Get systemId
     *
     * @return integer
     */
    public function getSystemId()
    {
        return $this->systemId;
    }
}

<?php

namespace KGzocha\ArduinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pin
 *
 * @ORM\Table(name="pin")
 * @ORM\Entity(repositoryClass="KGzocha\ArduinoBundle\Repository\PinRepository")
 */
class Pin
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
     * @ORM\Column(name="system_id", type="string", length=3)
     */
    private $systemId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

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
     * Set systemId
     *
     * @param  string $systemId
     * @return Pin
     */
    public function setSystemId($systemId)
    {
        $this->systemId = $systemId;

        return $this;
    }

    /**
     * Get systemId
     *
     * @return string
     */
    public function getSystemId()
    {
        return $this->systemId;
    }

    /**
     * Set description
     *
     * @param  string $description
     * @return Pin
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

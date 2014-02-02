<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class BooleanParameter
 * @package KGzocha\ArduinoBundle\Entity
 * @ORM\Table(name="bool_parameters")
 * @ORM\Entity(repositoryClass="KGzocha\ArduinoBundle\Repository\BooleanParameterRepository")
 * @UniqueEntity("name")
 * @UniqueEntity("systemId")
 */
class BooleanParameter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="system_id", type="integer", nullable=false, unique=true)
     * @Assert\Range(min = 1, max = 999)
     */
    protected $systemId;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min = 1, max = 255)
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(
     *      targetEntity="KGzocha\ArduinoBundle\Entity\BooleanParameterLog",
     *      mappedBy="booleanParameter",
     *      fetch="EXTRA_LAZY",
     *      cascade={"remove", "persist"}
     * )
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $booleanParameterLog;

    public function __construct()
    {
        $this->booleanParameterLog = new ArrayCollection();
    }

    /**
     * @return ArrayCollection<BooleanParameterLog>
     */
    public function getBooleanParameterLog()
    {
        return $this->booleanParameterLog;
    }

    /**
     * @param mixed $description
     *
     * @return BooleanParameter
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     *
     * @return BooleanParameter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $systemId
     *
     * @return BooleanParameter
     */
    public function setSystemId($systemId)
    {
        $this->systemId = $systemId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSystemId()
    {
        return $this->systemId;
    }
}

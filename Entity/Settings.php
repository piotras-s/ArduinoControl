<?php

namespace KGzocha\ArduinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="KGzocha\ArduinoBundle\Entity\SettingsRepository")
 */
class Settings
{

	/**
	 * @var string
	 * @ORM\Id()
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="value", type="string", length=255)
	 */
	private $value;


	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Setings
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
	 * Set value
	 *
	 * @param string $value
	 * @return Setings
	 */
	public function setValue($value)
	{
		$this->value = $value;

		return $this;
	}

	/**
	 * Get value
	 *
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}
}

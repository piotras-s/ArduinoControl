<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;

class ArduinoConnectorWrapper implements ConnectorInterface
{
	/**
	 * @var ConnectorInterface
	 */
	protected $arduinoConnector;

	public $time;

	public function __construct(ConnectorInterface $arduinoConnector)
	{
		$this->arduinoConnector = $arduinoConnector;
	}

	public function connect()
	{
		return $this->arduinoConnector->connect();
	}

	public function disconnect()
	{
		return $this->arduinoConnector->disconnect();
	}

	public function sendRequest(array $variables)
	{
		$timer1 = microtime();
		$return = $this->arduinoConnector->sendRequest($variables);
		$this->time = sprintf('%2.2f %s', abs($timer1 - microtime())*100, 'ms');

		return $return;
	}

	public function setSettings(array $settings)
	{
		return $this->arduinoConnector->setSettings($settings);
	}

	public function getSetting($settingKey)
	{
		return $this->arduinoConnector->getSetting($settingKey);
	}

	public function isEnabled()
	{
		return $this->arduinoConnector->isEnabled();
	}

	public function getResponse()
	{
		return $this->arduinoConnector->getResponse();
	}
}
 
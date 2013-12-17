<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;

use Doctrine\ORM\EntityManager;

class ConnectorFactory
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 * @var array
	 */
	protected $configuration;

	protected $settingsPrefix;

	public function __construct(EntityManager $entityManager, $settingsPrefix)
	{
		$this->entityManager = $entityManager;
		$this->settingsPrefix = $settingsPrefix;
		$this->readConfiguration();
	}

	/**
	 * Returns ArduinoConnectorWrapper which implements ConnectorInterface
	 * @return ConnectorInterface
	 */
	public function getConnector()
	{
		return new ArduinoConnectorWrapper($this->configureClass($this->getConnectorClass()));
	}

	/**
	 * @throws ArduinoConnectorException
	 * @return ConnectorInterface
	 */
	protected function getConnectorClass()
	{
		$className = $this->getSingleSetting('class');
		$connector = new $className;
		if (!$connector instanceof ConnectorInterface) {
			throw new ArduinoConnectorException('Given class is not a valid connector class');
		}

		return $connector;
	}

	protected function readConfiguration()
	{
		$this->configuration = $this->entityManager
			->getRepository('KGzocha\ArduinoBundle\Entity\Settings')
			->findAllByPrefix($this->settingsPrefix);
	}

	/**
	 * @param ConnectorInterface $connector
	 *
	 * @return ConnectorInterface
	 */
	protected function configureClass(ConnectorInterface $connector)
	{
		if ($connector instanceof WebArduinoConnector) {
			$this->configureAsWebConnector($connector);
		}

		return $connector;
	}

	/**
	 * @param $key
	 *
	 * @throws ArduinoConnectorException
	 * @return mixed
	 */
	protected function getSingleSetting($key)
	{
		$key = $this->settingsPrefix . $key;
		/** @var KGzocha\ArduinoBundle\Entity\Settings $setting */
		foreach ($this->configuration as $setting) {
			if ($key == $setting->getName()) {
				return $setting->getValue();
			}
		}

		throw new ArduinoConnectorException(sprintf('Missing %s connector parameter', $key));
	}

	/**
	 * @param WebArduinoConnector $connector
	 *
	 * @return WebArduinoConnector
	 */
	protected function configureAsWebConnector(WebArduinoConnector $connector)
	{
		return $connector
			->setAdress($this->getSingleSetting('address'))
			->setProtocol($this->getSingleSetting('protocol'))
			->setPort($this->getSingleSetting('port'))
			->setFileName($this->getSingleSetting('file_name'))
			->setMethod($this->getSingleSetting('method'));
	}

}
 
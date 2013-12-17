<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;


use KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\WebConnectorSettings;

class WebConnector extends AbstractArduinoConnector
{

	/**
	 * @var resource
	 */
	protected $curl;

	/**
	 * @var Settings\WebConnectorSettings
	 */
	protected $settings;

	/**
	 * @var string
	 */
	protected $finalAdress;

	public function __construct(WebConnectorSettings $settings = null)
	{
		$this->settings = $settings;
	}

	/**
	 * @param array $variables
	 *
	 * @return mixed
	 * @throws ArduinoConnectorException
	 */
	public function sendRequest(array $variables)
	{
		if ($this->isEnabled()) {
			$this->beforeCurl();
			if ($variables) {
				$this->addVariables($variables);
			}
			$this->response = curl_exec($this->curl);
			$this->afterCurl();

			return $this->finalAdress;
		}

		throw new ArduinoConnectorException('Connector is not enabled');
	}

	public function __destruct()
	{
		$this->afterCurl();
	}

	/**
	 * @return string
	 */
	protected function setFinalAdress()
	{
		$this->finalAdress = sprintf(
			'%s://%s:%s/%s',
			$this->settings->getProtocol(),
			$this->settings->getAddress(),
			$this->settings->getPort(),
			$this->settings->getFileName()
		);
	}

	protected function beforeCurl()
	{
		if (!$this->curl) {
			$this->curl = curl_init();
		}
		if (!$this->finalAdress) {
			$this->setFinalAdress();
		}
		curl_setopt($this->curl, CURLOPT_URL, $this->finalAdress);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
	}

	protected function afterCurl()
	{
		if ($this->curl) {
			$this->curl = curl_close($this->curl);
		}
	}

	/**
	 * @param array $variables
	 *
	 * @internal param string $method
	 * @return $this
	 */
	protected function addVariables(array $variables = array())
	{
		if ('GET' === $this->settings->getMethod()) {

			$this->finalAdress = sprintf(
				'%s?%s',
				$this->finalAdress,
				http_build_query($variables)
			);

			return $this;
		}

		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $variables);

		return $this;

	}

	/**
	 * Returns connector settings
	 * @return mixed
	 */
	public function getSettings()
	{
		return $this->settings;
	}

	public function setSettings(WebConnectorSettings $settings)
	{
		$this->settings = $settings;

		return $this;
	}
}
 
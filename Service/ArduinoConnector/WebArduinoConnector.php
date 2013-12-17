<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;


class WebArduinoConnector extends ArduinoConnector
{

	/**
	 * @var resource
	 */
	protected $curl;

	protected $protocol;
	protected $adress;
	protected $port;
	protected $fileName;
	protected $method;
	protected $finalAdress;

	const GET_METHOD = 'GET';
	const POST_METHOD = 'POST';

	public function __construct($adress = '', $protocol = 'http', $port = 80, $fileName = 'index.html', $method = self::GET_METHOD)
	{
		$this->protocol = $protocol;
		$this->adress = $adress;
		$this->port = $port;
		$this->fileName = $fileName;
		$this->method = $method;
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
				$this->addVariables($this->method, $variables);
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
			$this->protocol,
			$this->adress,
			$this->port,
			$this->fileName
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
	 * @param string $method
	 * @param array  $variables
	 *
	 * @return $this
	 */
	protected function addVariables($method = self::GET_METHOD, array $variables = array())
	{
		if (self::GET_METHOD === $method) {

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
	 * @param string $adress
	 *
	 * @return WebArduinoConnector
	 */
	public function setAdress($adress)
	{
		$this->adress = $adress;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAdress()
	{
		return $this->adress;
	}

	/**
	 * @param resource $curl
	 *
	 * @return WebArduinoConnector
	 */
	public function setCurl($curl)
	{
		$this->curl = $curl;

		return $this;
	}

	/**
	 * @return resource
	 */
	public function getCurl()
	{
		return $this->curl;
	}

	/**
	 * @param string $fileName
	 *
	 * @return WebArduinoConnector
	 */
	public function setFileName($fileName)
	{
		$this->fileName = $fileName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFileName()
	{
		return $this->fileName;
	}

	/**
	 * @param string $method
	 *
	 * @return WebArduinoConnector
	 */
	public function setMethod($method)
	{
		$this->method = $method;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * @param int $port
	 *
	 * @return WebArduinoConnector
	 */
	public function setPort($port)
	{
		$this->port = $port;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPort()
	{
		return $this->port;
	}

	/**
	 * @param string $protocol
	 *
	 * @return WebArduinoConnector
	 */
	public function setProtocol($protocol)
	{
		$this->protocol = $protocol;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getProtocol()
	{
		return $this->protocol;
	}



}
 
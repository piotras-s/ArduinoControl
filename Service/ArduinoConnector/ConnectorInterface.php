<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;


interface ConnectorInterface
{

	/**
	 * Enables the connector
	 * @return mixed
	 */
	public function connect();

	/**
	 * Disables the connector
	 * @return mixed
	 */
	public function disconnect();

	/**
	 * Process single request to arduino
	 * @param array $variables
	 *
	 * @return mixed
	 */
	public function sendRequest(array $variables);

	/**
	 * Returns true if the connector is enabled
	 * @return bool
	 */
	public function isEnabled();

	/**
	 * Returns response from arduino
	 * @return string
	 */
	public function getResponse();

	/**
	 * Returns connector settings
	 * @return mixed
	 */
	public function getSettings();

}
 
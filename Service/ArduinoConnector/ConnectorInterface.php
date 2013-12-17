<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;


interface ConnectorInterface
{

	public function connect();
	public function disconnect();
	public function sendRequest(array $variables);
	public function isEnabled();
	public function getResponse();

}
 
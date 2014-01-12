<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorInterface;

interface ConnectorWrapperInterface
{
    public function setConnector(ConnectorInterface $connector);
}

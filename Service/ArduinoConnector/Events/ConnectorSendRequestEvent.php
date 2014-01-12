<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Events;


use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorInterface;

class ConnectorSendRequestEvent extends ConnectorEvent
{

    /**
     * @var array
     */
    protected $variables;

    public function __construct(ConnectorInterface $connector, array $variables)
    {
        $this->connector = $connector;
        $this->variables = $variables;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

}
 
<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Events;


use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorInterface;
use Symfony\Component\EventDispatcher\Event;

class ConnectorEvent extends Event
{
    /**
     * @var \KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorInterface
     */
    protected $connector;

    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @return ConnectorInterface
     */
    public function getConnector()
    {
        return $this->connector;
    }
}
 
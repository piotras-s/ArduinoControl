<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorWrapperInterface;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\Events\ConnectorEvent;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\Events\ConnectorEvents;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\Events\ConnectorSendRequestEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ConnectorWrapper implements ConnectorInterface, ConnectorWrapperInterface
{
    /**
     * @var ConnectorInterface
     */
    protected $arduinoConnector;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param ConnectorInterface $connector
     *
     * @return $this
     */
    public function setConnector(ConnectorInterface $connector)
    {
        $this->arduinoConnector = $connector;
        $this->eventDispatcher->dispatch(ConnectorEvents::CONNECTOR_SET, $this->getEvent());

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function connect()
    {
        $this->eventDispatcher->dispatch(ConnectorEvents::CONNECTOR_PRE_CONNECT, $this->getEvent());
        $result = $this->arduinoConnector->connect();
        $this->eventDispatcher->dispatch(ConnectorEvents::CONNECTOR_POST_CONNECT, $this->getEvent());

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function disconnect()
    {
        $this->eventDispatcher->dispatch(ConnectorEvents::CONNECTOR_PRE_DISCONNECT, $this->getEvent());
        $result = $this->arduinoConnector->disconnect();
        $this->eventDispatcher->dispatch(ConnectorEvents::CONNECTOR_POST_DISCONNECT, $this->getEvent());

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function sendRequest(array $variables = array())
    {
        $this->eventDispatcher->dispatch(
            ConnectorEvents::CONNECTOR_PRE_SEND_REQUEST,
            $this->getRequestEvent($variables)
        );

        $result = $this->arduinoConnector->sendRequest($variables);

        $this->eventDispatcher->dispatch(
            ConnectorEvents::CONNECTOR_POST_SEND_REQUEST,
            $this->getRequestEvent($variables)
        );

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function isEnabled()
    {
        return $this->arduinoConnector->isEnabled();
    }

    /**
     * @inheritdoc
     */
    public function getResponse()
    {
        return $this->arduinoConnector->getResponse();
    }

    /**
     * @inheritdoc
     */
    public function getSettings()
    {
        return $this->arduinoConnector->getSettings();
    }

    /**
     * @inheritdoc
     */
    public function getTime()
    {
        return $this->arduinoConnector->getTime();
    }

    /**
     * @return ConnectorEvent
     */
    protected function getEvent()
    {
        return new ConnectorEvent($this->arduinoConnector);
    }

    /**
     * @param array $variables
     *
     * @return ConnectorSendRequestEvent
     */
    protected function getRequestEvent(array $variables)
    {
        return new ConnectorSendRequestEvent($this->arduinoConnector, $variables);
    }

}

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

    public function __construct(ConnectorInterface $arduinoConnector)
    {
        $this->arduinoConnector = $arduinoConnector;
    }

    /**
     * @inheritdoc
     */
    public function connect()
    {
        return $this->arduinoConnector->connect();
    }

    /**
     * @inheritdoc
     */
    public function disconnect()
    {
        return $this->arduinoConnector->disconnect();
    }

    /**
     * @inheritdoc
     */
    public function sendRequest(array $variables)
    {
        return $this->arduinoConnector->sendRequest($variables);
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

}

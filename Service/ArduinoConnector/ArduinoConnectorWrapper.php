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

    /**
     * @var string time taken by sendRequest method
     */
    protected $time;

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
        $timer1 = microtime();
        $return = $this->arduinoConnector->sendRequest($variables);
        $this->time = sprintf('%2.2f %s', abs($timer1 - microtime())*100, 'ms');

        return $return;
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
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

}

<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings;

class WebConnectorSettings implements ConnectorSettingsInterface
{

    protected $protocol = 'http';
    protected $address = 'onet.pl';
    protected $port = 80;
    protected $fileName = 'index.html';
    protected $method = 'GET';

    public function getConnectorClass()
    {
        return 'KGzocha\ArduinoBundle\Service\ArduinoConnector\WebConnector';
    }

    /**
     * @param mixed $address
     *
     * @return WebConnectorSettings
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $fileName
     *
     * @return WebConnectorSettings
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $method
     *
     * @return WebConnectorSettings
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $port
     *
     * @return WebConnectorSettings
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $protocol
     *
     * @return WebConnectorSettings
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

}

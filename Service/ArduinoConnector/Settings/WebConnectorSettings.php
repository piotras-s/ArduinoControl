<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings;

use Symfony\Component\Validator\Constraints as Assert;

class WebConnectorSettings implements ConnectorSettingsInterface
{

    /**
     * @var string
     * @Assert\Regex("/^http[s]{0,1}$/")
     */
    protected $protocol = 'http';

    /**
     * @var string
     * @Assert\Regex("/^[a-z0-9_\.\-\/]{1,255}$/i")
     */
    protected $address = 'onet.pl';

    /**
     * @var int
     * @Assert\Range(min=0, max=25000)
     */
    protected $port = 80;

    /**
     * @var string
     * @Assert\Regex("/^[a-z0-9_\.\-\/]{1,255}$/i")
     */
    protected $fileName = 'index.html';

    /**
     * @var string
     * @Assert\Regex("/(GET|POST)/")
     */
    protected $method = 'GET';

    /**
     * @return string
     */
    public function getConnectorClass()
    {
        return 'KGzocha\ArduinoBundle\Service\ArduinoConnector\WebConnector';
    }

    /**
     * @return string
     */
    public function getFormAlias()
    {
        return 'connector_settings_web_connector';
    }

    /**
     * @return array
     */
    public function getFieldsToSave()
    {
        return array(
            'protocol', 'address', 'port', 'fileName', 'method'
        );
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

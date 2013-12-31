<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\GroupedSettings;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SettingsGroupInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ConnectorSettings implements SettingsGroupInterface
{

    /**
     * @Assert\Regex("/[a-z\\]{1,}/i")
     */
    protected $class;

    /**
     * @Assert\Regex("/(GET|POST|PUT|DELETE)/")
     */
    protected $method;

    /**
     * @Assert\Regex("/http[s]{0,1}/")
     */
    protected $protocol;

    /**
     * @Assert\Regex("/[a-z0-9_\-\.]{1,}/")
     */
    protected $address;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 25000,
     *      minMessage = "Port has to be more then 0",
     *      maxMessage = "Port has to be less then 25000"
     * )
     */
    protected $port;

    /**
     * @Assert\Regex("/[a-z0-9\.\-\/]/i")
     */
    protected $fileName;

    /**
     * @inheritdoc
     */
    public function getPrefix()
    {
        return 'connector.';
    }

    /**
     * @inheritdoc
     */
    public function getFields()
    {
        return array(
            'class', 'method', 'address', 'protocol', 'port', 'fileName'
        );
    }

    /**
     * @param mixed $address
     *
     * @return ConnectorSettings
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
     * @param mixed $class
     *
     * @return ConnectorSettings
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $fileName
     *
     * @return ConnectorSettings
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
     * @return ConnectorSettings
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
     * @return ConnectorSettings
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
     * @return ConnectorSettings
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

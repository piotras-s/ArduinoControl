<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\ConnectorSettingsInterface;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorWrapperInterface;
use KGzocha\ArduinoBundle\Service\ResponseHandler\ResponseHandlerInterface;

/**
 * Class ConnectorFactory will return initialized connector class by parameters specified in database with values
 * which beginns with $settingsPrefix given as variable in constructor
 *
 * @package KGzocha\ArduinoBundle\Service\ArduinoConnector
 */
class ConnectorFactory
{

    /**
     * @var Settings\ConnectorSettingsInterface used to load settings from DB
     */
    protected $settingsFromDatabase;

    /**
     * @var \KGzocha\ArduinoBundle\Service\ResponseHandler\ResponseHandlerInterface
     */
    protected $responseHandler;

    /**
     * @var Settings\ConnectorWrapperInterface
     */
    protected $wrapper;

    public function __construct(ConnectorSettingsInterface $settingsFromDatabase,
        ResponseHandlerInterface $responseHandler,
        ConnectorWrapperInterface $wrapper)
    {
        $this->settingsFromDatabase = $settingsFromDatabase;
        $this->responseHandler = $responseHandler;
        $this->wrapper = $wrapper;
    }

    /**
     * Returns connector
     *
     * @param ConnectorSettingsInterface $settings
     *
     * @return ConnectorInterface
     */
    public function getConnector(ConnectorSettingsInterface $settings)
    {
        $class = $settings->getConnectorClass();

        return $this->wrapper->setConnector(
            new $class($settings, $this->responseHandler)
        );
    }

    /**
     * Returns connector with default setting read from date
     * @return ConnectorInterface
     */
    public function getConnectorFromDatabase()
    {
        return $this->getConnector($this->settingsFromDatabase);
    }

}

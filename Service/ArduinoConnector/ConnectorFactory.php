<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\ConnectorSettingsInterface;

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

    public function __construct(ConnectorSettingsInterface $settingsFromDatabase)
    {
        $this->settingsFromDatabase = $settingsFromDatabase;
    }

    /**
     * Returns connector
     * @param ConnectorSettingsInterface $settings
     *
     * @return ArduinoConnectorWrapper
     */
    public function getConnector(ConnectorSettingsInterface $settings)
    {
        $class = $settings->getConnectorClass();

        return new ArduinoConnectorWrapper(
            new $class($settings)
        );
    }

    /**
     * Returns connector with default setting read from date
     * @return ArduinoConnectorWrapper
     */
    public function getConnectorFromDatabase()
    {
        return $this->getConnector($this->settingsFromDatabase->getSettings());
    }

}

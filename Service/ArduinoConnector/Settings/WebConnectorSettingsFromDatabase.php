<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings;

use KGzocha\ArduinoBundle\Service\Settings\SettingsManagerInterface;

class WebConnectorSettingsFromDatabase extends WebConnectorSettings
{
    /**
     * @var SettingsManagerInterface
     */
    protected $settingsManager;

    public function __construct(SettingsManagerInterface $settingsManager)
    {
        $this->settingsManager = $settingsManager;
        $this->getSettings();
    }

    /**
     * @return WebConnectorSettingsFromDatabase
     */
    protected function getSettings()
    {
        $this
            ->settingsManager
            ->clearNavigation()
            ->takeConnector()
            ->giveAllSettingsToClass($this, $this->getFieldsToSave());

        return $this;
    }

}

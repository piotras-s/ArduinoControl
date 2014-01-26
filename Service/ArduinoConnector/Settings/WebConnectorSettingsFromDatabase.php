<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings;

use KGzocha\ArduinoBundle\Service\Settings\SettingsManagerInterface;

class WebConnectorSettingsFromDatabase extends WebConnectorSettings
{
    /**
     * @param SettingsManagerInterface $settingsManager
     */
    public function __construct(SettingsManagerInterface $settingsManager)
    {
        $settingsManager
            ->clearNavigation()
            ->takeConnector()
            ->giveAllSettingsToClass(
                $this,
                $this->getFieldsToSave()
            );
    }
}

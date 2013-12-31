<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SettingsGroupInterface;

interface SettingsSaverInterface
{
    public function saveSettings(SettingsGroupInterface $settingsGroup);
}

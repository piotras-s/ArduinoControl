<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SettingsGroupInterface;

interface SettingsGiverInterface
{
    public function loadSettings(SettingsGroupInterface $settingsGroup);
}

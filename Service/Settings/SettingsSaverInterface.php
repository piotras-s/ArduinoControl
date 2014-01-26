<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings;

interface SettingsSaverInterface
{
    public function saveSetting($key, $value);
    public function saveSettingsFromClass($name, $object, array $fields);
}

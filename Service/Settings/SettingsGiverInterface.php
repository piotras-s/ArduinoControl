<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings;

interface SettingsGiverInterface
{
    public function giveValue($name, $defaultValue = null);
    public function giveAllSettings($name);
    public function giveAllSettingsToClass($name, $object, array $fields);
}

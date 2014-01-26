<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings;

interface SettingsManagerInterface
{
    public function saveSetting($value);
    public function saveSettingsFromClass($object, array $fields);
    public function giveSetting($defaultValue = null);
    public function giveAllSettings();
    public function giveAllSettingsToClass($object, array $fields);

    public function clearNavigation();
    public function setNavigationFromString($string);

    public function setFormat($format);
    public function getFormat();

    public function setGlue($glue);
    public function getGlue();
}

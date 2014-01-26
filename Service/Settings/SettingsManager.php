<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings;

class SettingsManager implements SettingsManagerInterface
{
    /**
     * @var SettingsSaverInterface
     */
    protected $settingsSaver;

    /**
     * @var SettingsGiverInterface
     */
    protected $settingsGiver;

    /**
     * @var array
     */
    protected $searchedName;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $glue;

    /**
     * @param SettingsSaverInterface $settingsSaver
     * @param SettingsGiverInterface $settingsGiver
     */
    public function __construct(
        SettingsSaverInterface $settingsSaver,
        SettingsGiverInterface $settingsGiver)
    {
        $this->searchedName = array();
        $this->settingsSaver = $settingsSaver;
        $this->settingsGiver = $settingsGiver;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function saveSetting($value)
    {
        return $this->settingsSaver->saveSetting($this->getName(), $value);
    }

    /**
     * @param       $class
     * @param array $fields
     *
     * @return mixed
     */
    public function saveSettingsFromClass($class, array $fields)
    {
        return $this->settingsSaver->saveSettingsFromClass($this->getName(), $class, $fields);
    }

    /**
     * @param  string $defaultValue
     * @return mixed
     */
    public function giveSetting($defaultValue = null)
    {
        return $this->settingsGiver->giveValue($this->getName(), $defaultValue);
    }

    /**
     * @return array
     */
    public function giveAllSettings()
    {
        return $this->settingsGiver->giveAllSettings($this->getName());
    }

    /**
     * @param       $object
     * @param array $fields
     *
     * @return mixed
     */
    public function giveAllSettingsToClass($object, array $fields)
    {
        return $this->settingsGiver->giveAllSettingsToClass($this->getName(), $object, $fields);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $matches = array();
        if (preg_match($this->format, $name, $matches)) {
            $this->searchedName[] = strtolower($matches[1]);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return implode($this->glue, $this->searchedName);
    }

    /**
     * @return $this
     */
    public function clearNavigation()
    {
        $this->searchedName = array();

        return $this;
    }

    /**
     * @param $string
     * @return SettingsManager
     */
    public function setNavigationFromString($string)
    {
        $this->clearNaviagtion();
        $this->searchedName = explode($this->glue, $string);
        array_filter($this->searchedName, function ($value) {
                if (!$value) {
                    return false;
                }

                return true;
            });

        return $this;
    }

    /**
     * @param string $format
     *
     * @return SettingsManager
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $glue
     *
     * @return SettingsManager
     */
    public function setGlue($glue)
    {
        $this->glue = $glue;

        return $this;
    }

    /**
     * @return string
     */
    public function getGlue()
    {
        return $this->glue;
    }

}

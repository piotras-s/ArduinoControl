<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings;

use KGzocha\ArduinoBundle\Service\Settings\Events\PostSetClassSettingsEvent;
use KGzocha\ArduinoBundle\Service\Settings\Events\PostSetSingleSettingEvent;
use KGzocha\ArduinoBundle\Service\Settings\Events\PreSetClassSettingsEvent;
use KGzocha\ArduinoBundle\Service\Settings\Events\PreSetSingleSettingEvent;
use KGzocha\ArduinoBundle\Service\Settings\Events\SettingsManagerEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SettingsManager implements SettingsManagerInterface
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

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
     * @param EventDispatcherInterface $eventDispatcher
     * @param SettingsSaverInterface   $settingsSaver
     * @param SettingsGiverInterface   $settingsGiver
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        SettingsSaverInterface $settingsSaver,
        SettingsGiverInterface $settingsGiver)
    {
        $this->searchedName = array();
        $this->settingsSaver = $settingsSaver;
        $this->settingsGiver = $settingsGiver;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function saveSetting($value)
    {
        $this->eventDispatcher->dispatch(
            SettingsManagerEvents::PRE_SET_SINGLE_SETTING,
            new PreSetSingleSettingEvent($this->getName(), $value)
        );

        $return = $this->settingsSaver->saveSetting($this->getName(), $value);

        $this->eventDispatcher->dispatch(
            SettingsManagerEvents::POST_SET_SINGLE_SETTING,
            new PostSetSingleSettingEvent($this->getName(), $value)
        );

        return $return;
    }

    /**
     * @param       $class
     * @param array $fields
     *
     * @return mixed
     * @throws SettingsManagerException
     */
    public function saveSettingsFromClass($class, array $fields)
    {
        $this->eventDispatcher->dispatch(
            SettingsManagerEvents::PRE_SET_CLASS_SETTINGS,
            new PreSetClassSettingsEvent($this->getName(), $class, $fields)
        );

        try {
            $return = $this->settingsSaver->saveSettingsFromClass($this->getName(), $class, $fields);
            $this->eventDispatcher->dispatch(
                SettingsManagerEvents::POST_SET_CLASS_SETTINGS,
                new PostSetClassSettingsEvent($this->getName(), $class, $fields)
            );

            return $return;
        } catch (SettingsSaverException $exception) {
            throw new SettingsManagerException($exception->getMessage(), $exception);
        }
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
     * @throws SettingsManagerException
     */
    public function giveAllSettingsToClass($object, array $fields)
    {
        try {
            return $this->settingsGiver->giveAllSettingsToClass($this->getName(), $object, $fields);
        } catch (SettingsGiverException $exception) {
            throw new SettingsManagerException($exception->getMessage(), $exception);
        }
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return $this
     * @throws SettingsManagerException
     */
    public function __call($name, $arguments)
    {
        $matches = array();
        if (preg_match($this->format, $name, $matches)) {
            $this->searchedName[] = lcfirst($matches[1]);

            return $this;
        }

        throw new SettingsManagerException(
            sprintf('Wrong naviagtion method format. Method: %s Format: %s', $name, $this->format)
        );
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

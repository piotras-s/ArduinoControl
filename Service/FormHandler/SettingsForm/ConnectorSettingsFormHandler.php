<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SettingsGroupInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\AbstractFormHandler;
use Symfony\Component\Form\FormFactory;

class ConnectorSettingsFormHandler extends AbstractFormHandler
{

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @var SettingsSaverInterface
     */
    protected $settingsSaver;

    /**
     * @var SettingsGiverInterface
     */
    protected $settingsGiver;

    /**
     * @var \KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SettingsGroupInterface
     */
    protected $settingsGroup;

    public function __construct(
        FormFactory $formFactory,
        SettingsGroupInterface $settingsGroup,
        SettingsSaverInterface $settingsSaver,
        SettingsGiverInterface $settingsGiver
    )
    {
        $this->formFactory = $formFactory;
        $this->settingsGroup = $settingsGroup;
        $this->settingsSaver = $settingsSaver;
        $this->settingsGiver = $settingsGiver;
    }

    /**
     * @return $this
     */
    public function createForm()
    {
        $this->form = $this->formFactory->create('connector_settings_form', $this->getConnectorSettings());

        return $this;
    }

    /**
     * Saves collected informations into database
     */
    public function saveSettings()
    {
        $this->settingsSaver->saveSettings($this->settingsGroup);
    }

    /**
     * @return SettingsGroupInterface
     */
    protected function getConnectorSettings()
    {
        return $this->settingsGiver->loadSettings($this->settingsGroup);
    }

}

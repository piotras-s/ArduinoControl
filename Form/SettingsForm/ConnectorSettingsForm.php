<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SingleSettingInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConnectorSettingsForm extends AbstractType
{

    protected $settings;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /** @var SingleSettingInterface $setting */
        foreach ($this->settings as $setting) {
            $setting->buildForm($builder, $options);
        }

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'connector_settings_form';
    }

    /**
     * @param SingleSettingInterface $singleSetting
     *
     * @return $this
     */
    public function addSingleSetting(SingleSettingInterface $singleSetting)
    {
        $this->settings[] = $singleSetting;

        return $this;
    }

}

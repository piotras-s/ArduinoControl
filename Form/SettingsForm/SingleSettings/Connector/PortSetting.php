<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\Connector;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SingleSettingInterface;
use Symfony\Component\Form\FormBuilderInterface;

class PortSetting implements SingleSettingInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('port',
            'integer',
            array(
                'required' => true,
                'precision' => 0,
                'label' => 'Port to connect',
                'attr' => array(
                    'placeholder' => 80,
                )
            )
        );
    }

}

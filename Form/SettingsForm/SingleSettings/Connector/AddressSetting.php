<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\Connector;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SingleSettingInterface;
use Symfony\Component\Form\FormBuilderInterface;

class AddressSetting implements SingleSettingInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address',
            'text',
            array(
                'required' => true,
                'label' => 'Address to connect with',
                'attr' => array(
                    'placeholder' => 'localhost'
                ),
            )
        );
    }

}

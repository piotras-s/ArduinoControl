<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\Connector;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SingleSettingInterface;
use Symfony\Component\Form\FormBuilderInterface;

class FileNameSetting implements SingleSettingInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fileName',
            'text',
            array(
                'label' => 'File name to send request to',
                'attr' => array(
                    'placeholder' => 'arduino/web/bundles/arduino/temp.php',
                ),
            )
        );
    }

}

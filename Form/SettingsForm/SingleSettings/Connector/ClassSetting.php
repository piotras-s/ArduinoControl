<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\Connector;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SingleSettingInterface;
use Symfony\Component\Form\FormBuilderInterface;

class ClassSetting implements SingleSettingInterface
{

    /**
     * @var array
     */
    protected $classChoices;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('class',
            'choice',
            array(
                'required' => true,
                'label' => 'Connector class',
                'choices' => $this->classChoices
            )
        );
    }

    /**
     * @param $className
     *
     * @return ClassSetting
     */
    public function addClassChoice($className)
    {
        $this->classChoices[$className] = $className;

        return $this;
    }

}

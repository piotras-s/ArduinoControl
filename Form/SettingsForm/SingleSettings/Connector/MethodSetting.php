<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\Connector;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SingleSettingInterface;
use Symfony\Component\Form\FormBuilderInterface;

class MethodSetting implements SingleSettingInterface
{
    /**
     * @var array
     */
    protected $methods;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('method',
            'choice',
            array(
                'label' => 'Request method',
                'choices' => $this->methods,
            )
        );
    }

    /**
     * @param $method
     *
     * @return $this
     */
    public function addMethod($method)
    {
        $this->methods[$method] = $method;

        return $this;
    }

}

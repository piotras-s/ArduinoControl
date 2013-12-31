<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\Connector;

use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SingleSettingInterface;
use Symfony\Component\Form\FormBuilderInterface;

class ProtocolSetting implements SingleSettingInterface
{
    protected $protocols;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('protocol', 'choice', array(
                'choices' => $this->protocols,
                'label' => 'Request protocol',
                'required' => true,
            ));
    }

    /**
     * @param $protocol
     *
     * @return $this
     */
    public function addProtocol($protocol)
    {
        $this->protocols[$protocol] = $protocol;

        return $this;
    }

}

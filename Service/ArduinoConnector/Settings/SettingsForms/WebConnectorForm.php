<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\SettingsForms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WebConnectorForm extends AbstractType
{

    /**
     * @var array
     */
    protected $methods;

    /**
     * @var array
     */
    protected $protocols;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address',
                'text',
                array(
                    'label' => 'Address to connect with Arduino',
                    'required' => true,
                )
            )->add('fileName',
                'text',
                array(
                    'label' => 'Specific file name on the address',
                    'required' => true,
                )
            )->add('method',
                'choice',
                array(
                    'label' => 'Method use for requests',
                    'choices' => array_combine($this->methods, $this->methods),
                    'required' => true,
                )
            )->add('port',
                'integer',
                array(
                    'label' => 'Port',
                    'required' => true,
                )
            )->add('protocol',
                'choice',
                array(
                    'label' => 'Protocol',
                    'required' => true,
                    'choices' => array_combine($this->protocols, $this->protocols),
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\WebConnectorSettings',
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'connector_settings_web_connector';
    }

    /**
     * @param array $methods
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;
    }

    /**
     * @param array $protocols
     */
    public function setProtocols(array $protocols)
    {
        $this->protocols = $protocols;
    }

}

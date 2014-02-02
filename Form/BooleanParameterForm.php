<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BooleanParameterForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'required' => true,
                    'max_length' => 255,
                    'label' => 'Parameters name',
                    'trim' => true,
                )
            )
            ->add('systemId', 'number', array(
                    'required' => true,
                    'label' => 'System ID',
                )
            )
            ->add('description', 'textarea', array(
                    'required' => false,
                    'label' => 'Parameters description',
                    'trim' => true,
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'KGzocha\ArduinoBundle\Entity\BooleanParameter',
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'boolean_parameter_form';
    }
}

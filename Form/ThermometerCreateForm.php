<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ThermometerCreateForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('systemId', 'integer', array(
                    'required' => true,
                    'label' => 'System ID',
                    'error_bubbling' => true,
                )
            )
            ->add('name', 'text', array(
                    'required' => true,
                    'label' => 'Name',
                    'error_bubbling' => true,
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
                'data_class' => 'KGzocha\ArduinoBundle\Entity\Thermometer',
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'thermometer_create_form';
    }

}

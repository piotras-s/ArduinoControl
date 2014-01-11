<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;

use KGzocha\ArduinoBundle\Form\AbstractStatisticsForm;
use Symfony\Component\Form\FormBuilderInterface;

class ThermometerForm extends AbstractStatisticsForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, array_merge(
                $options, array(
                    'label' => 'Thermometer',
                    'class' => 'ArduinoBundle:Thermometer',
                    'property' => 'name',
                )
            ));
    }

}

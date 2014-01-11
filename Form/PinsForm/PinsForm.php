<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\PinsForm;

use KGzocha\ArduinoBundle\Form\StatisticsForm;
use Symfony\Component\Form\FormBuilderInterface;

class PinsForm extends StatisticsForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, array_merge(
                $options, array(
                    'label' => 'Pin',
                    'class' => 'ArduinoBundle:Pin',
                    'property' => 'systemId',
                )
            ));
    }

}

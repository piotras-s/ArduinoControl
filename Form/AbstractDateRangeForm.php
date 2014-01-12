<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractDateRangeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('date_from', 'date', array(
                    'label' => 'Date from',
                    'required' => false,
                    'error_bubbling' => true,
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                )
            )
            ->add('date_to', 'date', array(
                    'label' => 'Date to',
                    'required' => false,
                    'error_bubbling' => true,
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                )
            );
    }

}

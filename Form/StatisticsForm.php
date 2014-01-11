<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class StatisticsForm extends AbstractType
{
    /**
     * @var string
     */
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

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
            )
            ->add('entity',
                'entity',
                array(
                    'required' => true,
                    'label' => $options['label'],
                    'class' => $options['class'],
                    'property' => $options['property'],
                )
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}

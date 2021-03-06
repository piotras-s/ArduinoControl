<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractStatisticsForm extends AbstractDateRangeForm
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

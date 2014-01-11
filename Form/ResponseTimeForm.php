<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;


use KGzocha\ArduinoBundle\Form\AbstractDateRangeForm;
use Symfony\Component\Form\FormBuilderInterface;

class ResponseTimeForm extends AbstractDateRangeForm
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
        $builder->add('entity', 'hidden');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}
 
<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;

use KGzocha\ArduinoBundle\Form\AbstractDateRangeForm;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormInterface;
use Symfony\Component\Form\FormBuilderInterface;

class ResponseTimeForm extends AbstractDateRangeForm implements StatisticsFormInterface
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

    /**
     * {@inheritDoc}
     */
    public function getFormEntityName()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:ResponseLog';
    }

    /**
     * Returns form label which can be printed
     * @return string
     */
    public function getFormLabel()
    {
        return 'Response time in ms';
    }

}

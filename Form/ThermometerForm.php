<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;

use KGzocha\ArduinoBundle\Form\AbstractStatisticsForm;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormInterface;
use Symfony\Component\Form\FormBuilderInterface;

class ThermometerForm extends AbstractStatisticsForm implements StatisticsFormInterface
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
                    'class' => $this->getFormEntityName(),
                    'property' => 'name',
                )
            ));
    }

    /**
     * {@inheritDoc}
     */
    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:TemperatureLog';
    }

    /**
     * {@inheritDoc}
     */
    public function getFormEntityName()
    {
        return 'ArduinoBundle:Thermometer';
    }

    /**
     * Returns form label which can be printed
     * @return string
     */
    public function getFormLabel()
    {
        return 'Temperature';
    }

}

<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Form;

use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormInterface;
use Symfony\Component\Form\FormBuilderInterface;

class BooleanParameterLogForm extends AbstractStatisticsForm implements StatisticsFormInterface
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, array_merge(
                $options, array(
                    'label' => 'Parameter',
                    'class' => $this->getFormEntityName(),
                    'property' => 'name',
                )
            ));
    }

    /**
     * @return string
     */
    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:BooleanParameterLog';
    }

    /**
     * @return string
     */
    public function getFormEntityName()
    {
        return 'ArduinoBundle:BooleanParameter';
    }

    /**
     * Returns form label which can be printed
     * @return string
     */
    public function getFormLabel()
    {
        return 'On/off parametr';
    }
}

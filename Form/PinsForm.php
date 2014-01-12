<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form;

use KGzocha\ArduinoBundle\Form\AbstractStatisticsForm;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormInterface;
use Symfony\Component\Form\FormBuilderInterface;

class PinsForm extends AbstractStatisticsForm implements StatisticsFormInterface
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
                    'class' => $this->getFormEntityName(),
                    'property' => 'systemId',
                )
            ));
    }

    /**
     * @return string
     */
    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:PinStatusLog';
    }

    /**
     * @return string
     */
    public function getFormEntityName()
    {
        return 'ArduinoBundle:Pin';
    }

    /**
     * Returns form label which can be printed
     * @return string
     */
    public function getFormLabel()
    {
        return 'Voltage';
    }

}

<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics\ThermometerForm;

use KGzocha\ArduinoBundle\Entity\Thermometer;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\AbstractStatisticsFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormHanlderInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormModelCreator;
use Symfony\Component\Form\FormFactory;

class ThermometerFormHandler extends AbstractStatisticsFormHandler implements FormHandlerInterface,
    StatisticsFormHanlderInterface
{

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $thermometerFormAlias;

    /**
     * @var StatisticsFormModelCreator
     */
    protected $formModelCreator;

    public function __construct(
        FormFactory $formFactory,
        StatisticsFormModelCreator $formModelCreator,
        $thermometerFormName)
    {
        $this->formFactory = $formFactory;
        $this->formModelCreator = $formModelCreator;
        $this->thermometerFormAlias = $thermometerFormName;
    }

    /**
     * @return ThermometerFormHandler
     */
    public function createForm()
    {
        $this->form = $this->formFactory->create(
            $this->thermometerFormAlias,
            $this->formModelCreator->getModel($this->getEntityName())
        );

        return $this;
    }

    /**
     * @return string
     */
    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:TemperatureLog';
    }

    /**
     * @return Thermometer
     */
    public function getThermometer()
    {
        return $this->form->getData()->getEntity();
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'ArduinoBundle:Thermometer';
    }

}

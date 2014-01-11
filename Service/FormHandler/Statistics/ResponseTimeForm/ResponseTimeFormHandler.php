<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics\ResponseTimeForm;


use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\AbstractStatisticsFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormHanlderInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormModelCreator;
use Symfony\Component\Form\FormFactory;

class ResponseTimeFormHandler extends AbstractStatisticsFormHandler implements FormHandlerInterface,
    StatisticsFormHanlderInterface
{
    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $formAlias;

    /**
     * @var StatisticsFormModelCreator
     */
    protected $formModelCreator;

    public function __construct(
        FormFactory $formFactory,
        StatisticsFormModelCreator $formModelCreator,
        $formName)
    {
        $this->formFactory = $formFactory;
        $this->formModelCreator = $formModelCreator;
        $this->formAlias = $formName;
    }

    /**
     * @return ThermometerFormHandler
     */
    public function createForm()
    {
        $this->form = $this->formFactory->create(
            $this->formAlias,
            $this->formModelCreator->getModel()
        );

        return $this;
    }

    public function getStatisticsEntityName()
    {
        return 'ArduinoBundle:ResponseLog';
    }

}
 
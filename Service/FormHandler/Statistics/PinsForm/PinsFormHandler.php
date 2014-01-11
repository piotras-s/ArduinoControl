<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics\PinsForm;

use KGzocha\ArduinoBundle\Entity\Pin;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\AbstractStatisticsFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormHanlderInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormModelCreator;
use Symfony\Component\Form\FormFactory;

class PinsFormHandler extends AbstractStatisticsFormHandler implements FormHandlerInterface,
    StatisticsFormHanlderInterface
{

    /**
     * @var \Symfony\Component\Form\FormFactory
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
        $formAlias)
    {
        $this->formFactory = $formFactory;
        $this->formAlias = $formAlias;
        $this->formModelCreator = $formModelCreator;
    }

    /**
     * @return $this
     */
    public function createForm()
    {
        $this->form = $this->formFactory->create(
            $this->formAlias,
            $this->formModelCreator->getModel($this->getEntityName())
        );

        return $this;
    }

    /**
     * @return Pin
     */
    public function getPin()
    {
        return $this->form->getData()->getEntity();
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
    protected function getEntityName()
    {
        return 'ArduinoBundle:Pin';
    }

}

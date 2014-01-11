<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;

use KGzocha\ArduinoBundle\Service\FormHandler\AbstractFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use Symfony\Component\Form\FormFactory;

abstract class AbstractStatisticsFormHandler extends AbstractFormHandler implements FormHandlerInterface,
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
            $this->formModelCreator->getModel($this->getFormEntityName())
        );

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->getForm()->getData()->getDateFrom();
    }

    /**
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->getForm()->getData()->getDateTo();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        if (is_object($entity = $this->getForm()->getData()->getEntity())) {
            return $entity->getId();
        }

        return null;
    }
}

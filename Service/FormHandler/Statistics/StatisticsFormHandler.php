<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;

use KGzocha\ArduinoBundle\Service\FormHandler\AbstractFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use Symfony\Component\Form\FormFactory;

class StatisticsFormHandler extends AbstractFormHandler implements FormHandlerInterface, StatisticsFormHandlerInterface
{

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @var StatisticsFormInterface
     */
    protected $formClass;

    /**
     * @var StatisticsFormModelCreator
     */
    protected $formModelCreator;

    public function __construct(
        FormFactory $formFactory,
        StatisticsFormModelCreator $formModelCreator)
    {
        $this->formFactory = $formFactory;
        $this->formModelCreator = $formModelCreator;
    }

    /**
     * @return $this
     */
    public function createForm()
    {
        $this->form = $this->formFactory->create(
            $this->getFormClass(),
            $this->formModelCreator->getModel($this->getFormClass()->getFormEntityName())
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

    /**
     * @return null|string
     */
    public function getFormEntityName()
    {
        return $this->getFormClass()->getFormEntityName();
    }

    /**
     * @return null|string
     */
    public function getStatisticsEntityName()
    {
        return $this->getFormClass()->getStatisticsEntityName();
    }

    /**
     * @param StatisticsFormInterface $formClass
     *
     * @return $this
     */
    public function setFormClass(StatisticsFormInterface $formClass)
    {
        $this->formClass = $formClass;

        return $this;
    }

    /**
     * @return StatisticsFormInterface
     */
    public function getFormClass()
    {
        return $this->formClass;
    }

}

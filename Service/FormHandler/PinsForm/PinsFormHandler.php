<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\PinsForm;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Pin;
use KGzocha\ArduinoBundle\Form\StatisticsFormModel;
use KGzocha\ArduinoBundle\Service\FormHandler\AbstractStatisticsFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\StatisticsFormHanlderInterface;
use Symfony\Component\Form\FormFactory;

class PinsFormHandler extends AbstractStatisticsFormHandler implements FormHandlerInterface,
    StatisticsFormHanlderInterface
{

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $formAlias;

    /**
     * @var int
     */
    protected $dateRange;

    public function __construct(
        FormFactory $formFactory,
        EntityManager $entityManager,
        $formAlias, $dateRange)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->formAlias = $formAlias;
        $this->dateRange = $dateRange;
    }

    /**
     * @return $this
     */
    public function createForm()
    {
        $formModel = (new StatisticsFormModel())
            ->setEntity($this->entityManager
                    ->getRepository($this->getEntityName())
                    ->findFirstPin()
            )
            ->setDateFrom(new \DateTime(sprintf('-%d days', $this->dateRange)))
            ->setDateTo(new \DateTime());

        $this->form = $this->formFactory->create(
            $this->formAlias,
            $formModel
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

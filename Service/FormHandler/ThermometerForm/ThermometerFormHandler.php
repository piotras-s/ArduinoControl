<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Service\FormHandler\ThermometerForm;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Thermometer;
use KGzocha\ArduinoBundle\Form\StatisticsFormModel;
use KGzocha\ArduinoBundle\Service\FormHandler\AbstractStatisticsFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\StatisticsFormHanlderInterface;
use Symfony\Component\Form\FormFactory;

class ThermometerFormHandler extends AbstractStatisticsFormHandler implements FormHandlerInterface,
    StatisticsFormHanlderInterface
{

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $thermometerFormAlias;

    /**
     * @var int
     */
    protected $dateRange;

    public function __construct(
        FormFactory $formFactory,
        EntityManager $entityManager,
        $thermometerFormName, $dateRange)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->thermometerFormAlias = $thermometerFormName;
        $this->dateRange = $dateRange;
    }

    /**
     * @return ThermometerFormHandler
     */
    public function createForm()
    {
        $formModel = (new StatisticsFormModel())
            ->setEntity($this->entityManager
                    ->getRepository($this->getEntityName())
                    ->findFirstThermometer()
            )
            ->setDateFrom(new \DateTime(sprintf('-%d days', $this->dateRange)))
            ->setDateTo(new \DateTime());

        $this->form = $this->formFactory->create(
            $this->thermometerFormAlias,
            $formModel
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

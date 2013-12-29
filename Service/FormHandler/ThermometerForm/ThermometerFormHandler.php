<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Service\FormHandler\ThermometerForm;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Thermometer;
use KGzocha\ArduinoBundle\Service\FormHandler\AbstractFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class ThermometerFormHandler extends AbstractFormHandler implements FormHandlerInterface
{

    const THERMOMETER_FIELD_NAME = 'thermometer';
    const THERMOMETER_FORM_NAME = 'thermometer_form';

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $thermometerFieldName;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $thermometerFormAlias;

    public function __construct(
        FormFactory $formFactory,
        EntityManager $entityManager,
        $thermometerFormName = self::THERMOMETER_FORM_NAME,
        $thermometerFieldName = self::THERMOMETER_FIELD_NAME)
    {
        $this->thermometerFieldName = $thermometerFieldName;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->thermometerFormAlias = $thermometerFormName;
    }

    /**
     * @return ThermometerFormHandler
     */
    public function createForm()
    {
        $this->form = $this->formFactory->create(
            $this->thermometerFormAlias,
            array(
                $this->thermometerFieldName => $this->entityManager
                    ->getRepository('ArduinoBundle:Thermometer')
                    ->findFirstThermometer()
            )
        );

        return $this;
    }

    /**
     * @return Thermometer
     */
    public function getThermometer()
    {
        return $this->form->getData()[$this->thermometerFieldName];
    }

}

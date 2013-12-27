<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Service\FormHandler\ThermometerForm;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Thermometer;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class ThermometerFormHandler
{

    const THERMOMETER_FIELD_NAME = 'thermometer';

    /**
     * @var Form
     */
    protected $form;

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

    public function __construct(
        FormFactory $formFactory,
        EntityManager $entityManager,
        $thermometerFieldName = self::THERMOMETER_FIELD_NAME)
    {
        $this->thermometerFieldName = $thermometerFieldName;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @return ThermometerFormHandler
     */
    public function createForm()
    {
        $this->form = $this->formFactory->create(
            'thermometer_form',
            array(
                'thermometer' => $this->entityManager
                    ->getRepository('ArduinoBundle:Thermometer')
                    ->findFirstThermometer()
            ),
            array(
                'attr' => array(
                    'id' => 'thermometer_form',
                ),
            )
        );

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        $this->form->handleRequest($request);

        return $this->form->isValid();
    }

    /**
     * @return Thermometer
     */
    public function getThermometer()
    {
        return $this->form->getData()[$this->thermometerFieldName];
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }

}

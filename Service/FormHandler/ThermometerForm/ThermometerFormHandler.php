<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Service\FormHandler\ThermometerForm;

use KGzocha\ArduinoBundle\Entity\Thermometer;
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
     * @var string
     */
    protected $thermometerFieldName;

    public function __construct($thermometerFieldName = self::THERMOMETER_FIELD_NAME)
    {
        $this->thermometerFieldName = $thermometerFieldName;
    }

    /**
     * @param Form $form
     *
     * @return $this
     */
    public function setForm(Form $form)
    {
        $this->form = $form;

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

}

<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\PinsForm;


use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Pin;
use KGzocha\ArduinoBundle\Service\FormHandler\AbstractFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class PinsFormHandler extends AbstractFormHandler implements FormHandlerInterface
{

    const PINS_FORM_ALIAS = 'pins_form';
    const PIN_FIELD_NAME = 'pin';

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    protected $formAlias;
    protected $pinFieldName;

    public function __construct(
        FormFactory $formFactory,
        EntityManager $entityManager,
        $formAlias = self::PINS_FORM_ALIAS,
        $pinFieldName = self::PIN_FIELD_NAME)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->formAlias = $formAlias;
        $this->pinFieldName = $pinFieldName;
    }

    /**
     * @return $this
     */
    public function createForm()
    {
        $this->form = $this->formFactory->create(
            $this->formAlias,
            array(
                $this->pinFieldName => $this->entityManager
                        ->getRepository('ArduinoBundle:Pin')
                        ->findFirstPin()
            )
        );

        return $this;
    }

    /**
     * @return Pin
     */
    public function getPin()
    {
        return $this->form->getData()[$this->pinFieldName];
    }

}
 
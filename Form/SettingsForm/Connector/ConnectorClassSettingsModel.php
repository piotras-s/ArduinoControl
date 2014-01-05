<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\Connector;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class ConnectorSettingsStep1Model
 * @package KGzocha\ArduinoBundle\Form\SettingsForm\Connector
 * @Assert\Callback({"validateClass"})
 */
class ConnectorClassSettingsModel
{
    protected $class;

    /**
     * @param mixed $class
     *
     * @return ConnectorSettingsStep1Model
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param ExecutionContextInterface $context
     */
    public function validateClass(ExecutionContextInterface $context)
    {
        if (!class_exists($this->getClass())) {
            $context->addViolationAt('class', 'Given class doesn\'t exists in system');
        }
    }

}

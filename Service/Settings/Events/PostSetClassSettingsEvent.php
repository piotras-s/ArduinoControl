<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings\Events;

class PostSetClassSettingsEvent extends AbstractSettingsManagerEvent
{
    /**
     * @var array
     */
    protected $fields;

    /**
     * @var mixed
     */
    protected $object;

    /**
     * @param       $name
     * @param       $object
     * @param array $fields
     */
    public function __construct($name, $object, array $fields)
    {
        parent::__construct($name);
        $this->object = $object;
        $this->fields = $fields;
    }

}

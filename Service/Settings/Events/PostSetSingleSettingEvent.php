<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings\Events;

class PostSetSingleSettingEvent extends AbstractSettingsManagerEvent
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

}

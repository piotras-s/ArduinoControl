<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings;

interface SettingsGroupInterface
{
    /**
     * Prefix of setting name in database
     * @return string
     */
    public function getPrefix();

    /**
     * All possible fields in this group without prefix
     * @return array
     */
    public function getFields();
}

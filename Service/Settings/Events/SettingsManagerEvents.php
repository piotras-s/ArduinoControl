<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings\Events;

final class SettingsManagerEvents
{
    const PRE_SET_SINGLE_SETTING = 'kgzocha.arduino.pre_set_single_setting';
    const POST_SET_SINGLE_SETTING = 'kgzocha.arduino.post_set_single_setting';
    const PRE_SET_CLASS_SETTINGS = 'kgzocha.arduino.pre_set_class_settings';
    const POST_SET_CLASS_SETTINGS = 'kgzocha.arduino.post_set_class_settings';

    const PRE_GET_SINGLE_SETTING = 'kgzocha.arduino.pre_get_single_setting';
    const POST_GET_SINGLE_SETTING = 'kgzocha.arduino.post_get_single_setting';
    const PRE_GET_CLASS_SETTINGS = 'kgzocha.arduino.pre_get_class_settings';
    const POST_GET_CLASS_SETTINGS = 'kgzocha.arduino.post_get_class_settings';
}

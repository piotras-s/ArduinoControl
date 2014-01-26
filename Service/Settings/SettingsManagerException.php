<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings;

use Exception;

class SettingsManagerException extends \RuntimeException
{
    public function __construct($message = "", Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

}

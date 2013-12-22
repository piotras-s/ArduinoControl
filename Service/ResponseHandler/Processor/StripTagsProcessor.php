<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ResponseHandler\Processor;

class StripTagsProcessor implements ProcessorInterface
{
    public function process(&$text)
    {
        $text = trim(strip_tags($text));
    }

}

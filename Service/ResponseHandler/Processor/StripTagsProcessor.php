<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ResponseHandler\Processor;

class StripTagsProcessor implements ProcessorInterface
{
    /**
     * @param $text
     */
    public function process(&$text)
    {
        $text = trim(strip_tags($text));
    }

    /**
     * @param $text
     *
     * @return bool
     */
    public function supports(&$text)
    {
        return is_string($text);
    }

}

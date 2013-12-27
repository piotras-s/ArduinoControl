<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ResponseHandler\Processor;

interface ProcessorInterface
{
    /**
     * @param $text
     */
    public function process(&$text);

    /**
     * @param $text
     */
    public function supports(&$text);
}

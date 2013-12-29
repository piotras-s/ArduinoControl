<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler;

use Symfony\Component\HttpFoundation\Request;

interface FormHandlerInterface
{
    public function createForm();
    public function handle(Request $request);
    public function getForm();
}
 
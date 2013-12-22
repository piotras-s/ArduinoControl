<?php

namespace KGzocha\ArduinoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ArduinoBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

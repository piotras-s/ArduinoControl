<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SettingsController extends Controller
{

    /**
     * @Route("/settings/connector", name="arduino_settings_connector")
     * @Template()
     */
    public function connectorSettingsAction(Request $request)
    {
        $formHandler = $this->get('arduino.form.handler.connector')->createForm();
        if ($formHandler->handle($request)) {
            $formHandler->saveSettings();
        }

        return array(
            'form' => $formHandler->getForm()->createView(),
        );
    }

}

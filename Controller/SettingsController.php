<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm\SettingsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SettingsController extends Controller
{

    const CONNECTOR_SETTINGS_PREFIX = 'connector.';

    /**
     * @Route("/settings/connector/class", name="arduino_settings_connector_class")
     * @Template()
     */
    public function connectorClassAction(Request $request)
    {
        $form = $this->createForm('connector_class_settings');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('arduino.settings_saver')
                ->setPrefix(self::CONNECTOR_SETTINGS_PREFIX)
                ->saveSetting(
                    'class',
                    $form->getData()->getClass()
                );
            $this->getDoctrine()->getManager()->flush();

            $this->successFlash();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/settings/connector/params", name="arduino_settings_connector_params")
     * @Template()
     */
    public function connectorParamsAction(Request $request)
    {
        try {
            $formHandler = $this->get('arduino.form.handler.settings.connector')->createForm();
            if ($formHandler->handle($request)) {
                $this->successFlash();
            }
        } catch (SettingsException $exception) {
            $this->get('session')->getFlashBag()->add('danger', $exception->getMessage());

            return $this->redirect(
                $this->generateUrl('arduino_settings_connector_class')
            );
        }

        return array(
            'form' => $formHandler->getForm()->createView(),
        );
    }

    /**
     * Adds success flash message
     */
    public function successFlash()
    {
        $this->get('session')->getFlashBag()->add('success', 'Settings were successfuly saved');
    }

}

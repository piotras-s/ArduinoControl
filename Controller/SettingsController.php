<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm\SettingsException;
use KGzocha\ArduinoBundle\Service\Settings\SettingsManagerException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SettingsController extends Controller
{

    /**
     * @Route("/settings/connector/class", name="arduino_settings_connector_class")
     * @Template()
     */
    public function connectorClassAction(Request $request)
    {
        $form = $this->createForm('connector_class_settings');
        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $this->get('arduino.settings_manager')
                    ->clearNavigation()
                    ->takeConnector()
                    ->takeClass()
                    ->saveSetting($form->getData()->getClass());

                $this->getDoctrine()->getManager()->flush();
                $this->successFlash();
            } catch (SettingsManagerException $exception) {
                return $this->showException($exception);
            }
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
            $this->getDoctrine()->getManager()->flush();
        } catch (SettingsException $exception) {
            return $this->showException($exception, 'arduino_settings_connector_class');
        } catch (SettingsManagerException $exception) {
            return $this->showException($exception, 'arduino_settings_connector_class');
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

    /**
     * @param \Exception $exception
     * @param string     $redirect
     *
     * @return RedirectResponse
     */
    protected function showException(\Exception $exception, $redirect = null)
    {
        $this->get('logger')->error($exception->getMessage());
        $this->get('session')->getFlashBag()->add('danger', $exception->getMessage());

        if ($redirect) {
            return $this->redirect(
                $this->generateUrl($redirect)
            );
        }
    }

}

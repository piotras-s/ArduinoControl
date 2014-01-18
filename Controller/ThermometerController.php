<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Controller;

use Doctrine\DBAL\DBALException;
use KGzocha\ArduinoBundle\Entity\Thermometer;
use KGzocha\ArduinoBundle\Form\ImSureForm;
use KGzocha\ArduinoBundle\Form\ThermometerCreateForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ThermometerController extends Controller
{

    /**
     * @Route("/thermometer/list", name="arduino_thermometer_list")
     * @Template()
     */
    public function listAction()
    {
        return array(
            'thermometers' => $this->getDoctrine()->getRepository('ArduinoBundle:Thermometer')->findAll()
        );
    }

    /**
     * @Route("/thermometer/update/{systemId}", name="arduino_thermometer_update")
     * @ParamConverter("thermometer", class="ArduinoBundle:Thermometer")
     * @Template()
     */
    public function updateAction(Request $request, Thermometer $thermometer)
    {
        $form = $this->createForm(new ThermometerCreateForm(), $thermometer);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($thermometer);

            try {
                $em->flush();
            } catch (DBALException $exception) {
                $this->get('session')->getFlashBag()->add('warning', $exception->getMessage());

                return array('form' => $form->createView());
            }

            $this->get('session')->getFlashBag()->add('success', 'You have updated the thermometer');

            return $this->redirect(
                $this->generateUrl('arduino_thermometer_list')
            );
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/thermometer/show/{systemId}", name="arduino_thermometer_show")
     * @ParamConverter("thermometer", class="ArduinoBundle:Thermometer")
     * @Template()
     */
    public function showAction(Thermometer $thermometer)
    {
        return array(
            'thermometer' => $thermometer,
        );
    }

    /**
     * @Route("/thermometer/delete/{systemId}", name="arduino_thermometer_delete")
     * @ParamConverter("thermometer", class="ArduinoBundle:Thermometer")
     * @Template
     */
    public function deleteAction(Thermometer $thermometer, Request $request)
    {
        $form = $this->createForm(new ImSureForm());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->remove($thermometer);
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'You have successfully removed thermometer'
            );

            return $this->redirect(
                $this->generateUrl('arduino_thermometer_list')
            );
        }

        return array(
            'thermometer' => $thermometer,
            'form' => $form->createView(),
        );
    }

}

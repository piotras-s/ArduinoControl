<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Controller;

use Doctrine\DBAL\DBALException;
use KGzocha\ArduinoBundle\Entity\BooleanParameter;
use KGzocha\ArduinoBundle\Form\BooleanParameterForm;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BoolParametersController extends Controller
{
    /**
     * @Route("/parameters/list/{page}",
     *  name="arduino_bool_params_list",
     *  requirements={"page" = "\d+"},
     *  defaults={"page"=1}
     * )
     * @Template()
     */
    public function listAction($page)
    {
        $itemsPerPage = $this->container->getParameter('items_per_page');
        $pagerfanta = new Pagerfanta(
            new DoctrineORMAdapter($this->getRepository()->findAllQuery())
        );
        $pagerfanta->setMaxPerPage($itemsPerPage);
        $pagerfanta->setCurrentPage($page);

        return array(
            'manager' => $this->getBoolParamsManager(),
            'pagerfanta' => $pagerfanta,
            'itemsPerPage' => $itemsPerPage,
        );
    }

    /**
     * @Route("/parameters/edit/{id}", name="arduino_bool_params_edit")
     * @ParamConverter("booleanParameter", class="ArduinoBundle:BooleanParameter")
     * @Template()
     */
    public function editAction(Request $request, BooleanParameter $booleanParameter)
    {
        $form = $this->createForm(new BooleanParameterForm(), $booleanParameter);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booleanParameter);

            try {
                $entityManager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Parameter was successfuly edited.');

                return $this->redirect(
                    $this->generateUrl('arduino_bool_params_list')
                );
            } catch (DBALException $exception) {
                $this->get('logger')->error($exception->getMessage());
                $this->get('session')->getFlashBag()->add('danger', 'An error occured while editing parameter.');
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ArduinoBundle:BooleanParameter');
    }

    /**
     * @return \KGzocha\ArduinoBundle\Service\BooleanParameters\BooleanParameterManager
     */
    protected function getBoolParamsManager()
    {
        return $this->get('arduino.bool_params.manager');
    }
}

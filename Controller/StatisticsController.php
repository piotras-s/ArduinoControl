<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends Controller
{
    /**
     * @Route("/stats/temp", name="arduino_stats_temp")
     */
    public function thermometerStatsAction(Request $request)
    {
        return $this->actionDefault(
            $request,
            $this->getThermometerForm()
        );
    }

    /**
     * @Route("/stats/pins", name="arduino_stats_pins")
     */
    public function pinStatsAction(Request $request)
    {
        return $this->actionDefault(
            $request,
            $this->getPinForm()
        );
    }

    /**
     * @Route("/stats/params", name="arduino_stats_params")
     */
    public function boolParamsAction(Request $request)
    {
        return $this->actionDefault(
            $request,
            $this->getBoolParamsForm(),
            true
        );
    }

    /**
     * @Route("/stats/response-time", name="arduino_stats_time")
     */
    public function responseTimeStatsAction(Request $request)
    {
        return $this->actionDefault(
            $request,
            $this->getResponseForm()
        );
    }

    /**
     * @param Request                 $request
     * @param StatisticsFormInterface $form
     * @param bool                    $squareWave
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function actionDefault(Request $request, StatisticsFormInterface $form, $squareWave = false)
    {
        $formHandler = $this->get('arduino.form.handler.statistics')->setFormClass($form)->createForm();
        $formHandler->handle($request);

        if (!$squareWave) {
            $data = $this->getStatisticsParser()->getStatisticsFromHandler(
                $formHandler
            );
        } else {
            $data = $this->getStatisticsParser()->giveSquareWaveStatisticsFromHandler(
                $formHandler
            );
        }

        return $this->render('ArduinoBundle:Statistics:data.html.twig',
            array(
                'formHandler' => $formHandler,
                'form' => $formHandler->getForm()->createView(),
                'data' => $data,
                'label' => $form->getFormLabel(),
            )
        );
    }

    /**
     * @return \KGzocha\ArduinoBundle\Service\Statistics\StatisticsParser
     */
    protected function getStatisticsParser()
    {
        return $this->get('arduino.statistics.parser');
    }

    /**
     * @return StatisticsFormInterface
     */
    protected function getThermometerForm()
    {
        return $this->get('arduino.form.thermometer_form');
    }

    /**
     * @return StatisticsFormInterface
     */
    protected function getPinForm()
    {
        return $this->get('arduino.form.pin_status_form');
    }

    /**
     * @return StatisticsFormInterface
     */
    protected function getBoolParamsForm()
    {
        return $this->get('arduino.form.bool_param_form');
    }

    /**
     * @return StatisticsFormInterface
     */
    protected function getResponseForm()
    {
        return $this->get('arduino.form.response_form');
    }

}

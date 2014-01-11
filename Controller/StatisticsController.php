<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\ResponseTimeForm\ResponseTimeFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormHanlderInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\ThermometerForm\ThermometerFormHandler;
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
            $this->getThermometerFormHandler(),
            'Temperature'
        );
    }

    /**
     * @Route("/stats/pins", name="arduino_stats_pins")
     */
    public function pinStatsAction(Request $request)
    {
        return $this->actionDefault(
            $request,
            $this->getPinFormHandler(),
            'Voltage'
        );
    }

    /**
     * @Route("/stats/response-time", name="arduino_stats_time")
     */
    public function responseTimeStatsAction(Request $request)
    {
        return $this->actionDefault(
            $request,
            $this->getResponseFormHandler(),
            'Response time in ms'
        );
    }

    /**
     * @param Request                        $request
     * @param StatisticsFormHanlderInterface $formHandler
     * @param                                $label
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function actionDefault(Request $request, StatisticsFormHanlderInterface $formHandler, $label)
    {
        $formHandler = $formHandler->createForm();
        $formHandler->handle($request);

        $data = $this->getStatisticsParser()->getStatisticsFromHandler(
            $formHandler
        );

        return $this->render('ArduinoBundle:Statistics:data.html.twig',
            array(
                'formHandler' => $formHandler,
                'form' => $formHandler->getForm()->createView(),
                'data' => $data,
                'label' => $label,
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
     * @return ThermometerFormHandler
     */
    protected function getThermometerFormHandler()
    {
        return $this->get('arduino.form.handler.thermometer_form');
    }

    /**
     * @return \KGzocha\ArduinoBundle\Service\FormHandler\Statistics\PinsForm\PinsFormHandler
     */
    protected function getPinFormHandler()
    {
        return $this->get('arduino.form.handler.pin_status_form');
    }

    /**
     * @return ResponseTimeFormHandler
     */
    protected function getResponseFormHandler()
    {
        return $this->get('arduino.form.handler.response_form');
    }

}

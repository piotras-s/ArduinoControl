<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Service\FormHandler\ThermometerForm\ThermometerFormHandler;
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
        /** @var ThermometerFormHandler $formHandler */
        $formHandler = $this->getThermometerFormHandler()->createForm();
        $formHandler->handle($request);

        $data = $this->getStatisticsParser()->getStatisticsFromHandler(
            $formHandler
        );

        return $this->render('ArduinoBundle:Statistics:data.html.twig',
            array(
                'formHandler' => $formHandler,
                'form' => $formHandler->getForm()->createView(),
                'data' => $data,
                'label' => 'Temperature',
            )
        );
    }

    /**
     * @Route("/stats/pins", name="arduino_stats_pins")
     */
    public function pinStatsAction(Request $request)
    {
        /** @var ThermometerFormHandler $formHandler */
        $formHandler = $this->getPinFormHandler()->createForm();
        $formHandler->handle($request);

        $data = $this->getStatisticsParser()->getStatisticsFromHandler(
            $formHandler
        );

        return $this->render('ArduinoBundle:Statistics:data.html.twig',
            array(
                'formHandler' => $formHandler,
                'form' => $formHandler->getForm()->createView(),
                'data' => $data,
                'label' => 'Voltage',
            )
        );
    }

    /**
     * @Route("/stats/response-time", name="arduino_stats_time")
     */
    public function responseTimeStatsAction(Request $request)
    {
        return $this->render('ArduinoBundle:Statistics:data.html.twig',
            array(
                'data' => $this->getStatisticsParser()->getStatistics('ArduinoBundle:ResponseLog', 0),
                'label' => 'Response time in ms',
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
     * @return \KGzocha\ArduinoBundle\Service\FormHandler\PinsForm\PinsFormHandler
     */
    protected function getPinFormHandler()
    {
        return $this->get('arduino.form.handler.pin_status_form');
    }

}

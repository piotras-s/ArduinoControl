<?php

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Entity\TemperatureLog;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\ArduinoConnectorException;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\PinsForm\PinsFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\ThermometerForm\ThermometerFormHandler;
use KGzocha\ArduinoBundle\Service\Statistics\StatisticsParser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
    /**
     * @Route("/send/{name}", name="arduino_send")
     * @Template()
     * @Cache()
     * @param $name
     *
     * @return array
     */
    public function sendAction($name)
    {
        /** @var ConnectorInterface $connector */
        $connector = $this->get('arduino.connector.factory')->getConnectorFromDatabase();

        $connector->connect();
        $address = '';
        try {
            $address = $connector->sendRequest();
        } catch (ArduinoConnectorException $exception) {
            $this->get('session')->getFlashBag()->add('danger', $exception->getMessage());
        }

        return array(
            'address' => $address,
            'connector' => $connector
        );
    }

    /**
     * @Route("/", name="arduino_main")
     * @Template()
     * @Cache
     */
    public function mainAction(Request $request)
    {
        /** @var StatisticsParser $parser */
        $parser = $this->get('arduino.statistics.parser');

        /** @var ThermometerFormHandler $formHandler */
        $formHandler = $this->get('arduino.form.handler.thermometer_form')->createForm();
        $formHandler->handle($request);
        $thermometer = $parser->getStatistics(
            'ArduinoBundle:TemperatureLog',
            $formHandler->getThermometer()->getId()
        );

        /** @var PinsFormHandler $pinFormHandler */
        $pinFormHandler = $this->get('arduino.form.handler.pin_status_form')->createForm();
        $pinFormHandler->handle($request);
        $pins = $parser->getStatistics(
            'ArduinoBundle:PinStatusLog',
            $pinFormHandler->getPin()->getId()
        );

        $responseTime = $parser->getStatistics('ArduinoBundle:ResponseLog', 0);

        return array(
            'repository' => $this->get('doctrine')->getRepository('ArduinoBundle:ResponseLog'),
            'data' => $thermometer,
            'form' => $formHandler->getForm()->createView(),
            'pin_form' => $pinFormHandler->getForm()->createView(),
            'pin_data' => $pins,
            'time_data' => $responseTime,
        );
    }
}

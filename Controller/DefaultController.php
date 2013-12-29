<?php

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\ArduinoConnectorException;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorInterface;
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
        return array(
            'repository' => $this->get('doctrine')->getRepository('ArduinoBundle:ResponseLog'),
        );
    }
}

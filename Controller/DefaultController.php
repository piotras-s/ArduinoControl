<?php

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\ArduinoConnectorWrapper;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\WebArduinoConnector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
	/**
	 * @Route("/{name}", name="arduino_index")
	 * @Template()
	 * @Cache()
	 * @param $name
	 *
	 * @return array
	 */
	public function indexAction($name)
    {

		$connector = $this->get('arduino.connector.factory')->getConnector();

	    $connector->connect();
	    $adress = $connector->sendRequest(
		    array('test' => 'test')
	    );

        return array(
	        'adress' => $adress,
	        'connector' => $connector
        );
    }
}

<?php

namespace KGzocha\ArduinoBundle\Controller;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorFactory;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\ConnectorInterface;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\ConnectorSettingsFromDatabase;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\WebArduinoConnectorSettings;
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
	    /** @var ConnectorInterface $connector */
	    $connector = $this->get('arduino.connector.factory')->getConnectorFromDatabase();

	    $connector->connect();
	    $address = $connector->sendRequest(
		    array('1' => $name)
	    );

        return array(
	        'address' => $address,
	        'connector' => $connector
        );
    }
}

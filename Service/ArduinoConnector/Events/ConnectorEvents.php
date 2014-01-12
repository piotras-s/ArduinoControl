<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Events;


final class ConnectorEvents
{
    const CONNECTOR_SET = 'arduino.connector.set';

    const CONNECTOR_PRE_CONNECT = 'arduino.connector.pre_connect';
    const CONNECTOR_POST_CONNECT = 'arduino.connector.post_connect';

    const CONNECTOR_PRE_DISCONNECT = 'arduino.connector.pre_disconnect';
    const CONNECTOR_POST_DISCONNECT = 'arduino.connector.post_disconnect';

    const CONNECTOR_PRE_SEND_REQUEST = 'arduino.connector.pre_send_request';
    const CONNECTOR_POST_SEND_REQUEST = 'arduino.connector.post_send_request';
}
 
<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings;

interface ConnectorSettingsInterface
{
    public function getConnectorClass();
    public function getFormAlias();
    public function getFieldsToSave();
}

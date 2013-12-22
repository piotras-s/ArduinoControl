<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\ConnectorSettingsInterface;

abstract class AbstractArduinoConnector implements ConnectorInterface
{

    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $response;

    /**
     * @var float
     */
    protected $time;

    /**
     * @var ConnectorSettingsInterface
     */
    protected $settings;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @return $this
     */
    public function connect()
    {
        $this->setStatus(self::STATUS_ENABLED);

        return $this;
    }

    /**
     * @return $this
     */
    public function disconnect()
    {
        $this->setStatus(self::STATUS_DISABLED);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getPossibleStatuses()
    {
        return array(
            self::STATUS_DISABLED => 'disabled',
            self::STATUS_ENABLED => 'enabled',
        );
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return self::STATUS_ENABLED === $this->getStatus();
    }

    /**
     * @return float
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return ConnectorSettingsInterface|mixed
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param int      $timeBeforeAction
     * @param int|null $timeAfterAction
     */
    protected function setTimeDiffer($timeBeforeAction, $timeAfterAction = null)
    {
        if (!$timeAfterAction) {
            $timeAfterAction = microtime();
        }
        $this->time = sprintf('%2.2f', abs($timeBeforeAction - $timeAfterAction)*100);
    }

    /**
     * @param $status
     *
     * @return mixed
     */
    protected function setStatus($status)
    {
        $this->status = $status;

        return $status;
    }

}

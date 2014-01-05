<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\ArduinoConnectorException;

class WebConnectorSettingsFromDatabase extends WebConnectorSettings
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $settingsPrefix;

    /**
     * @var array
     */
    protected $configuration;

    public function __construct(EntityManager $em, $settingsPrefix)
    {
        $this->em = $em;
        $this->settingsPrefix = $settingsPrefix;
        $this->getSettings();
    }

    /**
     * @return WebConnectorSettingsFromDatabase
     */
    protected function getSettings()
    {
        $this->configuration = $this
            ->em
            ->getRepository('KGzocha\ArduinoBundle\Entity\Settings')
            ->findAllByPrefix($this->settingsPrefix);

        $this->setFieldsValue($this->getFieldsToSave());

        return $this;
    }

    /**
     * @param $key
     *
     * @throws ArduinoConnectorException
     * @return mixed
     */
    protected function getSingleSetting($key)
    {
        $key = $this->settingsPrefix . $key;
        /** @var KGzocha\ArduinoBundle\Entity\Settings $setting */
        foreach ($this->configuration as $setting) {
            if ($key == $setting->getName()) {
                return $setting->getValue();
            }
        }

        throw new ArduinoConnectorException(sprintf('Missing %s connector parameter', $key));
    }

    /**
     * @param array $fields
     */
    protected function setFieldsValue(array $fields)
    {
        foreach ($fields as $field) {
            $setter = sprintf('%s%s', 'set', ucfirst($field));
            try {
                $this->$setter($this->getSingleSetting($field));
            } catch (ArduinoConnectorException $exception) {

            }
        }
    }

}

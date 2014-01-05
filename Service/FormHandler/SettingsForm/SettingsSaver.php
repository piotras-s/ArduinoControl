<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Settings;

class SettingsSaver
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $prefix;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Saves prefixed setting into db
     * @param $key
     * @param $value
     */
    public function saveSetting($key, $value)
    {
        $setting = $this->getSetting($key);
        if (!$setting) {
            $setting = new Settings();
        }

        $setting->setName(sprintf('%s%s', $this->prefix, $key))->setValue($value);
        $this->entityManager->persist($setting);
    }

    /**
     * @param \stdClass $object
     * @param array     $fields
     */
    public function saveSettingsFormClass($object, array $fields)
    {
        foreach ($fields as $field) {
            $getterMethod = sprintf('%s%s', 'get', ucfirst($field));
            $this->saveSetting(
                $field,
                $object->$getterMethod()
            );
        }

        $this->flush();
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

    /**
     * @param $key
     *
     * @return \KGzocha\ArduinoBundle\Entity\Settings
     */
    protected function getSetting($key)
    {
        return $this->entityManager->getRepository('ArduinoBundle:Settings')->findOneBy(array(
                'name' => sprintf('%s%s', $this->prefix, $key)
            ));
    }

}

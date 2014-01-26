<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Settings;

class SettingsSaver implements SettingsSaverInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $glue;

    public function __construct(EntityManager $entityManager, $glue)
    {
        $this->entityManager = $entityManager;
        $this->glue = $glue;
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

        $setting->setName($key)->setValue($value);
        $this->entityManager->persist($setting);
    }

    /**
     * @param  string                 $name
     * @param  \stdClass              $object
     * @param  array                  $fields
     * @throws SettingsSaverException
     */
    public function saveSettingsFromClass($name, $object, array $fields)
    {
        foreach ($fields as $field) {
            $getterMethod = sprintf('%s%s', 'get', ucfirst($field));
            if (!method_exists($object, $getterMethod)) {
                throw new SettingsSaverException(
                    sprintf("Given object (%s) does not have method %s.", get_class($object), $getterMethod)
                );
            }

            $this->saveSetting(
                $this->prefixField($name, $field),
                $object->$getterMethod()
            );
        }
    }

    /**
     * Flushes changes
     */
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
                'name' => $key
            ));
    }

    /**
     * @param $name
     * @param $field
     *
     * @return string
     */
    protected function prefixField($name, $field)
    {
        return sprintf('%s%s%s', $name, $this->glue, $field);
    }

}

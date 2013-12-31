<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SettingsGroupInterface;

class SettingsSaver implements SettingsSaverInterface
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->configuration = array();
    }

    /**
     * @param SettingsGroupInterface $settingsGroup
     */
    public function saveSettings(SettingsGroupInterface $settingsGroup)
    {
        foreach ($settingsGroup->getFields() as $field) {
            $getterMethod = $this->getGetterMethod($field);
            $setting = $this->getOrCreateSetting(
                $settingsGroup->getPrefix(),
                $field,
                $settingsGroup->$getterMethod()
            );

            $this->entityManager->persist($setting);
        }

        $this->entityManager->flush();
    }

    /**
     * @param $prefix
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    protected function getOrCreateSetting($prefix, $name, $value)
    {
        $name = $this->getPrefixed($prefix, $name);

        foreach ($this->getSavedFields($prefix) as $setting) {
            if ($name === $setting->getName()) {
                $setting->setValue($value);

                return $setting;
            }
        }

        return (new Settings())->setName($name)->setValue($value);
    }

    /**
     * @param $prefix
     *
     * @return array
     */
    protected function getSavedFields($prefix)
    {
        return $this
            ->entityManager
            ->getRepository('ArduinoBundle:Settings')
            ->findAllByPrefix($prefix);
    }

    /**
     * @param $field
     *
     * @return string
     */
    protected function getGetterMethod($field)
    {
        return sprintf('%s%s', 'get', ucfirst($field));
    }

    /**
     * @param $prefix
     * @param $name
     *
     * @return string
     */
    protected function getPrefixed($prefix, $name)
    {
        return sprintf('%s%s', $prefix, $name);
    }

}

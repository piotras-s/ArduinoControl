<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings\SettingsGroupInterface;

class SettingsGiver implements SettingsGiverInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var array
     */
    protected $allSettingsFound;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->allSettingsFound = array();
    }

    /**
     * @param SettingsGroupInterface $settingsGroup
     *
     * @return SettingsGroupInterface
     */
    public function loadSettings(SettingsGroupInterface $settingsGroup)
    {
        $this->loadAllByPrefix($settingsGroup->getPrefix());

        foreach ($settingsGroup->getFields() as $field) {
            $setterMethod = $this->getSetterMethod($field);
            $settingsGroup->$setterMethod(
                $this->getSingleSettingValue(
                    $settingsGroup->getPrefix(),
                    $field
                )
            );
        }

        return $settingsGroup;
    }

    /**
     * @param $field
     *
     * @return string
     */
    protected function getSetterMethod($field)
    {
        return sprintf('%s%s', 'set', ucfirst($field));
    }

    /**
     * @param $prefix
     * @param $key
     *
     * @return mixed
     */
    protected function getSingleSettingValue($prefix, $key)
    {
        $key = sprintf('%s%s', $prefix, $key);

        /** @var KGzocha\ArduinoBundle\Entity\Settings $setting */
        foreach ($this->allSettingsFound as $setting) {
            if ($key == $setting->getName()) {
                return $setting->getValue();
            }
        }
    }

    /**
     * @param $prefix
     */
    protected function loadAllByPrefix($prefix)
    {
        $this->allSettingsFound = $this->configuration = $this
            ->entityManager
            ->getRepository('ArduinoBundle:Settings')
            ->findAllByPrefix($prefix);
    }
}

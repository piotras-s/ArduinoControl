<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Settings;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Settings;
use KGzocha\ArduinoBundle\Service\Settings\SettingsGiverException;

class SettingsGiver implements SettingsGiverInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $glue;

    /**
     * @param EntityManager $entityManager
     * @param               $glue
     */
    public function __construct(EntityManager $entityManager, $glue)
    {
        $this->entityManager = $entityManager;
        $this->glue = $glue;
    }

    /**
     * @param $name
     * @param $defaultValue
     * @return string
     */
    public function giveValue($name, $defaultValue = null)
    {
        $value = $this->getRepository()->findOneBy(array(
                'name' => $name,
            ));

        if (null === $value) {
            return $defaultValue;
        }

        return $value;
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function giveAllSettings($name)
    {
        return $this->getRepository()->findAllByPrefix(
            $name
        );
    }

    /**
     * @param                         $name
     * @param                         $object
     * @param  array                  $fields
     * @throws SettingsGiverException
     */
    public function giveAllSettingsToClass($name, $object, array $fields)
    {
        $allSettings = $this->giveAllSettings($name);

        foreach ($fields as $field) {
            $setter = $this->getSetterName($field);
            if (!method_exists($object, $setter)) {
                throw new SettingsGiverException(
                    sprintf("Given object (%s) does not have method %s.", get_class($object), $setter)
                );
            }

            $object->$setter(
                $this->findValueByName(
                    $this->prefixField($name, $field),
                    $allSettings)
            );
        }
    }

    /**
     * @return \KGzocha\ArduinoBundle\Repository\SettingsRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository('ArduinoBundle:Settings');
    }

    /**
     * @param $field
     *
     * @return string
     */
    protected function getSetterName($field)
    {
        return sprintf('%s%s', 'set', ucfirst($field));
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

    /**
     * @param       $fieldName
     * @param array $fields
     *
     * @return null|string
     */
    protected function findValueByName($fieldName, array $fields)
    {
        /** @var Settings $field */
        foreach ($fields as $field) {
            if ($fieldName === $field->getName()) {
                return $field->getValue();
            }
        }

        return null;
    }

}

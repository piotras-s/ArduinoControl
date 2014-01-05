<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm\Connector;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\ConnectorSettingsInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\AbstractFormHandler;
use KGzocha\ArduinoBundle\Service\FormHandler\FormHandlerInterface;
use KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm\SettingsException;
use KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm\SettingsSaver;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class ConnectorSettingsFormHandler extends AbstractFormHandler implements FormHandlerInterface
{

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @var \KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm\SettingsSaver
     */
    protected $saver;

    /**
     * @var array<ConnectorSettingsInterface>
     */
    protected $connectorSettingsClasses;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function __construct(FormFactory $formFactory, SettingsSaver $saver,
        EntityManager $entityManager, $settingsPrefix)
    {
        $this->formFactory = $formFactory;
        $this->saver = $saver;
        $this->entityManager = $entityManager;
        $this->saver->setPrefix($settingsPrefix);
        $this->connectorSettingsClasses = array();
    }

    /**
     * @throws \KGzocha\ArduinoBundle\Service\FormHandler\SettingsForm\SettingsException
     *
     * @return $this
     */
    public function createForm()
    {
        $connectorClassName = $this->entityManager->getRepository('ArduinoBundle:Settings')->findOneBy(array(
                'name' => 'connector.class',
            ));

        if (!$connectorClassName) {
            throw new SettingsException("Connector class name can not be null");
        } else {
            $connectorClassName = $connectorClassName->getValue();
        }

        if (!class_exists($connectorClassName)) {
            throw new SettingsException(sprintf('Connector class "%s" does not exists in the system', $connectorClassName));
        }

        $this->form = $this->formFactory->create(
            $this->getFormAliasFromConnectorClassName($connectorClassName),
            $this->getModelFromConnectorClassName($connectorClassName)
        );

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return boolean
     */
    public function handle(Request $request)
    {
        /** @var ConnectorSettingsInterface $model */
        $model = $this->getForm()->getData();
        if (parent::handle($request)) {
            $this->saver->saveSettingsFormClass($model, $model->getFieldsToSave());

            return true;
        }

        return false;
    }

    /**
     * @param string $connectorClassName
     *
     * @return mixed
     */
    protected function getFormAliasFromConnectorClassName($connectorClassName)
    {
        /** @var ConnectorSettingsInterface $connectorSetting */
        foreach ($this->connectorSettingsClasses as $connectorSetting) {
            if ($connectorClassName === $connectorSetting->getConnectorClass()) {
                return $connectorSetting->getFormAlias();
            }
        }
    }

    /**
     * @param $connectorClassName
     *
     * @return ConnectorSettingsInterface
     */
    protected function getModelFromConnectorClassName($connectorClassName)
    {
        /** @var ConnectorSettingsInterface $connectorSetting */
        foreach ($this->connectorSettingsClasses as $connectorSetting) {
            if ($connectorClassName === $connectorSetting->getConnectorClass()) {
                return $connectorSetting;
            }
        }
    }

    /**
     * @param ConnectorSettingsInterface $connectorSetting
     */
    public function addConenctorSettingsClass(ConnectorSettingsInterface $connectorSetting)
    {
        $this->connectorSettingsClasses[] = $connectorSetting;
    }

}

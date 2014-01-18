<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\Connector;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConnectorClassSettings extends AbstractType
{
    /**
     * @var array
     */
    protected $choiceList;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('class', 'choice', array(
                'choices' => $this->choiceList,
                'label' => 'Pick class to use as connector',
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
                'data_class' => 'KGzocha\ArduinoBundle\Form\SettingsForm\Connector\ConnectorClassSettingsModel',
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'connector_class_settings';
    }

    /**
     * @param array $choiceList
     */
    public function setChoiceList(array $choiceList)
    {
        $this->choiceList = array_combine($choiceList, $choiceList);
        $this->shortValue();
    }

    /**
     * Will truncate class namespace
     */
    protected function shortValue()
    {
        foreach ($this->choiceList as &$value) {
            $spaces = explode('\\', $value);
            $value = array_pop($spaces);
        }
    }

}

<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Form\SettingsForm\SingleSettings;

use Symfony\Component\Form\FormBuilderInterface;

interface SingleSettingInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options);
}

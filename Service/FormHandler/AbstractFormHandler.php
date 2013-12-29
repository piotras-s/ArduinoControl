<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractFormHandler implements FormHandlerInterface
{
    /**
     * @var Form
     */
    protected $form;

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        $this->form->handleRequest($request);

        return $this->form->isValid();
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}

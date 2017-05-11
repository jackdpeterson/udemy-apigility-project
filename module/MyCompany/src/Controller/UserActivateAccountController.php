<?php


namespace MyCompany\Controller;


class UserActivateAccountController
{
    public function activateAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);

        $view->setVariables(array(
            'requestParams' => $this->params()
                ->fromRoute()
        ));

        return $view;
    }
}
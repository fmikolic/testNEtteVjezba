<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;

class SignPresenter extends Presenter
{
    function createComponentSignInForm(): Form
    {
        $form=new Form;

        $form->addText('username', 'Username:')->setRequired('Username is empty!');
        $form->addPassword('password', 'Password:')->setRequired('Password is empty!');
        $form->addSubmit('submit', 'Sign in');

        $form->onSuccess[]=[$this, 'signInFormSucceeded'];

        return $form;
    }

    public function signInFormSucceeded(Form $form, \stdClass $data): void
    {
        try {
            $this->getUser()->login($data->username, $data->password);
            $this->redirect('Homepage');
        }catch (Nette\Security\AuthenticationException $e){
            $form->addError('User does not exist!');
        }
    }
    public function actionOut(): void{
        $this->getUser()->logout();
        $this->flashMessage('Logged out');
        $this->redirect('Homepage');
    }
}
<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    private $passwords;
    public function __construct(Passwords $passwords)
    {
        $this->passwords=$passwords;
    }
    protected function startup()
    {
        parent::startup();
    }

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
            $section=$this->session->getSection("loginSection");
            $section->set('userName', $data->username);
            //$section->set('userName', $data->username);
            $this->redirect('Secret:');
        }catch (Nette\Security\AuthenticationException $e){
            $form->addError('Login failed!');
        }
    }
    public function actionOut(): void{
        $this->getUser()->logout();
        $this->flashMessage('Logged out');
        $this->redirect('Homepage');
    }
}

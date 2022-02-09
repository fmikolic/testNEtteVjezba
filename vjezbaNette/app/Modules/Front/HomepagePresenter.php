<?php

declare(strict_types=1);

namespace App\Modules\Front;

use App\Helpers\MyAuthenticator;
use App\Model\DatabaseFacade;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette;
use Nette\Application\UI\Form;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{

    private DatabaseFacade $facade;
    private MyAuthenticator $authenticator;

    public function __construct(DatabaseFacade $facade, MyAuthenticator $authenticator)
    {
        $this->facade = $facade;
        $this->authenticator = $authenticator;
    }

    protected function startup()
    {
        parent::startup();
    }

    function createComponentSignInForm(): Form
    {
        $form = new BootstrapForm;
        $form->renderMode = RenderMode::INLINE;

        $form->addText('username', 'Username:')->setRequired('Username is empty!');
        $form->addPassword('password', 'Password:')->setRequired('Password is empty!');
        $form->addSubmit('submit', 'Sign in');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];

        return $form;
    }

    public function signInFormSucceeded(Form $form, \stdClass $data): void
    {
        try {
            $this->getUser()->login($data->username, $data->password);
            $this->redirect('Secret:');

        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage("Login failed", 'error');
            //$form->addError('Login failed!');
        }
    }

    public function actionOut(): void
    {
        $this->getUser()->logout();
        $this->flashMessage('Logged out');
        $this->redirect('Homepage');
    }
}

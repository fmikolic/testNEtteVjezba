<?php

namespace App\Modules\Admin;

use App\Model\DatabaseFacade;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class EditUserPresenter extends Presenter
{
    private DatabaseFacade $facade;

    public function __construct(DatabaseFacade $facade)
    {
        $this->facade = $facade;
    }

    public function actionAdd(): void
    {
        $form = $this->getComponent('userForm');
        $form->onSuccess[] = [$this, 'addNewUserSuceeded'];
    }

    public function actionEdit(int $id): void
    {
        $record = $this->facade->getUserInfo($id);
        if (!$record) {
            $this->error();
        }
        $form = $this->getComponent('userForm');
        $form->setDefaults($record);
        $form->onSuccess[] = [$this, 'editUserSuceeded'];
    }

    protected function createComponentUserForm(): BootstrapForm
    {
        if (!in_array($this->getAction(), ['add', 'edit'])) {
            $this->error();
        }

        $form = new BootstrapForm;
        $form->renderMode = RenderMode::VERTICAL_MODE;

        $form->addText('username', 'Username:');
        $form->addPassword('password', 'Password:');
        $form->addPassword('password1', 'Repeat password:')->addRule($form::NOT_EQUAL, 'Passwords are not the same!', ['password']);
        $form->addText('first_name', 'First name:');
        $form->addText('last_name', 'Last name:');
        $form->addText('address', 'Address');
        $form->addDate('birthdate', 'Birthday');
        $form->addSubmit('submit', 'Apply');

        return $form;
    }

    public function addNewUserSuceeded(Form $form, array $data): void
    {
        $this->facade->add($data);
        $this->flashMessage('Added new user to the database');
        $this->redirect('Users:');
    }

    public function editUserSuceeded(Form $form, array $data): void
    {
        $id = (int)$this->getParameter('id');
        if ($data['password'] == '' && $data['password1'] == '') {
            $this->facade->updateNoPassword($id, $data);
            $this->flashMessage('Edited user in the database');
        } else if ($data['password'] === $data['password1']) {
            $this->facade->updateWithPassword($id, $data);
            $this->flashMessage('Edited user in the database');
        } else {
            $this->flashMessage('Passwords are not the same');
        }

        $this->redirect('Users:');
    }
}
<?php

namespace App\Presenters;

use App\Model\DatabaseFacade;
use Nette\Application\UI\Presenter;
use Nette\Http\Session;

class UsersPresenter extends Presenter
{

    public Session $session;
    public DatabaseFacade $facade;

    public function __construct(Session $session, DatabaseFacade $facade)
    {
        $this->session = $session;
        $this->facade = $facade;
    }

    protected function startup()
    {
        parent::startup();
    }

    public function actionDefault(): void
    {
        $this->template->data=$this->facade->getUsers();
    }
}
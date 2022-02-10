<?php

declare(strict_types=1);

namespace App\Modules\Front;

use App\Model\DatabaseFacade;
use Nette\Application\UI\Presenter;
use Nette\Http\Session;

class SecretPresenter extends Presenter
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
        $userID = $this->user->getId();

        $this->template->data=$this->facade->getUserSecretText($userID);
        $this->template->roles=$this->user->getRoles();

    }


}
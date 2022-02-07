<?php

declare(strict_types=1);
namespace App\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Http\Session;

class SecretPresenter extends Presenter
{
    public $session;
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    protected function startup()
    {

        parent::startup();
        $this->isLoggedUsername();

    }

    public function actionDefault(): void
    {

    }

    public function isLoggedUsername():void {
        $section=$this->session->getSection("loginSection");
        $username = $section->get("userName");
        echo $username;

    }

}
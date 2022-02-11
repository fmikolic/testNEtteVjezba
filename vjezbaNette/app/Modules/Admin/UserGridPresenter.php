<?php

namespace App\Modules\Admin;

use App\Model\DatabaseFacade;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;

class UserGridPresenter extends Presenter
{
    private DatabaseFacade $facade;

    public function __construct(DatabaseFacade $facade)
    {
        parent::__construct();
        $this->facade = $facade;
    }

    public function createComponentUserGrid(string $name)
    {
        $grid = new DataGrid($this, $name);

        $grid->setDataSource($this->facade->getUsers());
        $grid->addColumnText('username', 'Username');
        $grid->addColumnText('first_name', 'First name');
        $grid->addColumnText('last_name', 'Last name');
        $grid->addColumnText('address', 'Address');
        $grid->addColumnDateTime('birthdate', 'Birthdate');

    }
}
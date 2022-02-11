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

    public function createComponentUserGrid(): DataGrid
    {
        $grid = new DataGrid();

        $grid->setDataSource($this->facade->getUsers());
        $grid->addColumnNumber('id', 'ID')->setAlign('left')->setSortable();
        $grid->addColumnText('username', 'Username')->setSortable()->setFilterText();
        $grid->addColumnText('first_name', 'First name')->setSortable()->setFilterText();
        $grid->addColumnText('last_name', 'Last name')->setSortable()->setFilterText();
        $grid->addColumnText('address', 'Address')->setSortable();
        $grid->addColumnDateTime('birthdate', 'Birthdate')->setSortable();
        $grid->addColumnStatus('admin_role','Is admin')->setSortable();

        $grid->addGroupButtonAction('Change admin role')->onClick[]=[$this, 'changeAdminRole'];

        return $grid;
    }

    public function changeAdminRole(array $ids){
        echo 'lol';

    }
}
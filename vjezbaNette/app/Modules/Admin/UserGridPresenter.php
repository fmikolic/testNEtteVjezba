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
        $grid->addColumnStatus('admin_role', 'Is admin')->setSortable();

        $grid->addGroupAction('Change admin role')->onSelect[] = [$this, 'isAdminRole'];

        return $grid;
    }

    public function isAdminRole(array $ids): void
    {
        foreach ($ids as $id) {
            (int)$id = $id;
            $this->changeAdminRole($id);
        }
        $this->redirect('this');
    }

    public function changeAdminRole(int $id)
    {
        $row = $this->facade->getUserInfo($id);
        $row->admin_role = empty($row->admin_role) ? TRUE : FALSE;
        $this->facade->updateNoPassword((int)$row->id, $row);

    }
}
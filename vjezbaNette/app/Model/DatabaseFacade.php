<?php

namespace App\Model;

use Nette\Database\Explorer;
use Nette\SmartObject;

class DatabaseFacade
{
    use SmartObject;
    private Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database=$database;
    }

    public function getUser()
    {
        $result= $this->database->query('SELECT * FROM users');
        return $result->getRowCount();
    }

    public function getUserSecretText($userId)
    {
        $result=$this->database->query('SELECT data FROM secret_data WHERE id=?', $userId);
        return $result->fetchAll();
    }
}
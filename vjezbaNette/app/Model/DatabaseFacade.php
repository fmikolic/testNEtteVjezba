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

    public function getUsers()
    {
        $result= $this->database->query('SELECT * FROM users');
        return $result->fetchAll();
    }

    public function getUserSecretText($userId)
    {
        $result=$this->database->query('SELECT data FROM secret_data WHERE user_id=?', $userId);
        return $result->fetchAll();
    }

    public function add(array $data){

    }

    public function update(int $id,array $data){
        $result=$this->database->query('SELECT * FROM users WHERE id=?', $id);
        return $result->valid();
    }

    public function getUserInfo(int $id){
        $result=$this->database->query('SELECT * FROM users WHERE id=?', $id);
        return $result->fetch();
    }


}
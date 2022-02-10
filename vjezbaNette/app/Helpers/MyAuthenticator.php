<?php

namespace App\Helpers;

use Nette\Database\Explorer;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;


class MyAuthenticator implements Authenticator
{

    private Explorer $database;
    private Passwords $passwords;

    public function __construct( Explorer $database, Passwords $passwords)
    {
        $this->database=$database;
        $this->passwords=$passwords;
    }

    public function authenticate(string $username, string $password): SimpleIdentity
    {
        $row = $this->database->table('users')->where('username', $username)->fetch();

        if(!$row)
        {
            throw new AuthenticationException('User not found');
        }
        if(!$this->passwords->verify($password, $row->password))
        {
            throw new AuthenticationException('Password not correct');
        }

        return new SimpleIdentity(
            $row->id,
            $row->admin_role,
            ['username'=>$row->username]
        );
    }
}
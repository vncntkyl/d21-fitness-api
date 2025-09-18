<?php

require_once __DIR__ . "/controller.php";

class AuthController extends Controller
{
    public function login($username)
    {
        $this->setStatement("SELECT ID, password FROM accounts 
        WHERE (username = :username 
        OR email_address = :username) AND status <> 0");
        $this->statement->execute([':username' => $username]);
        return $this->statement->fetch();
    }

    public function register()
    {
    }

    public function addToken($id, $token)
    {
        return $this->editRecords("accounts", ['token', 'last_online'], [$token, date("Y-m-d H:i:s")], ["ID"], [$id]);
    }
}
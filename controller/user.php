<?php

require_once __DIR__ . "/controller.php";

class UserController extends Controller
{
    public function get()
    {
        return $this->execute("SELECT a.ID, u.first_name, u.middle_name, u.last_name, a.username, a.email_address, a.contact_number, u.address, u.birthday, a.role, a.token, a.status FROM users u JOIN accounts a ON u.account_id = a.ID WHERE a.status <> 0;");
    }
    public function getOne($id)
    {
        $result = $this->execute("SELECT a.ID, u.first_name, u.middle_name, u.last_name, a.username, a.email_address, a.contact_number, u.address, u.birthday, a.role, a.token, a.status FROM users u JOIN accounts a ON u.account_id = a.ID WHERE a.status <> 0 AND (a.ID = :id OR a.token = :id);", [":id" => $id]);
        return $result[0];
    }
}
<?php

require_once __DIR__ . "/controller.php";

class RoleController extends Controller
{
    public function get()
    {
        return $this->execute("SELECT rp.role_id, rp.module_id, rp.ID as permission_id, r.name, r.description, rm.name as module, r.status,rp.can_view, rp.can_add, rp.can_edit, rp.can_delete, r.created_at, rp.modified_at FROM roles r JOIN role_permissions rp ON rp.role_id = r.ID JOIN role_modules rm ON rp.module_id = rm.ID;");
    }
    public function getOne($id)
    {
        $result = $this->execute("SELECT rp.role_id, rp.module_id, rp.ID as permission_id, r.name, r.description, rm.name as module, r.status,rp.can_view, rp.can_add, rp.can_edit, rp.can_delete, r.created_at, rp.modified_at FROM roles r JOIN role_permissions rp ON rp.role_id = r.ID JOIN role_modules rm ON rp.module_id = rm.ID WHERE r.ID = :id;", [":id" => $id]);
        return $result[0];
    }

    public function add($data)
    {

    }
}
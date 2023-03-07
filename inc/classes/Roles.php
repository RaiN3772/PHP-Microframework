<?php

class Roles extends Database {


    public function load_roles() {
        return $this->query("SELECT * FROM roles ORDER BY role_id ASC");
    }

    public function load_users() {
        return $this->query("SELECT user_id, user_name, user_email, user_avatar, user_last_online, user_created_date, user_last_ip FROM users");
    }

    public function users_role($role_id) {
        return $this->query("SELECT user_roles.assignment_date, users.user_name, users.user_id, users.user_avatar, users.user_email FROM `user_roles` INNER JOIN users ON user_roles.user_id = users.user_id WHERE role_id = :role_id", [':role_id' => $role_id]);
    }

    public function total_users($role_id) {
        $sql = $this->query("SELECT COUNT(*) as total FROM user_roles WHERE role_id = :role_id", [':role_id' => $role_id])->fetch();
        return $sql['total'];
    }

    public function permissions($role_id) {
        return $this->query("SELECT permissions.permission_name, permissions.permission_id, permissions.permission_title, permissions.permission_description FROM role_permissions INNER JOIN roles ON role_permissions.role_id = roles.role_id INNER JOIN permissions ON role_permissions.permission_id = permissions.permission_id WHERE roles.role_id = :role_id", [':role_id' => $role_id]);
    }

    public function load_permissions() {
        return $this->query("SELECT * FROM permissions");
    }
    public function permission_id($permission_name) {
        return $this->query("SELECT permission_id FROM permissions WHERE permission_name = :permission_name", [':permission_name' => $permission_name]);
    }

    public function add_role($role) {
        $sql = $this->insert('roles', ['role_title' => $role]);
        return $this->lastInsertId();
    }

    public function edit_role($role_id, $role_title) {
        return $this->update('roles', ['role_title' => $role_title], ['role_id' => $role_id]);
    }

    public function assign_permission($role_id, $permission_id) {
        return $this->insert('role_permissions', ['role_id' => $role_id, 'permission_id' => $permission_id]);
    }

    public function check_permission($role_id, $permission_id) {
        $sql = $this->query("SELECT COUNT(*) AS `check` FROM role_permissions WHERE role_id = :role_id AND permission_id = :permission_id", [':role_id' => $role_id, ':permission_id' => $permission_id])->fetch();
        if ($sql['check'] > 0)
            return true;
        else
            return false;
    }
    public function add_permission($permission_name, $permission_title, $permission_description = null) {
        return $this->insert('permissions', ['permission_name' => $permission_name, 'permission_title' => $permission_title, 'permission_description' => $permission_description]);
    }
    public function delete_permission($permission_id) {
        return $this->query("DELETE FROM permissions WHERE permission_id = :permission_id", [':permission_id' => $permission_id]);
    }
    public function edit_permission($permission_name, $permission_title, $permission_description = null, $permission_id) {
        return $this->update('permissions', ['permission_name' => $permission_name, 'permission_title' => $permission_title, 'permission_description' => $permission_description], ['permission_id' => $permission_id]);
    }

    public function assign_user_role($role_id, $user_id) {
        return $this->insert('user_roles', ['user_id' => $user_id, 'role_id' => $role_id]);
    }

    public function remove_user_role($role_id, $user_id) {
        return $this->query("DELETE FROM user_roles WHERE role_id = :role_id AND user_id = :user_id", [':role_id' => $role_id, ':user_id' => $user_id]);
    }

    public function user_roles($user_id) {
        return $this->query("SELECT role_title FROM user_roles INNER JOIN roles ON roles.role_id = user_roles.role_id WHERE user_id = :user_id", [':user_id' => $user_id]);
    }

    public function get_user($user_id) {
        return $this->query("SELECT user_id, user_name, user_avatar, user_email FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
    }
    
    public function get_role($permission_id) {
        return $this->query("SELECT roles.role_title FROM role_permissions JOIN roles ON role_permissions.role_id = roles.role_id WHERE role_permissions.permission_id = :permission_id", [':permission_id' => $permission_id]);
    }

}
<?php

class Logs extends User {
    public function log($info) {
        return $this->insert('logs', ['user_id' => $this->id(), 'ip' => get_ip(), 'info' => secure($info)]);
    }
    
    
    public function getAdmins() {
        return $this->query("SELECT DISTINCT users.name FROM users INNER JOIN user_roles ON users.id = user_roles.user_id INNER JOIN role_permissions ON user_roles.role_id = role_permissions.role_id WHERE role_permissions.permission_id IN (SELECT permission_id FROM role_permissions)")->fetchAll();
    }
    public function getLogs() {
        return $this->query("SELECT logs.*, users.id, users.name, users.avatar, roles.role_title FROM logs INNER JOIN users ON users.id = logs.user_id INNER JOIN user_roles ON user_roles.user_id = users.id INNER JOIN roles ON roles.role_id = user_roles.role_id ORDER BY logs.date DESC")->fetchAll();
    }
    public function getRoles() {
        return $this->query("SELECT DISTINCT roles.role_title FROM roles INNER JOIN role_permissions ON roles.role_id = role_permissions.role_id")->fetchAll();
    }
}

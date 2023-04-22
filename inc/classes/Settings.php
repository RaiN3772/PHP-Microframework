<?php

class Settings extends Database {
    private $error = false;
    public function get($setting) {
        $sql = $this->query("SELECT `key`, `value` FROM settings WHERE `key` = :setting", [':setting' => $setting])->fetch(PDO::FETCH_KEY_PAIR);
        return secure($sql[$setting]);
    }

    public function description($setting) { 
        $sql = $this->query("SELECT `key`, `description` FROM settings WHERE `key` = :setting", [':setting' => $setting])->fetch(PDO::FETCH_KEY_PAIR);
        return secure($sql[$setting]);
    }

    public function change($setting, $value) {
        if (empty($setting) || empty($value)) $this->error = "Name and value cannot be empty.";
        return $this->query("UPDATE settings SET `value` = :value WHERE `key` = :setting", [':value' => $value, ':setting' => $setting]);
    }

    public function stats() {
        $stats['users'] = $this->query("SELECT COUNT(*) AS total FROM users")->fetchColumn();
        $stats['online'] = $this->query("SELECT COUNT(*) AS total FROM users WHERE last_online >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)")->fetchColumn();
        return $stats;
    }
    public function total_database_size() {
        $size = 0;
        $sql = $this->query("SHOW TABLE STATUS")->fetchAll();
        foreach ($sql as $data) {
            $size += $data['Data_length'] + $data['Index_length'];
        }
        return $size;
    }

    public function isOnline($user_id) {
        $sql = $this->query("SELECT CASE WHEN last_online >= DATE_SUB(NOW(), INTERVAL 5 MINUTE) THEN 'online' ELSE 'offline' END AS status FROM users WHERE id = :user_id", [':user_id' => $user_id])->fetch();
        return $sql['status'];

    }
    public function rolePermission($role_id, $permission_id) {
        $sql = $this->query("SELECT COUNT(*) AS total FROM role_permissions WHERE role_id = :role_id AND permission_id = :permission_id", [':role_id' => $role_id, ':permission_id' => $permission_id])->fetchColumn();
        return $sql;
    }
    public function error() {
        return $this->error;
    }
}

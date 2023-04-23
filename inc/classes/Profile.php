<?php

class Profile extends Database {
    public $id;
    public $name;
    public $username;
    public $email;
    public $avatar;
    public $last_login;
    public $last_online;
    public $created_date;
    public $last_ip;
    public $register_ip;
    public $roles;
    private $isValid = false;
    private $settings;

    private $allow_name_change;
    private $allow_username_change;
    private $allow_email_change;

    public $errors = [];

    public function __construct($id) {
        parent::__construct();
        if (!is_numeric($id)) {
            $this->errors[] = 'Invalid Profile';
            return;
        }
        $this->id = $id;
        $this->getProfile();
        $this->getSettings();
        if ($this->id != $_SESSION['user_id'] && $this->settings['private'] == 'on' && !$this->hasPermission('manage_users')) {
            $this->errors[] = 'Private Profile';
            return;
        }
        $this->getRoles();
        $this->isValid = true;
        $this->allow_name_change = $this->query("SELECT `value` FROM settings WHERE `key` = 'allow_name_change'")->fetchColumn();
        $this->allow_username_change = $this->query("SELECT `value` FROM settings WHERE `key` = 'allow_username_change'")->fetchColumn();
        $this->allow_email_change = $this->query("SELECT `value` FROM settings WHERE `key` = 'allow_email_change'")->fetchColumn();
    }

    private function getProfile() {
        $profile = $this->query("SELECT id, `name` AS username, email, `password`, avatar, display_name AS `name`, last_login, last_online, created_date, last_ip, register_ip FROM users WHERE id = :id", [':id' => $this->id]);
        if ($profile->rowCount() == 0) {
            $this->errors[] = 'Invalid Profile';
            return;
        }
        $profile = $profile->fetchObject();
        $this->id = $profile->id;
        $this->name = $profile->name;
        $this->username = $profile->username;
        $this->email = $profile->email;
        $this->avatar = $profile->avatar;
        $this->last_login = $profile->last_login;
        $this->last_online = $profile->last_online;
        $this->created_date = $profile->created_date;
        $this->last_ip = $profile->last_ip;
        $this->register_ip = $profile->register_ip;
    }

    private function getRoles() {
        $sql = $this->query("SELECT roles.role_title FROM user_roles INNER JOIN roles ON roles.role_id = user_roles.role_id WHERE user_id = :id", [':id' => $this->id]);
        if ($sql->rowCount() == 0) {
            $this->errors[] = 'Invalid Profile';
            return;
        }
        $this->roles = $sql->fetchAll();
    }

    private function getSettings() {
        $settings = $this->query("SELECT * FROM user_settings WHERE user_id = :id", [':id' => $this->id]);
        if ($settings->rowCount() == 0) {
            $this->errors[] = 'Invalid Profile';
            return;
        }
        $this->settings = $settings->fetch();
    }

    public function hideOnline() {
        if ($this->settings['hide_online'] == 'on' && !$this->hasPermission('manage_users')) {
            return true;
        }
        return false;
    }

    public function hideEmail() {
        if ($this->settings['hide_email'] == 'on' && !$this->hasPermission('manage_users')) {
            return true;
        }
        return false;
    }

    public function hideLogin() {
        if ($this->settings['hide_login'] == 'on' && !$this->hasPermission('manage_users')) {
            return true;
        }
        return false;
    }

    public function allow_name_change() {
        if ($this->allow_name_change == 'on' || $this->hasPermission('manage_users')) {
            return true;
        }
        return false;
    }

    public function allow_username_change() {
        if ($this->allow_username_change == 'on' || $this->hasPermission('manage_users')) {
            return true;
        }
        return false;
    }

    public function allow_email_change() {
        if ($this->allow_email_change == 'on' || $this->hasPermission('manage_users')) {
            return true;
        }
        return false;
    }

    public function isValid() {
        return $this->isValid;
    }
    public function hashed() {
        return $this->query("SELECT `password` FROM users WHERE id = :id", [':id' => $this->id])->fetch();
    }
    public function getErrors() {
        return $this->errors[0];
    }

}

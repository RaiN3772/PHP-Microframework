<?php

class Registration extends Database {
    private $isDeactivated;
    private $minUsernameLength;
    private $maxUsernameLength;
    private $minPasswordLength;
    private $maxPasswordLength;
    private $isComplexPassword;
    private $errors = [];
    private $isRegistered = false;

    public function __construct($username, $email, $password, $confirmPassword) {
        parent::__construct();
        $this->isDeactivated = $this->query("SELECT `value` FROM settings WHERE `key` = 'deactivate_registration'")->fetchColumn();
        if ($this->isDeactivated == 'on') {
            $this->errors[] = 'Registration is currently disabled'; 
            return;
        }
        $this->minUsernameLength = $this->query("SELECT `value` FROM settings WHERE `key` = 'minimum_username_length'")->fetchColumn();
        $this->maxUsernameLength = $this->query("SELECT `value` FROM settings WHERE `key` = 'maximum_username_length'")->fetchColumn();
        $this->minPasswordLength = $this->query("SELECT `value` FROM settings WHERE `key` = 'minimum_password_length'")->fetchColumn();
        $this->maxPasswordLength = $this->query("SELECT `value` FROM settings WHERE `key` = 'maximum_password_length'")->fetchColumn();
        $this->isComplexPassword = $this->query("SELECT `value` FROM settings WHERE `key` = 'complex_password'")->fetchColumn();
        if (!$this->checkUsername($username)) return;
        if (!$this->checkEmail($email)) return;
        if (!$this->checkPassword($password, $confirmPassword)) return;
        if (empty($this->errors)) {
            $this->register($username, $email, $password);
        }
    }

    private function checkUsername($username) {
        if (empty(secure($username))) {
            $this->errors[] = 'Username cannot be empty';
            return;
        } elseif (strlen($username) < $this->minUsernameLength) {
            $this->errors[] = 'Username must be at least ' . $this->minUsernameLength . ' characters';
            return;
        } elseif (strlen($username) > $this->maxUsernameLength) {
            $this->errors[] = 'Username must be less than ' . $this->maxUsernameLength . ' characters';
            return;
        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            $this->errors[] = 'Username must be alphanumeric';
            return;
        } elseif ($this->query("SELECT `name` FROM users WHERE `name` = :username", ['username' => $username])->rowCount() > 0) {
            $this->errors[] = 'Username already taken';
            return;
        }
        return true;
    }

    private function checkEmail($email) {
        if (empty(secure($email))) {
            $this->errors[] = 'Email cannot be empty';
            return;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Email is not valid';
            return;
        } elseif ($this->query("SELECT `email` FROM users WHERE email = :email", ['email' => $email])->rowCount() > 0) {
            $this->errors[] = 'Email already taken';
            return;
        }
        return true;
    }

    private function checkPassword($password, $confirmPassword) {
        if (empty(secure($password))) {
            $this->errors[] = 'Password cannot be empty';
            return;
        } elseif (strlen($password) < $this->minPasswordLength) {
            $this->errors[] = 'Password must be at least ' . $this->minPasswordLength . ' characters';
            return;
        } elseif (strlen($password) > $this->maxPasswordLength) {
            $this->errors[] = 'Password must be less than ' . $this->maxPasswordLength . ' characters';
            return;
        } elseif ($this->isComplexPassword == 'on' && !$this->isPasswordComplex($password)) {
            $this->errors[] = 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character';
            return;
        } elseif ($password !== $confirmPassword) {
            $this->errors[] = 'Passwords do not match';
            return;
        }
        return true;
    }
    private function isPasswordComplex($password) {
        if (!preg_match('/[A-Z]/', $password)) return false;
        if (!preg_match('/[a-z]/', $password)) return false;
        if (!preg_match('/\d/', $password)) return false;
        if (!preg_match('/[!@#$%^&*()_+\-={[}\]|:;"\'<>,.?\/]/', $password)) return false;
        return true;
    }

    private function register($username, $email, $password) {
        $UserInfo = [
            'name' => strtolower($username),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'last_ip' => get_ip(),
            'register_ip' => get_ip(),
            'display_name' => $username,
        ];
        $this->insert('users', $UserInfo);
        $this->isRegistered = true;
        return true;
    }

    public function getErrors() {
        return $this->errors[0];
    }
    public function isRegistered() {
        return $this->isRegistered;
    }
}
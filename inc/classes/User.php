<?php
class User extends Database
{
    private $id;
    private $name;
    private $username;
    private $email;
    private $avatar;
    private $role;
    private $user_is_logged_in = false;
    private $errors = [];

    public function __construct() {

        if (!empty($_SESSION['user_id']) && isset($_SESSION['user_id'])) {
            $this->SessionLogin();
        }
        elseif (isset($_COOKIE['rememberme'])) {
            $this->CookieLogin();
        }
    }


    private function SessionLogin() {
        $sql = $this->query("SELECT id, `name` AS username, email, avatar, display_name AS `name` FROM users WHERE id = :id LIMIT 1", [':id' => $_SESSION['user_id']]);
        if ($sql->rowCount() == 0) return false;
        $user                = $sql->fetchObject();
        $_SESSION['user_id'] = $user->id;
        $this->id            = $user->id;
        $this->name          = $user->name;
        $this->username      = $user->username;
        $this->email         = $user->email;
        $this->avatar        = $user->avatar;
        $this->role          = $this->getUserRole();
        $this->updateOnlineTime();
        $this->updateIPAddress();
        $this->user_is_logged_in = true;
        return true;
    }
    private function CookieLogin() {
        if (!isset($_COOKIE['rememberme']) || empty($_COOKIE['rememberme'])) return false;
        [$user_id, $token, $hash] = explode(':', $_COOKIE['rememberme']);
        if ($hash !== hash('sha256', $user_id . ':' . $token . cookie_secret_key) || empty($token)) {
            $this->deleteRememberMeCookie();
            return false;
        }
        $sql = $this->query("SELECT id, `name` AS username, email, token, avatar, display_name AS `name` FROM users WHERE id = :id AND token = :token AND token IS NOT NULL LIMIT 1", [':id' => $user_id, ':token' => $token]);
        if ($sql->rowCount() === 0) {
            $this->deleteRememberMeCookie();
            return false;
        }
        $user = $sql->fetchObject();
        if (!isset($user->id)) {
            $this->deleteRememberMeCookie();
            return false;
        }

        $_SESSION['user_id'] = $user->id;

        $this->id                = $user->id;
        $this->name              = $user->name;
        $this->username          = $user->username;
        $this->email             = $user->email;
        $this->avatar            = $user->avatar;
        $this->role              = $this->getUserRole();
        $this->user_is_logged_in = true;
        $this->updateOnlineTime();
        $this->updateIPAddress();
        $this->newRememberMeCookie();
        return true;
    }

    public function loginWithPostData($username, $password, $rememberme) {
        if (empty($username) || empty($password)) {
            $this->errors[] = 'Oops! It looks like your username or password is empty';
            return false;
        }
        $sql = $this->query("SELECT * FROM users WHERE `name` = :username LIMIT 1", [':username' => strtolower($username)]);
        if ($sql->rowCount() == 0) {
            $this->errors[] = 'Oops! It looks like your username or password is incorrect';
            return false;
        }
        $user     = $sql->fetchObject();
        $cooldown = date("Y-m-d h:i:s", time() - locked_out_time);
        if ($user->failed_logins >= failed_logins && strtotime($user->last_failed_login) >= strtotime($cooldown)) {
            $this->errors[] = 'You have entered an incorrect password' . failed_logins . ' or more times already. Please wait ' . (locked_out_time / 60) . ' minutes to try again';
            return false;
        }
        if (!password_verify($password, $user->password)) {
            $this->query("UPDATE users SET failed_logins = failed_logins +1, last_failed_login = NOW() WHERE id = :id LIMIT 1", [':id' => $user->id]);
            $this->errors[] = 'Oops! It looks like your username or password is incorrect';
            return false;
        }
        $_SESSION['user_id']     = $user->id;
        $this->id                = $user->id;
        $this->name              = $user->display_name;
        $this->username          = $user->name;
        $this->email             = $user->email;
        $this->avatar            = $user->avatar;
        $this->role              = $this->getUserRole();
        $this->user_is_logged_in = true;

        $this->resetLoginCounter();
        $this->updateLoginTime();
        $this->updateIPAddress();

        if (!is_null($rememberme)) $this->newRememberMeCookie();
        else $this->deleteRememberMeCookie();
        return true;
    }

    private function getUserRole() {
        return $this->query("SELECT roles.role_title FROM roles INNER JOIN user_roles ON roles.role_id = user_roles.role_id WHERE user_roles.user_id = :user_id LIMIT 1", [':user_id' => $this->id])->fetchObject()->role_title;
    }

    private function newRememberMeCookie() {
        $token = bin2hex(random_bytes(32));
        $sql   = $this->query("UPDATE users SET token = :token WHERE id = :id", [':id' => $this->id, ':token' => $token]);
        if ($sql->rowCount() === 1) {
            $token_part = $this->id . ':' . $token;
            $token_hash = hash('sha256', $token_part . cookie_secret_key);
            $cookie     = $token_part . ':' . $token_hash;
            setcookie("rememberme", $cookie, [
                'expires'  => time() + cookie_runtime,
                'path'     => '/',
                'secure'   => true,
                'httponly' => true,
                'samesite' => 'Strict',
            ]);

            return true;
        }
    }
    public function deleteRememberMeCookie() {
        $this->query("UPDATE users SET token = NULL WHERE id = :id", [':id' => $this->id]);
        setcookie("rememberme", "", time() - 3600, "/");
        return true;
    }

    public function doLogout() {
        $this->deleteRememberMeCookie();
        $_SESSION = [];
        session_destroy();
        $this->id                = null;
        $this->name              = null;
        $this->username          = null;
        $this->email             = null;
        $this->avatar            = null;
        $this->role              = null;
        $this->user_is_logged_in = false;
        return true;
    }

    private function resetLoginCounter() {
        return $this->query("UPDATE users SET failed_logins = 0, last_failed_login = NULL WHERE id = :id AND failed_logins != 0", [':id' => $this->id]);
    }

    private function updateLoginTime() {
        return $this->query("UPDATE users SET last_login = now() WHERE id = :id", [':id' => $this->id]);
    }

    private function updateOnlineTime() {
        return $this->query("UPDATE users SET last_online = now() WHERE id = :id", [':id' => $this->id]);
    }

    private function updateIPAddress() {
        return $this->query("UPDATE users SET last_ip = :last_ip WHERE id = :id", [':id' => $this->id, ':last_ip' => get_ip()]);
    }

    public function updatePassword($password) {
        return $this->query("UPDATE users SET `password` = :password WHERE id = :id", [':id' => $this->id, ':password' => password_hash($password, PASSWORD_DEFAULT)]);
    }

    public function isLoggedIn() {
        return $this->user_is_logged_in;
    }
    public function name() {
        return secure($this->name);
    }
    public function username() {
        return secure($this->username);
    }
    public function id() {
        return $this->id;
    }
    public function email() {
        return $this->email;
    }

    public function avatar() {
        return $this->avatar;
    }

    public function role() {
        return secure($this->role);
    }

    public function hashed() {
        return $this->query("SELECT password FROM users WHERE id = :id", [':id' => $this->id])->fetchObject()->password;
    }

    public function error() {
        return $this->errors[0];
    }
}
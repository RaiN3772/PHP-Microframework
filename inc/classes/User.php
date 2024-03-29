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
        $startingTime = time();
        // check if the user has exceeded the maximum number of login attempts
        if ($this->isUserBlocked()) {
            $this->errors[] = 'You have entered an incorrect username or password too many times. Please try again later.';
            return false;
        }
        $sql = $this->query("SELECT * FROM users WHERE `name` = :username LIMIT 1", [':username' => strtolower($username)]);
        if ($sql->rowCount() == 0) {
            // increment the login attempts for the given username
            $this->incrementLoginAttempts($username);
            // Delay the execution time for the response
            sleep(rand(1, 3));
            usleep(rand(0, 1000000));
            $this->errors[] = 'Oops! It looks like your username or password is incorrect';
            return false;
        }
        $user     = $sql->fetchObject();
        if (!password_verify($password, $user->password)) {
            // increment the login attempts for the given username
            $this->incrementLoginAttempts($username);
            // Delay the execution time for the response
            sleep(max(1, rand(1,3) + $startingTime - time()));
            usleep(rand(0, 1000000));
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

        $this->resetLoginAttempts();
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
    
    private function isUserBlocked() {
        // Get the login attempts for the current ip address
        $sql = $this->query("SELECT * FROM auth_attempts WHERE `ip_address` = :ip", [':ip' => get_ip()]);
        // If no entry exists, return false
        if ($sql->rowCount() == 0) return false;
        $login_attempts = $sql->fetchObject();
        // Check if the user is blocked based on the number of attempts and the cooldown time
        $blocked_time = time() - locked_out_time;
        if ($login_attempts->attempts >= failed_logins && strtotime($login_attempts->last_attempt) > strtotime($blocked_time)) return true;
        return false;
    }

    private function incrementLoginAttempts($username) {
        // increment the number of login attempts for the given username
        return $this->query("INSERT INTO auth_attempts (`ip_address`, `attempts`, `last_attempt`) VALUES (:ip, 1, NOW()) ON DUPLICATE KEY UPDATE `attempts` = `attempts` + 1, `last_attempt` = NOW()", [':ip' => get_ip()]);
    }
    
    private function resetLoginAttempts() {
        // reset the number of login attempts for the given username
        $sql = $this->query("DELETE FROM auth_attempts WHERE `ip_address` = :ip", [':ip' => get_ip()]);
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

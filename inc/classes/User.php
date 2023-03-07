<?php
class User extends Database
{
    // @var int $user_id The user's id
    public $user_id;
    // @var string $user_name The user's name
    public $user_name = "";
    // @var string $user_email The user's email
    public $user_email = "";
    // @var string $user_avatar The user's avatar
    public $user_avatar = "";
    // @var string $role_title The user's title
    public $role_title = "";
    // @var boolean $user_is_logged_in The user's login status
    private $user_is_logged_in = false;


    // The function "__construct()" automatically starts whenever an object of this class is created
    public function __construct() {


        if ($_SERVER['REQUEST_URI'] == '/logout') {
            $this->doLogout();
        } else if (!empty($_SESSION['user_id']) && isset($_SESSION['user_id'])) {
            $this->loginWithSessionData();

        } elseif (isset($_COOKIE['rememberme'])) {
            $this->loginWithCookieData();
        }

        if ($this->isUserLoggedIn() && $_SERVER['REQUEST_URI'] == '/auth') {
            toastr('info', message('already_logged'), '/');
        }
        if (!$this->isUserLoggedIn() && $_SERVER['REQUEST_URI'] != '/auth') {
            redirect('/auth');
        }

    }


    /**
     * Logs in with S_SESSION data.
     * Technically we are already logged in at that point of time, as the $_SESSION values already exist.
     **/
    private function loginWithSessionData() {
        $user = $this->query("SELECT DISTINCT * FROM users INNER JOIN user_roles ON users.user_id = user_roles.user_id INNER JOIN roles ON user_roles.role_id = roles.role_id WHERE users.user_id = :user_id", [':user_id' => $_SESSION['user_id']])->fetch();
        // Update Session Data
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['user_avatar'] = $user['user_avatar'];
        $_SESSION['role_title'] = $user['role_title'];
        // Update Class Data
        $this->user_id = $user['user_id'];
        $this->user_name = $user['user_name'];
        $this->user_email = $user['user_email'];
        $this->user_avatar = $user['user_avatar'];
        $this->role_title = $user['role_title'];
        // Update Login Time
        $this->updateOnlineTime();
        // Update IP Address
        $this->updateIPAddress();
        $this->user_is_logged_in = true;
    }

    /**
     * Logs in via the Cookie
     * @return bool success state of cookie login
     */
    private function loginWithCookieData() {
        if (isset($_COOKIE['rememberme'])) {
            // Extract Data from the cookie
            [$user_id, $token, $hash] = explode(':', $_COOKIE['rememberme']);
            // check cookie hash validity
            if ($hash == hash('sha256', $user_id . ':' . $token . cookie_secret_key) && !empty($token)) {
                $sql = $this->query("SELECT DISTINCT users.user_id, users.user_name, users.user_email, users.user_rememberme_token, users.user_avatar, roles.role_title FROM users INNER JOIN  user_roles ON users.user_id = user_roles.user_id INNER JOIN roles ON user_roles.role_id = roles.role_id WHERE users.user_id = :user_id AND users.user_rememberme_token = :user_rememberme_token AND users.user_rememberme_token IS NOT NULL", [':user_id' => $user_id, ':user_rememberme_token' => $token]);
                if ($sql->rowCount() > 0) {
                    // cookie looks good, try to select corresponding user
                    $user = $sql->fetchObject();
                    if (isset($user->user_id)) {
                        // write user data into PHP Session
                        $_SESSION['user_id'] = $user->user_id;
                        $_SESSION['user_name'] = $user->user_name;
                        $_SESSION['user_email'] = $user->user_email;
                        $_SESSION['user_avatar'] = $user->user_avatar;
                        $_SESSION['role_title'] = $user->role_title;

                        // declare user variables
                        $this->user_id = $user->user_id;
                        $this->user_name = $user->user_name;
                        $this->user_email = $user->user_email;
                        $this->user_avatar = $user->user_avatar;
                        $this->role_title = $user->role_title;
                        $this->user_is_logged_in = true;
                        // Update Login Time
                        $this->updateOnlineTime();
                        // Update IP Address
                        $this->updateIPAddress();
                        // Cookie token usable only once
                        $this->newRememberMeCookie();
                        return true;
                    }

                }

            }
            // The cookie has been used but its not valid, lets delete it
            $this->deleteRememberMeCookie();
        }
        return false;
    }

    /**
     * Logs in with the data provided in $_POST, coming from the login form
     * @param $user_name
     * @param $user_password
     * @param $user_rememberme
     */
    public function loginWithPostData($username, $password, $rememberme) {
        if (empty($username) || empty($password)) {
            toastr('error', message('empty_username_or_password'), '/auth');
        } else {
            $sql = $this->query("SELECT * FROM users WHERE user_name = :username", [':username' => $username]);
            if ($sql->rowCount() > 0) {
                $user = $sql->fetchObject();
                $cooldown = date("Y-m-d h:i:s", time() - locked_out_time);

                if ($user->user_failed_logins >= 3 && strtotime($user->user_last_failed_login) >= strtotime($cooldown)) {
                    toastr('error', message('cooldown_login'), '/auth');
                } else if (!password_verify($password, $user->user_password_hash)) {
                    $sql = $this->query("UPDATE users SET user_failed_logins = user_failed_logins +1, user_last_failed_login = now() WHERE user_id = :user_id", [':user_id' => $user->user_id]);
                    if ($sql->rowCount() == 1) {
                        toastr('error', message('inccorect_username_or_password'), '/auth');
                    } else {
                        toastr('error', message("something_wrong"), '/auth');
                    }
                } else {
                    // Verification success, Congratz you made it
                    // Lets make sure the user has a logged in session
                    $_SESSION['user_id'] = $user->user_id;
                    $_SESSION['user_name'] = $user->user_name;
                    $_SESSION['user_email'] = $user->user_email;
                    $_SESSION['user_avatar'] = $user->user_avatar;

                    // declare user variables
                    $this->user_id = $user->user_id;
                    $this->user_name = $user->user_name;
                    $this->user_email = $user->user_email;
                    $this->user_avatar = $user->user_avatar;
                    $this->user_is_logged_in = true;
                    // Reset failed login counter
                    $this->resetLoginCounter();
                    // Update Login Time
                    $this->updateLoginTime();
                    // Update IP Address
                    $this->updateIPAddress();

                    if (!is_null($rememberme)) {
                        $this->newRememberMeCookie();
                    } else {
                        $this->deleteRememberMeCookie();
                    }
                    // Let's redirect the user to the home page
                    toastr('success', message("logged_in"), '/');

                }

            } else {
                toastr('error', message('inccorect_username_or_password'), '/auth');
            }
        }
    }

    // Create all data needed for remember me cookie connection on client and server side
    private function newRememberMeCookie() {
        // Generate 64 Char random string and store it
        $random_token_string = hash('sha256', mt_rand());
        $sql = $this->query("UPDATE users SET user_rememberme_token = :user_rememberme_token WHERE user_id = :user_id", [':user_id' => $_SESSION['user_id'], ':user_rememberme_token' => $random_token_string]);

        if ($sql->rowCount() > 0) {
            // generate cookie string that consists of userid, randomstring and combined hash of both
            $cookie_string_first_part = $_SESSION['user_id'] . ':' . $random_token_string;
            $cookie_string_hash = hash('sha256', $cookie_string_first_part . cookie_secret_key);
            $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;

            // Set Cookie
            setcookie("rememberme", $cookie_string, time() + cookie_runtime, "/");
        }
    }

    // Delete all data needed for remember me cookie connection on client and server side

    public function deleteRememberMeCookie() {

        if (isset($_SESSION['user_id'])) {
            $sql = $this->query("UPDATE users SET user_rememberme_token = NULL WHERE user_id = :user_id", [':user_id' => $_SESSION['user_id']]);
            if ($sql->rowCount() > 0) {
                // set the rememberme-cookie to ten years ago (3600sec * 365 days * 10).
                // that's obivously the best practice to kill a cookie via php
                // @see http://stackoverflow.com/a/686166/1114320
                setcookie('rememberme', false, time() - (3600 * 3650), '/');
            }
        }
    }

    // Perform the logout, resetting the session
    public function doLogout() {
        $this->deleteRememberMeCookie();
        $_SESSION = [];
        session_destroy();
        $this->user_is_logged_in = false;
        toastr('info', message('logged_out'), '/auth');
    }



    // Reset the user failed login counter
    private function resetLoginCounter() {
        return $this->query("UPDATE users SET user_failed_logins = 0, user_last_failed_login = NULL WHERE user_id = :user_id AND user_failed_logins != 0", [':user_id' => $this->user_id]);
    }

    private function updateLoginTime() {
        return $this->query("UPDATE users SET user_last_login = now() WHERE user_id = :user_id", [':user_id' => $this->user_id]);
    }

    private function updateOnlineTime() {
        return $this->query("UPDATE users SET user_last_online = now() WHERE user_id = :user_id", [':user_id' => $this->user_id]);
    }

    private function updateIPAddress() {
        return $this->query("UPDATE users SET user_last_ip = :last_ip WHERE user_id = :user_id", [':user_id' => $this->user_id, ':last_ip' => get_ip()]);
    }

    // Add User
    public function add_user($username, $email, $password, $avatar) {
        $this->insert('users', ['user_name' => $username, 'user_email' => $email, 'user_password_hash' => $password, 'user_avatar' => $avatar]);
        return $this->lastInsertId();
    }

    // Permissions
    public function load_permission() {
        return $this->query("SELECT DISTINCT permission_name FROM users INNER JOIN user_roles ON user_roles.user_id = users.user_id INNER JOIN role_permissions ON user_roles.role_id = role_permissions.role_id INNER JOIN permissions ON role_permissions.permission_id = permissions.permission_id WHERE users.user_id = :user_id", [':user_id' => $this->user_id])->fetchAll();
    }
    public function checkPermission($permission_name) {
        $permissions = $this->load_permission();
        $permissions = array_map(function ($permission) {
            return $permission['permission_name'];
        }, $permissions);
        if (in_array($permission_name, $permissions)) {
            return true;
        } else if (in_array('root', $permissions)) {
            return true;
        }
        return false;
    }

    public function hashed_password() {
        $password = $this->query("SELECT user_password_hash FROM users WHERE user_id = :user_id", [':user_id' => $this->user_id])->fetch();
        return $password['user_password_hash'];
    }
    public function update_user_details($avatar, $status, $user_id) {
        return $this->query("UPDATE users SET user_avatar = :avatar, user_private = :user_status WHERE user_id = :user_id", [':avatar' => $avatar, ':user_status' => $status, ':user_id' => $user_id]);
    }
    public function update_user_password($password, $user_id) {
        return $this->query("UPDATE users SET user_password_hash = :hash_password WHERE user_id = :user_id", [':hash_password' => $password, ':user_id' => $user_id]);
    }


    /**
     * Simply return the current state of the user
     * @return bool user's login status
     **/
    public function isUserLoggedIn() {
        return $this->user_is_logged_in;
    }
    public function user_name() {
        return $this->user_name;
    }

    public function user_id() {
        return $this->user_id;
    }
    public function user_email() {
        return $this->user_email;
    }

    public function user_avatar() {
        return $this->user_avatar;
    }

    public function role_title() {
        return $this->role_title;
    }

}
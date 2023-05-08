<?php

// General Routes
$route->get("/", function () {
    require_once('core.php');
    include 'views/page/home/index.php';
});

$route->get("/auth", function () {
    require_once('core.php');
    include 'views/page/authentication/login.php';
});

$route->post("/auth", function () {
    require_once('core.php');
    $form['username'] = secure($_POST['username']);
    $form['password'] = $_POST['password'];
    if (isset($_POST['rememberme']) && $_POST['rememberme'] == 1) {
        $form['rememberme'] = $_POST['rememberme'];
    }
    else {
        $form['rememberme'] = null;
    }
    $user->loginWithPostData($form['username'], $form['password'], $form['rememberme']);
    if ($user->isLoggedIn()) {
        toastr('success', 'You have successfully logged in', '/');
    }
    else {
        toastr('error', $user->error());
    }
});

$route->get("/logout", function () {
    require_once('core.php');
    $user->doLogout();
    toastr('info', 'You have successfully logged out');
});

$route->get("/register", function () {
    require_once('core.php');
    if ($setting->get('deactivate_registration') == 'on') toastr('error', 'Registration is currently disabled');
    include 'views/page/authentication/signup.php';
});

$route->post("/register", function () {
    require_once('core.php');
    $register = new Registration($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
    if (!$register->isRegistered()) toastr('error', $register->getErrors());
    toastr('success', 'You have successfully registered', '/auth');
});


// Profile Routes
// --------------------
$route->get("/profile/{id}", function ($id) {
    require_once('core.php');
    if ($setting->get('deactivate_profiles') == 'on' && !$user->hasPermission('manage_users')) toastr('error', 'Profiles are currently disabled');
    $profile = new Profile($id);
    if (!$profile->isValid()) toastr('error', $profile->getErrors());
    include 'inc/views/page/profile/index.php';
});
$route->get("/profile/{id}/settings", function ($id) {
    require_once('core.php');
    if ($setting->get('deactivate_profiles') == 'on' && !$user->hasPermission('manage_users')) toastr('error', 'Profiles are currently disabled');
    $profile = new Profile($id);
    if (!$profile->isValid()) toastr('error', $profile->getErrors());
    if ($profile->id != $user->id()) toastr('error', 'You do not have permission to view this page');
    include 'inc/views/page/profile/settings.php';
});
$route->post("/profile/{id}/settings", function ($id) {
    require_once('core.php');
    if ($setting->get('deactivate_profiles') == 'on' && !$user->hasPermission('manage_users')) toastr('error', 'Profiles are currently disabled');
    $profile = new Profile($id);
    if (!$profile->isValid()) toastr('error', $profile->getErrors());
    if ($profile->id != $user->id()) toastr('error', 'You do not have permission to view this page');
    require 'init/post/profileDetails.php';
});

$route->post("/profile/{id}/options", function ($id) {
    require_once('core.php');
    if ($setting->get('deactivate_profiles') == 'on' && !$user->hasPermission('manage_users')) toastr('error', 'Profiles are currently disabled');
    $profile = new Profile($id);
    if (!$profile->isValid()) toastr('error', $profile->getErrors());
    if ($profile->id != $user->id()) toastr('error', 'You do not have permission to view this page');
    if (!isset($_POST['private'])) $database->update('user_settings', ['private' => 'off'], ['user_id' => $profile->id]);
    else $database->update('user_settings', ['private' => 'on'], ['user_id' => $profile->id]);

    if (!isset($_POST['hide_email'])) $database->update('user_settings', ['hide_email' => 'off'], ['user_id' => $profile->id]);
    else $database->update('user_settings', ['hide_email' => 'on'], ['user_id' => $profile->id]);
    if (!isset($_POST['hide_online'])) $database->update('user_settings', ['hide_online' => 'off'], ['user_id' => $profile->id]);
    else $database->update('user_settings', ['hide_online' => 'on'], ['user_id' => $profile->id]);
    if (!isset($_POST['hide_login'])) $database->update('user_settings', ['hide_login' => 'off'], ['user_id' => $profile->id]);
    else $database->update('user_settings', ['hide_login' => 'on'], ['user_id' => $profile->id]);

    toastr('success', 'Your profile options have been updated');
});

$route->post("/profile/{id}/password", function ($id) {
    require_once('core.php');
    require 'init/post/password.php';
});


// Admin Routes
// --------------------
$route->get("/admin", function () {
    require_once('core.php');
    if (!$user->hasPermission('admin_panel')) {
        redirect('/');
    }
    $page['title'] = 'Administration Panel';
    $stats         = $setting->stats();
    include 'views/page/admin/index.php';
});

$route->get("/admin/settings", function () {
    require_once('core.php');
    if (!$user->hasPermission('manage_settings')) {
        redirect('/');
    }
    $page['title'] = 'Administration Panel » Settings';
    include 'views/page/admin/settings.php';
});

$route->post("/admin/settings", function () {
    require_once('core.php');
    require 'init/post/settings.php';
});

$route->get("/admin/roles", function () {
    require_once('core.php');
    if (!$user->hasPermission('manage_roles')) redirect('/');
    $page['title'] = 'Administration Panel » Roles';
    $roles         = $database->query("SELECT roles.*, COUNT(user_roles.user_id) AS total FROM roles LEFT JOIN user_roles ON roles.role_id = user_roles.role_id GROUP BY roles.role_id")->fetchAll();
    include 'views/page/admin/roles.php';
});

$route->post("/admin/role/add", function () {
    require_once('core.php');
    if (!$user->hasPermission('manage_roles')) redirect('/');
    if (!isset($_POST['role_title']) || empty(secure($_POST['role_title']))) toastr('error', 'Please enter a role title');
    if (!isset($_POST['role_description']) || empty(secure($_POST['role_description']))) toastr('error', 'Please enter a role title');
    $database->insert('roles', ['role_title' => secure($_POST['role_title']), 'role_description' => secure($_POST['role_description'])]);
    $role_id = $database->lastInsertId();
    foreach ($_POST['permissions'] as $permission_id) $database->insert('role_permissions', ['role_id' => $role_id, 'permission_id' => $permission_id]); 
    $logs->log('Added a new role: ' . $_POST['role_title']);
    toastr('success', 'You have successfully added a new role');
});


$route->get("/admin/role/{role_id}", function ($role_id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_roles')) redirect('/');
    $sql = $database->query("SELECT roles.*, COUNT(user_roles.user_id) AS total FROM roles LEFT JOIN user_roles ON roles.role_id = user_roles.role_id WHERE roles.role_id = :role_id GROUP BY roles.role_id", ['role_id' => secure($role_id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid Role ID');
    $role          = $sql->fetch();
    $page['title'] = 'Administration Panel - ' . $role['role_title'];
    include 'views/page/admin/role.php';
});

$route->post("/admin/role/{role_id}/update", function ($role_id) {
    require_once('core.php');
    require 'init/post/role.php';
});

$route->get("/admin/role/{role_id}/delete", function ($role_id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_roles')) redirect('/');
    $sql = $database->query("SELECT * FROM roles WHERE role_id = :role_id", ['role_id' => secure($role_id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid Role ID');
    $role = $sql->fetch();
    if ($role['role_id'] == 1) toastr('error', 'You cannot delete the Administrator role');
    if ($role['role_id'] == $setting->get('default_role')) toastr('error', 'You cannot delete the default role');
    $database->query("DELETE FROM roles WHERE role_id = :role_id", ['role_id' => secure($role_id)]);
    $logs->log('Deleted a role: ' . $role['role_title']);
    toastr('success', 'You have successfully deleted ' . $role['role_title'] . ' role', '/admin/roles');
});

$route->get("/admin/role/{role_id}/user/{user_id}/remove", function ($role_id, $user_id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_roles')) redirect('/');
    $sql = $database->query("SELECT * FROM roles WHERE role_id = :role_id", ['role_id' => secure($role_id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid Role ID');
    $role = $sql->fetch();
    $sql  = $database->query("SELECT * FROM user_roles WHERE role_id = :role_id AND user_id = :user_id", ['role_id' => secure($role_id), 'user_id' => secure($user_id)]);
    if ($sql->rowCount() == 0) toastr('error', 'User does not have this role');
    $user_role = $sql->fetch();
    $database->query("DELETE FROM user_roles WHERE role_id = :role_id AND user_id = :user_id", ['role_id' => secure($role_id), 'user_id' => secure($user_id)]);
    $logs->log('Removed user id ' . $user_id . ' from a role: ' . $role['role_title']);
    toastr('success', 'You have succesfully removed the user from this role');
});

$route->get("/admin/permissions", function () {
    require_once('core.php');
    if (!$user->hasPermission('manage_perimissions')) redirect('/');
    $page['title'] = 'Administration Panel » Permissions';
    $permissions   = $database->query("SELECT * FROM permissions")->fetchAll();
    include 'views/page/admin/permissions.php';
});

$route->post("/admin/permission/add", function () {
    require_once('core.php');
    if (!$user->hasPermission('manage_perimissions')) redirect('/');
    if (!isset($_POST['permission_title']) || empty(secure($_POST['permission_title']))) toastr('error', 'Permissions title cannot be empty');
    if (!isset($_POST['permission_variable']) || empty(secure($_POST['permission_variable']))) toastr('error', 'Permissions variable cannot be empty');
    if (isset($_POST['permission_description']) && !empty(secure($_POST['permission_description']))) $permission_description = secure($_POST['permission_description']);
    else $permission_description = null;
    $database->insert('permissions', ['permission_title' => secure($_POST['permission_title']), 'permission_name' => secure($_POST['permission_variable']), 'permission_description' => $permission_description]);
    $logs->log('Added a new permission: ' . $_POST['permission_title']);
    toastr('success', 'You have successfully added a new permission');
});

$route->get("/admin/permission/{id}/edit", function ($id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_perimissions')) redirect('/');
    $sql = $database->query("SELECT * FROM permissions WHERE permission_id = :permission_id", ['permission_id' => secure($id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid Permission ID');
    $permission    = $sql->fetch();
    $page['title'] = 'Administration Panel » Permissions » ' . $permission['permission_title'];
    include 'views/page/admin/permission.php';
});

$route->post("/admin/permission/{id}/edit", function ($id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_perimissions')) redirect('/');
    $sql = $database->query("SELECT * FROM permissions WHERE permission_id = :permission_id", ['permission_id' => secure($id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid Permission ID');
    $permission = $sql->fetch();
    if (!isset($_POST['permission_title']) || empty(secure($_POST['permission_title']))) toastr('error', 'Permissions title cannot be empty');
    if (!isset($_POST['permission_variable']) || empty(secure($_POST['permission_variable']))) toastr('error', 'Permissions variable cannot be empty');
    if (isset($_POST['permission_description']) && !empty(secure($_POST['permission_description']))) $permission_description = secure($_POST['permission_description']);
    else $permission_description = null;
    $database->update('permissions', ['permission_title' => secure($_POST['permission_title']), 'permission_name' => secure($_POST['permission_variable']), 'permission_description' => $permission_description], ['permission_id' => secure($id)]);
    $logs->log('Updated a permission: ' . $_POST['permission_title']);
    toastr('success', 'You have successfully updated the permission', '/admin/permissions');
});

$route->get("/admin/permission/{id}/delete", function ($id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_perimissions')) redirect('/');
    $sql = $database->query("SELECT * FROM permissions WHERE permission_id = :permission_id", ['permission_id' => secure($id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid Permission ID');
    $permission = $sql->fetch();
    $database->query("DELETE FROM permissions WHERE permission_id = :permission_id", ['permission_id' => secure($id)]);
    $logs->log('Deleted a permission: ' . $permission['permission_title']);
    toastr('success', 'You have successfully deleted the permission', '/admin/permissions');
});

$route->get('/admin/users', function () {
    require_once('core.php');
    if (!$user->hasPermission('manage_users')) redirect('/');
    $page['title'] = 'Administration Panel » Users';
    $users         = $database->query("SELECT id, `name`, email, avatar, display_name, last_online, created_date, last_ip FROM users")->fetchAll();
    include 'views/page/admin/users.php';
});

$route->post('/admin/users/add', function () {
    require_once('core.php');
    require 'init/post/user.php';
});

$route->get('/admin/user/{id}', function ($id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_users')) redirect('/');
    $sql = $database->query("SELECT * FROM users WHERE id = :id", ['id' => secure($id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid User ID');
    $userInfo = $sql->fetch();
    if (in_array($id, superadmin) && $user->id() != $userInfo['id']) toastr('error', 'You cannot edit a super administrator');
    $page['title'] = 'Administration Panel » Users » ' . $userInfo['name'];
    $roles['all'] = $database->query("SELECT * FROM `roles`")->fetchAll();
    $roles['user'] = $database->query("SELECT * FROM `user_roles` WHERE user_id = :id", ['id' => secure($id)])->fetchAll();
    include 'inc/views/page/admin/user.php';
});

$route->post('/admin/user/{id}', function ($id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_users')) redirect('/');
    $sql = $database->query("SELECT * FROM users WHERE id = :id", ['id' => secure($id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid User ID');
    $userInfo = $sql->fetch();
    if (in_array($id, superadmin) && $user->id() != $userInfo['id']) toastr('error', 'You cannot edit a super administrator');
    require 'init/post/adminUser.php';
});

$route->get('/admin/user/{id}/delete', function ($id) {
    require_once('core.php');
    if (!$user->hasPermission('manage_users')) redirect('/');
    $sql = $database->query("SELECT * FROM users WHERE id = :id", ['id' => secure($id)]);
    if ($sql->rowCount() == 0) toastr('error', 'Invalid User ID');
    if (in_array($id, superadmin)) toastr('error', 'You cannot delete a super administrator');
    if ($user->id() == $id) toastr('error', 'You cannot delete yourself');
    $userInfo = $sql->fetch();
    $database->query("DELETE FROM users WHERE id = :id", ['id' => secure($id)]);
    $logs->log('Deleted a user: ' . $userInfo['name'] . ' (' . $userInfo['id'] . ')');
    toastr('success', 'You have successfully deleted the user');
});

$route->get('/admin/logs', function () {
    require_once('core.php');
    if (!$user->hasPermission('manage_logs')) redirect('/');
    $page['title'] = 'Administration Panel » Audit Logs';
    $audits_logs         = $database->query("SELECT logs.*, users.name, users.avatar FROM `logs` LEFT JOIN users ON users.id = logs.user_id")->fetchAll();
    include 'views/page/admin/logs.php';
});

$route->get('/admin/logs/purge', function () {
    require_once('core.php');
    if (!$user->hasPermission('manage_logs')) redirect('/');
    $database->query("DELETE FROM logs");
    $logs->log('Purged the audit logs');
    toastr('success', 'You have successfully purged the audit logs');
});

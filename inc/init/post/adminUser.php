<?php

if (isset($_POST['remove_avatar']) && $_POST['remove_avatar'] == '1') {
    if ($userInfo['avatar'] != $setting->get('default_avatar')) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $userInfo['avatar'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $userInfo['avatar']);
        }
    }
    
    $database->update('users', ['avatar' => $setting->get('default_avatar')], ['id' => $userInfo['id']]);
}
if (isset($_POST['display_name']) && !empty(secure($_POST['display_name'])) && secure($_POST['display_name']) != $userInfo['display_name']) {
    if ($database->query("SELECT display_name FROM users WHERE display_name = :display_name", [':display_name' => secure($_POST['display_name'])])->rowCount() > 0) toastr('error', 'Display name already taken');
    $database->update('users', ['display_name' => secure($_POST['display_name'])], ['id' => $userInfo['id']]);
}

if (isset($_POST['username']) && !empty(secure($_POST['username'])) && secure(strtolower($_POST['username'])) != $userInfo['name']) {
    if ($database->query("SELECT `name` FROM users WHERE `name` = :name", [':name' => secure($_POST['username'])])->rowCount() > 0) toastr('error', 'Username already taken');
    $database->update('users', ['name' => secure(strtolower($_POST['username']))], ['id' => $userInfo['id']]);
}

if (isset($_POST['email']) && !empty(secure($_POST['email'])) && secure($_POST['email']) != $userInfo['email']) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) toastr('error', 'Invalid email address');
    if ($database->query("SELECT `email` FROM users WHERE `email` = :email", [':email' => secure($_POST['email'])])->rowCount() > 0) toastr('error', 'Email already taken');
    $database->update('users', ['email' => secure($_POST['email'])], ['id' => $userInfo['id']]);
}

if (isset($_POST['newpassword']) && !empty(secure($_POST['newpassword']))) {
    if (strlen($_POST['newpassword']) < $setting->get('minimum_password_length')) toastr('error', 'Password must be at least ' . $setting->get('minimum_password_length') . ' characters');
    if (strlen($_POST['newpassword']) > $setting->get('maximum_password_length')) toastr('error', 'Password must be less than ' . $setting->get('maximum_password_length') . ' characters');
    $database->update('users', ['password' => password_hash($_POST['newpassword'], PASSWORD_DEFAULT)], ['id' => $userInfo['id']]);
}


$roles['all'] = $database->query("SELECT role_id FROM `roles`")->fetchAll();
$roles['user'] = $database->query("SELECT * FROM `user_roles` WHERE user_id = :id", ['id' => secure($id)])->fetchAll();
$roles['selected'] = $_POST['roles'];

// Extract the role IDs from the user roles array
$current_roles = array_map(function($role) {
    return $role['role_id'];
}, $roles['user']);

// Loop through all roles
foreach ($roles['all'] as $role) {
    $role_id = $role['role_id'];

    if (isset($_POST['roles']) && in_array($role_id, $_POST['roles'])) {
        // Add the role if it doesn't already exist
        if (!in_array($role_id, $current_roles)) {
            $database->insert('user_roles', ['role_id' => $role_id, 'user_id' => $userInfo['id']]);
        }
    } else {
        // Remove the role if it exists
        if (in_array($role_id, $current_roles)) {
            $database->query("DELETE FROM user_roles WHERE role_id = :role_id AND user_id = :user_id", [':role_id' => $role_id, ':user_id' => $userInfo['id']]);
        }
    }
}

if (!isset($_POST['roles']) || empty($_POST['roles'])) {
    $database->insert('user_roles', ['role_id' => $setting->get('default_role'), 'user_id' => $userInfo['id']]);
}

$logs->log('Updated user ' . $userInfo['name'] . ' (' . $userInfo['id'] . ')');
toastr('success', 'User updated successfully');

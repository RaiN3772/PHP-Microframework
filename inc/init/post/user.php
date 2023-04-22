<?php
if (!$user->hasPermission('manage_users')) redirect('/');

if (!isset($_POST['user_name']) || empty(secure($_POST['user_name']))) toastr('error', 'Username is required');
if (!isset($_POST['user_email']) || empty(secure($_POST['user_email']))) toastr('error', 'Email is required');  
if (!isset($_POST['user_role']) || empty(secure($_POST['user_role']))) toastr('error', 'Role is required');
if (!isset($_POST['user_password']) || empty(secure($_POST['user_password']))) toastr('error', 'Password is required');
if (!is_numeric($_POST['user_role'])) toastr('error', 'Invalid role');


$sql = $database->query("SELECT `name` FROM users WHERE `name` = :user_name", [':user_name' => secure($_POST['user_name'])]);
if ($sql->rowCount() > 0) toastr('error', 'Username already exists');
$sql = $database->query("SELECT `email` FROM users WHERE `email` = :user_email", [':user_email' => secure($_POST['user_email'])]);
if ($sql->rowCount() > 0) toastr('error', 'Email already exists');
$sql = $database->query("SELECT `role_id` FROM roles WHERE `role_id` = :role_id", [':role_id' => secure($_POST['user_role'])]);
if ($sql->rowCount() == 0) toastr('error', 'Invalid role');

if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) toastr('error', 'Invalid email address');

$database->insert('users', [
  'name' => strtolower(secure($_POST['user_name'])),
  'email' => secure($_POST['user_email']),
  'password' => password_hash($_POST['user_password'], PASSWORD_DEFAULT),
  'display_name' => secure($_POST['user_name']),
]);

$user_id = $database->lastInsertId();

$default_role = $setting->get('default_role');

if ($_POST['user_role'] != $default_role) {
    $database->query("DELETE FROM user_roles WHERE user_id = :user_id", [':user_id' => $user_id]);
    $database->insert('user_roles', [
        'user_id' => $user_id,
        'role_id' => secure($_POST['user_role'])
    ]);
}
$logs->log('Created user: ' . secure($_POST['user_name']));
toastr('success', 'User created successfully');
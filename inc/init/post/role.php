<?php

if (!$user->hasPermission('manage_roles')) redirect('/');
$sql = $database->query("SELECT * FROM roles WHERE role_id = :role_id", ['role_id' => secure($role_id)]);
if ($sql->rowCount() == 0) toastr('error', 'Invalid Role ID');
$role = $sql->fetch();

if (!isset($_POST['role_title']) || empty(secure($_POST['role_title']))) toastr('error', 'Please enter a role title');
if (!isset($_POST['role_description']) || empty(secure($_POST['role_description']))) toastr('error', 'Please enter a role title');


$database->update('roles', ['role_title' => secure($_POST['role_title']), 'role_description' => secure($_POST['role_description'])], ['role_id' => $role['role_id']]);

// Get the current permissions for the role
$current_permissions = $database->query("SELECT permission_id FROM role_permissions WHERE role_id = :role_id", [':role_id' => $role['role_id']])->fetchAll(PDO::FETCH_COLUMN);

// Loop through all permissions
foreach ($database->select('permissions')->fetchAll() as $permission) {
    $permission_id = $permission['permission_id'];

    // Check if permission is selected
    if (isset($_POST['permissions']) && in_array($permission_id, $_POST['permissions'])) {
        // Insert permission if it doesn't already exist for the role
        if (!in_array($permission_id, $current_permissions)) $database->insert('role_permissions', ['role_id' => $role['role_id'], 'permission_id' => $permission_id]);
    }
    else {
        // Remove permission if it exists for the role
        if (in_array($permission_id, $current_permissions)) {
            $database->query("DELETE FROM role_permissions WHERE role_id = :role_id AND permission_id = :permission_id", [':role_id' => $role['role_id'], ':permission_id' => $permission_id]);
        }
    }
}
$logs->log('Updated role: ' . $role['role_title']);
toastr('success', 'You have successfully updated the role');
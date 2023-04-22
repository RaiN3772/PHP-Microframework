<?php

if ($profile->id != $user->id()) redirect($page['last_page']);
if (!isset($_POST['confirm_password']) || empty(secure($_POST['confirm_password']))) toastr('error', 'Please confirm your password');
if (!password_verify($_POST['confirm_password'], $user->hashed())) toastr('error', 'Incorrect password');

if (isset($_POST['display_name']) && !empty(secure($_POST['display_name'])) && $_POST['display_name'] != $user->name()) {
    if ($profile->allow_name_change()) toastr('error', 'Name change is not allowed');
    if (strlen($_POST['display_name']) < $setting->get('minimum_username_length')) toastr('error', 'Name must be at least ' . $setting->get('minimum_username_length') . ' characters');
    if (strlen($_POST['display_name']) > $setting->get('maximum_username_length')) toastr('error', 'Name must be less than ' . $setting->get('maximum_username_length') . ' characters');
    if ($database->query("SELECT `display_name` FROM users WHERE display_name = :display_name", [':display_name' => $_POST['display_name']])->rowCount() > 0) toastr('error', 'Name already taken');
    $info['display_name'] = $_POST['display_name'];
} else $info['display_name'] = $user->name();

if (isset($_POST['username']) && !empty(secure($_POST['username'])) && $_POST['username'] != $user->username()) {
    if ($profile->allow_username_change()) toastr('error', 'Username change is not allowed');
    if (strlen($_POST['username']) < $setting->get('minimum_username_length')) toastr('error', 'Username must be at least ' . $setting->get('minimum_username_length') . ' characters');
    if (strlen($_POST['username']) > $setting->get('maximum_username_length')) toastr('error', 'Username must be less than ' . $setting->get('maximum_username_length') . ' characters');
    if ($database->query("SELECT `name` FROM users WHERE `name` = :username", [':username' => strtolower(secure($_POST['username']))])->rowCount() > 0) toastr('error', 'Username already taken');
    $info['name'] = strtolower($_POST['username']);
} else $info['name'] = $user->username();

if (isset($_POST['email']) && !empty(secure($_POST['email'])) && $_POST['email'] != $user->email()) {
    if ($profile->allow_email_change()) toastr('error', 'Email change is not allowed');
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) toastr('error', 'Invalid email address');
    if ($database->query("SELECT `email` FROM users WHERE email = :email", [':email' => $_POST['email']])->rowCount() > 0) toastr('error', 'Email already taken');
    $info['email'] = $_POST['email'];
} else $info['email'] = $user->email();

if (isset($_FILES['avatar']) && $_FILES["avatar"]["error"] == UPLOAD_ERR_OK) {
    $image['extension'] = strtolower(pathinfo(basename($_FILES['avatar']['name']), PATHINFO_EXTENSION));
    $image['avatar'] = $setting->get('user_folder') . uniqid() . '-' . $user->id()  . '-' . generate_random_string(10) . '.' . $image['extension'];
    $image['allowed'] = array_map('trim', explode(',', $setting->get('allowed_images_type')));;
    if ($_FILES['avatar']['size'] < 10) toastr('error', 'This is not a real image');
    if ($_FILES['avatar']['size'] > $setting->get('allowed_image_size') * 1024 * 1024) toastr('error', 'Image size is too big');
    if (!in_array($image['extension'], $image['allowed'])) toastr('error', 'Image type is not allowed');
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $image['avatar']);
    $info['avatar'] = $image['avatar'];
} else $info['avatar'] = $profile->avatar;

if ($database->update('users', $info, ['id' => $user->id()])) toastr('success', 'Profile updated');
else toastr('error', 'Something went wrong');

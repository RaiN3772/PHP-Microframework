<?php
if ($setting->get('deactivate_profiles') == 'on' && !$user->hasPermission('manage_users')) toastr('error', 'Profiles are currently disabled');
$profile = new Profile($id);
if (!$profile->isValid()) toastr('error', $profile->getErrors());
if ($profile->id != $user->id()) toastr('error', 'You do not have permission to view this page');

if (!password_verify($_POST['currentpassword'], $user->hashed())) toastr('error', 'Incorrect password');
if (!isset($_POST['newpassword']) || empty(secure($_POST['newpassword']))) toastr('error', 'Please enter a new password');
if (!isset($_POST['confirmpassword']) || empty(secure($_POST['confirmpassword']))) toastr('error', 'Please confirm your new password');
if ($_POST['newpassword'] != $_POST['confirmpassword']) toastr('error', 'Passwords do not match');

$settings['minimum_password_length'] = $setting->get('minimum_password_length');
$settings['maximum_password_length'] = $setting->get('maximum_password_length');
$settings['isComplexPassword'] = $setting->get('complex_password');

if (strlen($_POST['newpassword']) < $settings['minimum_password_length']) toastr('error', 'Password must be at least ' . $settings['minimum_password_length'] . ' characters');
if (strlen($_POST['newpassword']) > $settings['maximum_password_length']) toastr('error', 'Password must be less than ' . $settings['maximum_password_length'] . ' characters');
if ($settings['isComplexPassword'] == 'on' && !isPasswordComplex($_POST['newpassword'])) toastr('error', 'Password must contain at least one uppercase letter, one lowercase letter, and one number');

$user->updatePassword($_POST['newpassword']);
toastr('success', 'Password updated successfully');
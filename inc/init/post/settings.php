<?php
if (!$user->hasPermission('manage_settings')) redirect('/');

if (!isset($_POST['deactivate_website'])) $setting->change('deactivate_website', 'off');
if (!isset($_POST['deactivate_registration'])) $setting->change('deactivate_registration', 'off');
if (!isset($_POST['complex_password'])) $setting->change('complex_password', 'off');
if (!isset($_POST['deactivate_profiles'])) $setting->change('deactivate_profiles', 'off');
if (!isset($_POST['allow_username_change'])) $setting->change('allow_username_change', 'off');
if (!isset($_POST['allow_name_change'])) $setting->change('allow_name_change', 'off');
if (!isset($_POST['allow_email_change'])) $setting->change('allow_email_change', 'off');


foreach ($_POST as $name => $value) {
    $setting->change($name, $value);
}

$logs->log('Updated settings');
toastr('success', 'Settings updated successfully');
<?php

// Set the current page
$page['current'] = secure(basename($_SERVER['REQUEST_URI']));

// Get the route of the current page
$page['route'] = $_SERVER['REQUEST_URI'];

// Get the previous page
$page['last'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

// Set the title of the page
$page['title'] = $page['title'] ?? secure($setting->get('website_name'));

// Get the hostname of the server
$page['host'] = $_SERVER['SERVER_NAME'];

// Set the URL, name, logo, favicon, and description of the platform
$page['platform']['url'] = secure($setting->get('website_url'));
$page['platform']['name'] = secure($setting->get('website_name'));
$page['platform']['logo'] = secure($setting->get('logo_url'));
$page['platform']['favicon'] = secure($setting->get('favicon_url'));
$page['platform']['description'] = secure($setting->get('website_description'));

// Set the debugging mode
$page['platform']['debugging'] = secure($setting->get('debugging'));

// Set the number of failed login attempts and the time to lock out
define("failed_logins", $setting->get('failed_logins'));
define("locked_out_time", $setting->get('failed_login_time'));

// Set the menu items
$MenuItems = [
    'Admin Panel' => [
        'icon'       => 'fa-solid fa-lock',
        'permission' => 'admin_panel',
        'route'      => '/admin/',
        'sub'        => [
            'Home'        => [
                'link' => '/admin',
                'icon' => 'fa-solid fa-unlock-keyhole',
            ],
            'Settings'    => [
                'link'       => '/admin/settings',
                'icon'       => 'fa-solid fa-cog',
                'permission' => 'manage_settings',
            ],
            'Roles'       => [
                'link'       => '/admin/roles',
                'icon'       => 'fa-solid fa-user-tag',
                'permission' => 'manage_roles',
            ],
            'Permissions' => [
                'link'       => '/admin/permissions',
                'icon'       => 'fa-solid fa-user-lock',
                'permission' => 'manage_permissions',
            ],
            'Users'       => [
                'link'       => '/admin/users',
                'icon'       => 'fa-solid fa-users',
                'permission' => 'manage_users',
            ],
            'Logs'        => [
                'link'       => '/admin/logs',
                'icon'       => 'fa-solid fa-clipboard-list',
                'permission' => 'manage_logs',
            ],
        ],
    ],
];

// Set the footer items
$FooterItems = [
    'Link #1' => 'https://example.com',
];

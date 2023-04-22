<?php
/**
 * Amir Alatrash
 * Copyright 2022 Amir Alatrash, All Rights Reserved
 *
 * Website: palnetwork.xyz
 *
 * Note: Do not change anything unless you know what are you doing :)
 *
 */

// Initialize System Session
session_start();

// Set Default Timezone
date_default_timezone_set('Israel');

// Check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<'))
	exit('Sorry, this script does not run on a PHP version smaller than 5.3.7!');

// Initialize System Functions
require 'functions.php';

// Include Configuration File
require 'config.php';

spl_autoload_register(function ($class) {
	$path = $_SERVER['DOCUMENT_ROOT'] . '/inc/classes/';
	require_once $path . $class . '.php';
});

// Generate Database Connection
$database = new Database();

// Initialize System Settings
$setting = new Settings();

// Initialize System Variables
require 'bootstrap.php';

// Initialize User Authentication
$user = new User();
require 'init/authentication.php';

// Minify HTML output
ob_start("minify_html");


/**
 * Configuration for: Development Environment
 * Logs all errors in development process
 **/

 ini_set('display_errors', $page['platform']['debugging'] ? 1 : 0);
 ini_set('display_startup_errors', $page['platform']['debugging'] ? 1 : 0);
 error_reporting($page['platform']['debugging'] ? E_ALL : 0);


if ($setting->get('deactivate_website') == 'on' && $user->isLoggedIn() && !$user->hasPermission('admin_panel')) {
	require  'inc/views/page/ungrouped/locked.php'; exit;
}

if (($setting->get('deactivate_website') == 'on') && ($page['current'] == 'register')) {
	require 'inc/views/page/ungrouped/locked.php'; exit;
}

// Initialize Audit Logs
$logs = new Logs();

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

// Multi Language Selection
require 'translations/messages.php';
require_once('translations/en.php');


// Check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<'))
	exit(message('compatible_php'));


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

// Initialize Template Engine
$template = new TemplateEngine('templates', 'cache', ['cache' => true]);

// Minify HTML output
ob_start("minify_html");


/**
 * Configuration for: Development Environment
 * Logs all errors in development process
 **/

if ($setting->get('debugging') == 1) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} else
	ini_set('display_errors', 0);

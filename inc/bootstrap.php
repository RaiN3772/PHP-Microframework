<?php

$error = null;
$counter = 0;

// Get the current page name
$currentPage = secure_input(basename($_SERVER['REQUEST_URI']));

// Get the URL of the last visited page
if (isset($_SERVER['HTTP_REFERER'])) {
    $last_page = $_SERVER['HTTP_REFERER'];
} else {
    $last_page = '/';
}
// Convert time() ti Time Stamp
$current_timestamp = date('Y-m-d H:i:s', time());

if (!isset($page_title)) {
    $page_title = $setting->get('website_name');
}

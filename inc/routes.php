<?php

// General Routes
$route->get("/", function () {
    require_once('core.php');
    $page_title = $language['home_page'];
    $page_description = "This is Page Description";
    $feeds = new SocialFeeds();
    $announcements = new Announcement();
    $events = new Event();
    include 'inc/views/page/index/index.php';
});

$route->get("/auth", function () {
    require_once('core.php');
    include 'inc/views/page/authentication/authentication.php';
});

$route->post("/auth", function () {
    require_once('core.php');
    $form['username'] = secure_input($_POST['username']);
    $form['password'] = secure_input($_POST['password']);
    if (isset($_POST['rememberme'])) {
        $form['rememberme'] = $_POST['rememberme'];
    } else {
        $form['rememberme'] = null;
    }
    $user->loginWithPostData($form['username'], $form['password'], $form['rememberme']);
});

$route->any("/logout", function () {
    require 'core.php';
});

// REST API
$route->any("/api/{key}/{endpoint}/{parameters}", function ($key, $endpoint, $parameters) {
    require_once('init/api.php');
});



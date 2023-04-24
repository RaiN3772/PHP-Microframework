<?php
// check if user is logged in and on the authentication or registration page
if ($user->isLoggedIn() && in_array($page['current'], ['auth', 'register'])) {
    // show info message that user is already logged in and redirect to home page
    toastr('info', 'You are already logged in', '/');
}

// check if user is not logged in and not on the authentication or registration page
if (!$user->isLoggedIn() && !in_array($page['current'], ['auth', 'register'])) {
    // redirect to the authentication page
    redirect('/auth');
}

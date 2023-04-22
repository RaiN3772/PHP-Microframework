<?php
if ($user->isLoggedIn() && in_array($page['current'], ['auth', 'register'])) {
    toastr('info', 'You are already logged in', '/');
}

if (!$user->isLoggedIn() && !in_array($page['current'], ['auth', 'register'])) {
    redirect('/auth');
}
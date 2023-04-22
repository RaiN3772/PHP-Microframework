<?php
// General Functions
// --------------------

function redirect($url) {
	ob_start();
	header('Location: ' . $url);
	ob_end_flush();
	exit();
}

function secure($data) {
	return trim(stripslashes(htmlspecialchars($data)));
}

function secure_output($data) {
	return nl2br(htmlentities($data));
}

function minify_html($input) {
	$search = ['/>\s+/s', '/\s+</s', '/(\s)+/s', '/<!--(.|\s)*?-->/'];
	$replace = ['>', '<', '\\1', ''];
	return preg_replace($search, $replace, $input);
}

function toastr($type, $msg, $redirect = null) {
	$_SESSION['toastr'] = compact('msg', 'type');
	redirect($redirect ?? $_SERVER['HTTP_REFERER'] ?? '/');
}

function format_date($date) {
    $diff = time() - strtotime($date);
    return ($diff < 60) ? 'Just now' :
           ($diff < 3600 ? floor($diff/60).' minute'.(floor($diff/60)>1 ? 's' : '').' ago' :
           ($diff < 86400 ? floor($diff/3600).' hour'.(floor($diff/3600)>1 ? 's' : '').' ago' :
           ($diff < 172800 ? 'Yesterday' : date('F j, Y', strtotime($date)))));
}

function format_size(int $size) {
	$units = ['', ' K', ' M', ' G', ' T', ' P'];
	$i = min(floor(log($size, 1024)), count($units) - 1);
	return round($size >> ($i * 10)) . $units[$i] . 'B';
}

function generate_random_string($length = 16) {
	return substr(str_shuffle(implode("", array_merge(range(0, 9), range('a', 'z'), range('A', 'Z')))), 0, $length);
}

function get_ip() {
    $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    return filter_var($ip, FILTER_VALIDATE_IP);
}

function isPasswordComplex($password) {
    return preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)
        && preg_match('/\d/', $password) && preg_match('/[!@#$%^&*()_+\-={[}\]|:;"\'<>,.?\/]/', $password);
}

<?php
// General Functions
// --------------------

function redirect($url) {
	ob_start();
	header('Location: ' . $url);
	ob_end_flush();
	exit();
}

function secure_input($data) {
	trim($data); // Lets remove whitespace and other predefined characters from both sides of a string
	stripslashes($data); // Lets remove backslashes
	htmlspecialchars($data); // Lets convert some predefined characters to HTML entities; No html tags or scripts and sql injection
	return $data;
}

function secure_output($data) {
	// convert all applicable characters
	// convert newline characters to html line breaks
	return nl2br(htmlentities($data));
}

function minify_html($buffer) {
    $search = [
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
	];
    $replace = [
        '>',
        '<',
        '\\1',
        ''
	];

    return preg_replace($search, $replace, $buffer);
}

function toastr($type, $msg, $redirect) {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	$_SESSION['toastr']['msg'] = $msg;
	$_SESSION['toastr']['type'] = $type;
	redirect($redirect);
}

function format_date($date) {
	$currentTime = time();
	$date = strtotime($date);
	// Calculate the difference between the two times in minutes
	$difference = round(($currentTime - $date) / 60);

	// Check if the difference is within 2 minutes
	if ($difference < 2) {
		return 'Just now';
	}
	// Check if the difference is greater than 2 minutes and less than 60 minutes
	else if ($difference >= 2 and $difference < 60) {
		return $difference . ' minutes ago';
	}
	// Check if the difference is greater than 1 hour and less than 24 hours
	else if ($difference >= 60 and $difference < 1440) {
		$hours = round($difference / 60);
		return $hours . ' hours ago';
	}
	// Check if the difference is greater than 24 hours and less than 48 hours
	else if ($difference >= 1440 and $difference < 2880) {
		return 'Yesterday';
	}
	// If none of the above conditions are met, display the date
	else {
		return date('F j, Y', $date);
	}

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
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

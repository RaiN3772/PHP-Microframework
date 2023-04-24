<?php
// General Functions
// --------------------

/**
 * Redirects the user to a new URL.
 *
 * @param string $url The URL to redirect to.
 * @return void
 */
function redirect($url) {
	// Start output buffering.
	ob_start();
	// Send a header to redirect the user to the new URL.
	header('Location: ' . $url);
	// End output buffering and send the output to the browser.
	ob_end_flush();
	// Terminate the current script execution.
	exit();
}

/**
 * Sanitizes and validates user input to prevent security vulnerabilities.
 *
 * @param string $data The data to be secured.
 * @return string The sanitized and validated data.
 */
function secure($data) {
	// Remove any leading or trailing whitespace from the input data.
	// Remove any backslashes that have been used to escape characters
	// in the input data. This can help prevent SQL injection attacks
	// and other security vulnerabilities.
	// Convert any special characters in the input data to HTML entities.
	// This can help prevent cross-site scripting (XSS) attacks by ensuring
	// that special characters like '<' and '>' are not interpreted as HTML
	// tags or JavaScript code by the browser.
	return trim(stripslashes(htmlspecialchars($data)));
}

function secure_output($data) {
	return nl2br(htmlentities($data));
}

/**
 * Minifies an HTML string by removing unnecessary whitespace and comments.
 *
 * @param string $input The HTML string to be minified.
 * @return string The minified HTML string.
 */

function minify_html($input) {
	// Define an array of regular expressions to search for and replace in the input string.
	$search  = ['/>\s+/s', '/\s+</s', '/(\s)+/s', '/<!--(.|\s)*?-->/'];
	$replace = ['>', '<', '\\1', ''];

	// Use the preg_replace() function to perform a global search and replace on the input string.
	// The regular expressions defined in the $search array are used to search for specific patterns
	// in the input string, and the corresponding replacement strings in the $replace array are used
	// to replace those patterns with a more compact representation.
	$output = preg_replace($search, $replace, $input);

	// Return the minified HTML string.
	return $output;
}

/**
 * Displays a non-blocking notification to the user using the Toastr JavaScript library.
 *
 * @param string $type The type of notification to display ('success', 'info', 'warning', or 'error').
 * @param string $msg The message to display in the notification.
 * @param string|null $redirect (optional) The URL to redirect the user to after displaying the notification.
 */
function toastr($type, $msg, $redirect = null) {
	// Store the notification message and type in the user's session so that it can be displayed
	// after the page has been refreshed or the user is redirected to another page.
	$_SESSION['toastr'] = compact('msg', 'type');
	// Redirect the user to the specified URL, or the referring page if no URL is provided.
	redirect($redirect ?? $_SERVER['HTTP_REFERER'] ?? '/');
}

/**
 * Formats a date/time string as a human-readable timestamp.
 *
 * @param string $date The date/time string to format.
 * @return string The formatted timestamp.
 */
function format_date($date) {
	// Calculate the time difference between the current time and the timestamp represented by the input date.
	$diff = time() - strtotime($date);
	// Determine the appropriate timestamp format based on the time difference.
	return ($diff < 60) ? 'Just now' : // If the time difference is less than 60 seconds, display 'Just now'.
		($diff < 3600 ? floor($diff / 60) . ' minute' . (floor($diff / 60) > 1 ? 's' : '') . ' ago' : // If the time difference is less than 1 hour, display the number of minutes ago.
			($diff < 86400 ? floor($diff / 3600) . ' hour' . (floor($diff / 3600) > 1 ? 's' : '') . ' ago' : // If the time difference is less than 1 day, display the number of hours ago.
				($diff < 172800 ? 'Yesterday' : date('F j, Y', strtotime($date))))); // If the time difference is more than 1 day, display 'Yesterday' if the timestamp is from yesterday, or the full formatted date otherwise.
}

/**
 * Formats a file size in bytes as a human-readable string with units (KB, MB, GB, etc.).
 *
 * @param int $size The file size in bytes.
 * @return string The formatted file size with units.
 */
function format_size(int $size) {
	// Define an array of unit suffixes for file sizes (starting with an empty string for bytes).
	$units = ['', ' K', ' M', ' G', ' T', ' P'];
	// Determine the appropriate unit suffix based on the logarithm (base 1024) of the file size, rounded down to the nearest integer.
	$i = min(floor(log($size, 1024)), count($units) - 1);
	// Format the file size by right-shifting the size value by a multiple of 10 (based on the selected unit suffix), rounding the result to the nearest integer, and concatenating the unit suffix.
	return round($size >> ($i * 10)) . $units[$i] . 'B';
}

/**
 * Generates a random string of alphanumeric characters.
 *
 * @param int $length The length of the string to generate (default 16).
 * @return string The randomly generated string.
 */
function generate_random_string($length = 16) {
	// Define an array of all possible alphanumeric characters.
	// Shuffle the array of characters and concatenate the first $length characters.
	return substr(str_shuffle(implode("", array_merge(range(0, 9), range('a', 'z'), range('A', 'Z')))), 0, $length);
}

/**
 * Attempts to retrieve the user's IP address.
 *
 * This function first checks for the IP address in the HTTP_CLIENT_IP header,
 * then checks for the IP address in the HTTP_X_FORWARDED_FOR header, and finally
 * falls back to using the REMOTE_ADDR header. The IP address is then filtered
 * using the FILTER_VALIDATE_IP filter.
 *
 * @return string|false The user's IP address, or false if the address cannot be determined or is invalid.
 */
function get_ip() {
	// Attempt to retrieve the user's IP address from the HTTP_CLIENT_IP header.
	// If it is not set, attempt to retrieve it from the HTTP_X_FORWARDED_FOR header.
	// If that is not set, fall back to the REMOTE_ADDR header.
	$ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
	// Filter the IP address using the FILTER_VALIDATE_IP filter.
	return filter_var($ip, FILTER_VALIDATE_IP);
}

/**
 * Determines whether a password meets complexity requirements.
 *
 * This function checks whether the given password contains at least one uppercase letter,
 * one lowercase letter, one digit, and one special character. It uses regular expressions
 * to perform the checks.
 *
 * @param string $password The password to check for complexity.
 *
 * @return bool Returns true if the password is complex enough, and false otherwise.
 */
function isPasswordComplex($password) {
	// Check whether the password contains at least one uppercase letter.
	// Check whether the password contains at least one lowercase letter.
	// Check whether the password contains at least one digit.
	// Check whether the password contains at least one special character.
	// Use regular expressions to perform the checks.
	return preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)
		&& preg_match('/\d/', $password) && preg_match('/[!@#$%^&*()_+\-={[}\]|:;"\'<>,.?\/]/', $password);
}

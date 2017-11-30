<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

$valid = true;
$error = '';

if (!version_compare(PHP_VERSION, '7.0.0', '>=')) {
	$error .= "<strong>ERROR:</strong> PHP 7.0.0 or higher is required.<br />";
	$valid = false;
}
if (!extension_loaded('mbstring')) {
	$error .= "<strong>ERROR:</strong> The requested PHP extension mbstring is missing from your system.<br />";
	$valid = false;
}

if (!empty(ini_get('open_basedir'))) {
	$error .= "<strong>ERROR:</strong> Please disable the <strong>open_basedir</strong> setting to continue.<br />";
	$valid = false;
}

if (!$valid) {
	echo '<pre>'; echo $error; echo '</pre>';
	exit();
}

require 'main.php';

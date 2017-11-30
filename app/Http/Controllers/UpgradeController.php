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

namespace App\Http\Controllers;

/*
 * Increase PHP page execution time for this controller.
 * NOTE: This function has no effect when PHP is running in safe mode (http://php.net/manual/en/ini.sect.safe-mode.php#ini.safe-mode).
 * There is no workaround other than turning off safe mode or changing the time limit (max_execution_time) in the php.ini.
 */
set_time_limit(0);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UpgradeController extends Controller
{
	/**
	 * URL: /upgrade
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function version()
	{
		// Lunch the installation if the /.env file doesn't exists
		if (!File::exists(base_path('.env'))) {
			return redirect('/install');
		}
		
		// Get eventual new version value & the current (installed) version value
		$scriptVersion = config('app.version');
		$scriptVersionInt = strToInt($scriptVersion);
		$installedVersionInt = strToInt(getInstalledVersion());
		
		// All is Up to Date
		if ($scriptVersionInt <= $installedVersionInt) {
			abort(401);
		}
		
		// Installed version number is NOT found
		if ($installedVersionInt < 10) {
			$message = "<strong style='color:red;'>ERROR:</strong> Cannot find your current version from the '/.env' file.<br><br>";
			$message .= "<br><strong style='color:green;'>SOLUTION:</strong>";
			$message .= "<br>1. You have to add in the '/.env' file a line like: <strong>APP_VERSION=X.X</strong> (Don't forget to replace <strong>X.X</strong> by your current version)";
			$message .= "<br>2. (Optional) If you are forgot your current version, you have to see it from your backup 'config/app.php' file (it's the last element of the array).";
			$message .= "<br>3. And <strong>refresh this page</strong> to finish upgrading";
			echo '<pre>' . $message . '</pre>';
			exit();
		}
		
		// Try to Upgrade
		try {
			// Upgrade the website database version by version
			for ($i = $installedVersionInt; $i <= $scriptVersionInt; $i++) {
				// Current Update versions values
				$from = $i;
				$to = $from + 1;
				
				$updateFile = storage_path('database/upgrade/from-' . $from . '-to-' . $to . '/update.php');
				if (File::exists($updateFile)) {
					require_once($updateFile);
				}
				
				$updateSqlFile = storage_path('database/upgrade/from-' . $from . '-to-' . $to . '/update.sql');
				if (File::exists($updateSqlFile)) {
					$this->importSql($updateSqlFile);
				}
			}
		} catch (\Exception $e) {
			// Error message
			$supportUrl = "<a href='http://support.bedigit.com/help-center/tickets/new' target='_blank'>http://support.bedigit.com/help-center/tickets/new</a>";
			$message = "Error occurred during the upgrade.";
			if ($e->getMessage() != '') {
				$message .= "<br><strong>ERROR:</strong> " . $e->getMessage();
				$message .= "<br>Please restore your website from your backup and create a ticket here " . $supportUrl . " by sending the error message above.";
			}
			echo '<pre>' . $message . '</pre>';
			exit();
		}
		
		// Save the latest version number
		$this->saveTheLatestVersionNumber($scriptVersion);
		
		// Check & Regenerate installation file
		$this->checkAndRegenerateInstalledFile();
		
		// Clear all Cache
		$exitCode = Artisan::call('cache:clear');
		sleep(2);
		$exitCode = Artisan::call('view:clear');
		sleep(1);
		File::delete(File::glob(storage_path('logs') . '/laravel*.log'));
		
		// Success message
		flash("Congratulations! Your website has been upgraded to v" . $scriptVersion)->success();
		
		// Redirection
		return redirect('/');
	}
	
	/**
	 * Save the latest version number
	 *
	 * @param $value
	 */
	private function saveTheLatestVersionNumber($value)
	{
		$envFilePath = base_path('.env');
		if (File::exists($envFilePath)) {
			$configString = File::get($envFilePath);
			$tmp = [];
			preg_match('/APP_VERSION=(.*)[^\n]*/', $configString, $tmp);
			if (isset($tmp[0]) && trim($tmp[0]) != '') {
				$configString = str_replace('APP_VERSION=' . $tmp[1], 'APP_VERSION=' . $value, $configString);
			} else {
				$tmp = [];
				preg_match('/FORCE_HTTPS=(.*)[^\n]*/', $configString, $tmp);
				if (isset($tmp[0]) && trim($tmp[0]) != '') {
					$line = 'FORCE_HTTPS=' . $tmp[1];
					$newLine = $line . "\n" . 'APP_VERSION=' . $value;
					$configString = str_replace($line, $newLine, $configString);
				} else {
					$configString = $configString . "\n\n" . 'APP_VERSION=' . $value;
				}
			}
			
			// Save the new .env file
			File::put($envFilePath, $configString);
		}
	}
	
	/**
	 * Import SQL files buffer
	 *
	 * @param $sqlFile
	 * @return bool
	 */
	function importSql($sqlFile)
	{
		try {
			// Temporary variable, used to store current query
			$tmpLine = '';
			
			// Read in entire file
			$lines = file($sqlFile);
			
			// Loop through each line
			foreach ($lines as $line) {
				// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || trim($line) == '') {
					continue;
				}
				if (substr($line, 0, 2) == '/*') {
					// continue;
				}
				
				// Read & replace prefix
				$line = str_replace('<<prefix>>', DB::getTablePrefix(), $line);
				
				// Add this line to the current segment
				$tmpLine .= $line;
				
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
					// Perform the query
					DB::unprepared($tmpLine);
					
					// Reset temp variable to empty
					$tmpLine = '';
				}
			}
		} catch (\Exception $e) {
			$msg = 'Error when importing required data : ' . $e->getMessage();
			echo '<pre>';
			print_r($msg);
			echo '</pre><hr>';
			//exit();
		}
		
		return true;
	}
	
	/**
	 * Check & Regenerate installation file
	 *
	 * @return bool
	 */
	private function checkAndRegenerateInstalledFile()
	{
		// Make sure that the website is properly installed
		if (!File::exists(base_path('.env'))) {
			return false;
		}
		
		// Make the purchase code verification only if 'installed' file exists
		if (!File::exists(storage_path('installed'))) {
			// Get purchase code from DB
			$purchaseCode = config('settings.purchase_code');
			
			// Write 'installed' file
			File::put(storage_path('installed'), '');
			
			// Send the purchase code checking
			$apiUrl = config('larapen.core.purchaseCodeCheckerUrl') . $purchaseCode . '&item_id=' . config('larapen.core.itemId');
			$data = \App\Helpers\Curl::fetch($apiUrl);
			
			// Check & Get cURL error by checking if 'data' is a valid json
			if (!isValidJson($data)) {
				$data = json_encode(['valid' => false, 'message' => 'Invalid purchase code. ' . strip_tags($data)]);
			}
			
			// Format object data
			$data = json_decode($data);
			
			// Check if 'data' has the valid json attributes
			if (!isset($data->valid) || !isset($data->message)) {
				$data = json_encode(['valid' => false, 'message' => 'Invalid purchase code. Incorrect data format.']);
				$data = json_decode($data);
			}
			
			// Update 'installed' file
			if ($data->valid == true) {
				File::put(storage_path('installed'), $data->license_code);
			}
		}
		
		return true;
	}
}

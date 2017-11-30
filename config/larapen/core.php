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

return [

    /*
     |-----------------------------------------------------------------------------------------------
     | The item's ID on CodeCanyon
     |-----------------------------------------------------------------------------------------------
     |
     */

    'itemId' => '18776089',

	/*
	 |-----------------------------------------------------------------------------------------------
	 | Purchase code checker URL
	 |-----------------------------------------------------------------------------------------------
	 |
	 */

    'purchaseCodeCheckerUrl' => 'http://api.bedigit.com/envato.php?purchase_code=',
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Purchase Code
     |-----------------------------------------------------------------------------------------------
     |
     */

	'purchaseCode' => env('PURCHASE_CODE', ''),

    /*
     |-----------------------------------------------------------------------------------------------
     | Demo domain
     |-----------------------------------------------------------------------------------------------
     |
     */

    'demoDomain' => 'bedigit.com',

    /*
     |-----------------------------------------------------------------------------------------------
     | Default Logo
     |-----------------------------------------------------------------------------------------------
     |
     */

    'logo' => 'app/default/logo.png',

    /*
     |-----------------------------------------------------------------------------------------------
     | Default Favicon
     |-----------------------------------------------------------------------------------------------
     |
     */

    'favicon' => 'app/default/ico/favicon.png',

    /*
     |-----------------------------------------------------------------------------------------------
     | Default ads picture & Default ads pictures sizes
     |-----------------------------------------------------------------------------------------------
     |
     */

    'picture' => [
        'default' => 'app/default/picture.jpg',
        'size' => [
            'width'  => 1000,
            'height' => 1000,
        ],
		'quality' => env('PICTURE_QUALITY', 100),
        'resize' => [
            'logo'   => '500x100',
            'square' => '400x400', // ex: Categories
            'small'  => '120x90',
            'medium' => '320x240',
            'big'    => '816x460',
            'large'  => '1000x1000'
        ],
        'versioned' => env('PICTURE_VERSIONED', false),
        'version'   => env('PICTURE_VERSION', 1),
    ],
    
    /*
     |-----------------------------------------------------------------------------------------------
     | Default user profile picture
     |-----------------------------------------------------------------------------------------------
     |
     */
    
    'photo' => '',
    
    /*
     |-----------------------------------------------------------------------------------------------
     | Countries SVG maps folder & URL base
     |-----------------------------------------------------------------------------------------------
     |
     */

    'maps' => [
        'path'    => public_path('images/maps') . '/',
        'urlBase' => 'images/maps/',
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Set as default language the browser language
     |-----------------------------------------------------------------------------------------------
     |
     */

    'detectBrowserLanguage' => false,

    /*
     |-----------------------------------------------------------------------------------------------
     | Optimize your links for SEO (for International website)
     |-----------------------------------------------------------------------------------------------
     |
     */

    'multiCountriesWebsite' => env('MULTI_COUNTRIES_SEO_LINKS', false),

	/*
     |--------------------------------------------------------------------------
     | Force links to use the HTTPS protocol
     |--------------------------------------------------------------------------
     |
     */

	'forceHttps' => env('FORCE_HTTPS', false),

    /*
     |-----------------------------------------------------------------------------------------------
     | Plugins Path & Namespace
     |-----------------------------------------------------------------------------------------------
     |
     */

    'plugin' => [
        'path'      => app_path('Plugins') . '/',
        'namespace' => '\\App\Plugins\\',
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Managing User's Fields (Phone, Email & Username)
     |-----------------------------------------------------------------------------------------------
     |
     | When 'disable.phone' and 'disable.email' are TRUE,
     | the script use the email field by default.
     |
     */

    'disable' => [
        'phone'    => env('DISABLE_PHONE', true),
        'email'    => env('DISABLE_EMAIL', false),
        'username' => env('DISABLE_USERNAME', true),
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Disallowing usernames that match reserved names
     |-----------------------------------------------------------------------------------------------
     |
     */

    'reservedUsernames' => [
        'admin',
        'api',
        'profile',
        //...
    ],
    
    /*
     |-----------------------------------------------------------------------------------------------
     | Custom Prefix for the new locations (Administratives Divisions) Codes
     |-----------------------------------------------------------------------------------------------
     |
     */

    'locationCodePrefix' => 'Z',
    
    /*
     |-----------------------------------------------------------------------------------------------
     | Mile use countries (By default, the script use Kilometer)
     |-----------------------------------------------------------------------------------------------
     |
     */

    'mileUseCountries' => ['US','UK'],
	
	/*
     |-----------------------------------------------------------------------------------------------
     | During employer contacting, candidates can select a resume from their last 5 resumes.
	 | You can change this number to display more or less resumes during the selection
     |-----------------------------------------------------------------------------------------------
     |
     */

	'selectResumeInto' => 5,
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Login process settings
     |-----------------------------------------------------------------------------------------------
     |
     */

	'login' => [
		'openInModal'  => env('LOGIN_OPEN_IN_MODAL', true), // Open the top login link into Modal
		'maxAttempts'  => env('LOGIN_MAX_ATTEMPTS', 5), // The maximum number of attempts to allow
		'decayMinutes' => env('LOGIN_DECAY_MINUTE', 15), // The number of minutes to throttle for
	],
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Register process settings
     |-----------------------------------------------------------------------------------------------
     |
     */

	'register' => [
		'showCompanyFields' => env('REGISTER_SHOW_COMPANY_FIELDS', false), // Show/Hide Company fields from Registration Form depending of the User Type
		'showResumeFields'  => env('REGISTER_SHOW_RESUME_FIELDS', false), // Show/Hide Resume fields from Registration Form depending of the User Type
	],
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Posts Tags Limit (INFO: The 'tags' field in the 'posts' table is a varchar 255)
     |-----------------------------------------------------------------------------------------------
     |
     */

	'tagsLimit' => env('TAGS_LIMIT', 15),
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Block search engines on 'categories', 'tags', 'cities',
	 | 'users' or 'companies' pages or on the all site
     |-----------------------------------------------------------------------------------------------
     |
     */

	'noIndex' => [
		'categories' => env('NO_INDEX_CATEGORIES', false),
		'tags'       => env('NO_INDEX_TAGS', true),
		'cities'     => env('NO_INDEX_CITIES', false),
		'users'      => env('NO_INDEX_USERS', false),
		'companies'  => env('NO_INDEX_COMPANIES', false),
		'allSite'    => env('NO_INDEX_ALL_SITE', false), // Block search engine on all site
	],
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Search radius distance
     |-----------------------------------------------------------------------------------------------
     |
     */

	'search' => [
		'distance' => [
			'max'     => env('SEARCH_DISTANCE_MAX', 500),
			'default' => env('SEARCH_DISTANCE_DEFAULT', 100),
		],
	],
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Show tips notification messages
     |-----------------------------------------------------------------------------------------------
     | eg: LaraClassified is also available in your country: USA. Starting good deals here now!
	 |     Login for faster access to the best deals. Click here if you don't have an account.
     */

	'showTipsMessages' => env('SHOW_TIPS_MESSAGES', true),

];

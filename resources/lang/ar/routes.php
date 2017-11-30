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

$lcRoutes = [
    /*
    |--------------------------------------------------------------------------
    | Routes Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the global website.
    |
    */

    'countries' => 'countries',

    'login'    => 'login',
    'logout'   => 'logout',
    'register' => 'register',

    'page'   => 'page/{slug}.html',
    't-page' => 'page',
    'v-page' => 'page/:slug.html',

    'contact' => 'contact.html',

];

if (config('larapen.core.multiCountriesWebsite')) {
    // Sitemap
    $lcRoutes['sitemap'] = '{countryCode}/sitemap.html';
    $lcRoutes['v-sitemap'] = ':countryCode/sitemap.html';

    // Latest Ads
    $lcRoutes['search'] = '{countryCode}/latest-jobs';
    $lcRoutes['t-search'] = 'latest-jobs';
    $lcRoutes['v-search'] = ':countryCode/latest-jobs';

    // Search by Sub-Category
    $lcRoutes['search-subCat'] = '{countryCode}/job-category/{catSlug}/{subCatSlug}';
    $lcRoutes['t-search-subCat'] = 'job-category';
    $lcRoutes['v-search-subCat'] = ':countryCode/job-category/:catSlug/:subCatSlug';

    // Search by Category
    $lcRoutes['search-cat'] = '{countryCode}/job-category/{catSlug}';
    $lcRoutes['t-search-cat'] = 'job-category';
    $lcRoutes['v-search-cat'] = ':countryCode/job-category/:catSlug';

    // Search by Location
    $lcRoutes['search-city'] = '{countryCode}/jobs/{city}/{id}';
    $lcRoutes['t-search-city'] = 'jobs';
    $lcRoutes['v-search-city'] = ':countryCode/jobs/:city/:id';

    // Search by User
    $lcRoutes['search-user'] = '{countryCode}/users/{id}/jobs';
    $lcRoutes['t-search-user'] = 'users';
    $lcRoutes['v-search-user'] = ':countryCode/users/:id/jobs';
	
	// Search by Username
	$lcRoutes['search-username'] = '{countryCode}/profile/{username}';
	$lcRoutes['v-search-username'] = ':countryCode/profile/:username';

    // Search by Company name
    $lcRoutes['search-company'] = '{countryCode}/companies/{id}/jobs';
    $lcRoutes['t-search-company'] = 'companies-jobs';
    $lcRoutes['v-search-company'] = ':countryCode/companies/:id/jobs';
	$lcRoutes['companies-list'] = '{countryCode}/companies';
	
	// Search by Tag
	$lcRoutes['search-tag'] = '{countryCode}/tag/{tag}';
	$lcRoutes['t-search-tag'] = 'tag';
	$lcRoutes['v-search-tag'] = ':countryCode/tag/:tag';
} else {
    // Sitemap
    $lcRoutes['sitemap'] = 'sitemap.html';
    $lcRoutes['v-sitemap'] = 'sitemap.html';

    // Latest Ads
    $lcRoutes['search'] = 'latest-jobs';
    $lcRoutes['t-search'] = 'latest-jobs';
    $lcRoutes['v-search'] = 'latest-jobs';

    // Search by Sub-Category
    $lcRoutes['search-subCat'] = 'job-category/{catSlug}/{subCatSlug}';
    $lcRoutes['t-search-subCat'] = 'job-category';
    $lcRoutes['v-search-subCat'] = 'job-category/:catSlug/:subCatSlug';

    // Search by Category
    $lcRoutes['search-cat'] = 'job-category/{catSlug}';
    $lcRoutes['t-search-cat'] = 'job-category';
    $lcRoutes['v-search-cat'] = 'job-category/:catSlug';

    // Search by Location
    $lcRoutes['search-city'] = 'jobs/{city}/{id}';
    $lcRoutes['t-search-city'] = 'jobs';
    $lcRoutes['v-search-city'] = 'jobs/:city/:id';

    // Search by User
    $lcRoutes['search-user'] = 'users/{id}/jobs';
    $lcRoutes['t-search-user'] = 'users';
    $lcRoutes['v-search-user'] = 'users/:id/jobs';
	
	// Search by Username
	$lcRoutes['search-username'] = 'profile/{username}';
	$lcRoutes['v-search-username'] = 'profile/:username';

    // Search by Company name
    $lcRoutes['search-company'] = 'companies/{id}/jobs';
    $lcRoutes['t-search-company'] = 'companies-jobs';
    $lcRoutes['v-search-company'] = 'companies/:id/jobs';
	$lcRoutes['companies-list'] = 'companies';
	
	// Search by Tag
	$lcRoutes['search-tag'] = 'tag/{tag}';
	$lcRoutes['t-search-tag'] = 'tag';
	$lcRoutes['v-search-tag'] = 'tag/:tag';
}

return $lcRoutes;
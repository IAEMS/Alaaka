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

    'countries' => 'pays',

    'login'    => 'connexion',
    'logout'   => 'deconnexion',
    'register' => 'inscription',

    'page'   => 'page/{slug}.html',
    't-page' => 'page',
    'v-page' => 'page/:slug.html',

    'contact' => 'contact.html',

];

if (config('larapen.core.multiCountriesWebsite')) {
    // Sitemap
    $lcRoutes['sitemap'] = '{countryCode}/plan-du-site.html';
    $lcRoutes['v-sitemap'] = ':countryCode/plan-du-site.html';

    // Latest Ads
    $lcRoutes['search'] = '{countryCode}/dernieres-offres';
    $lcRoutes['t-search'] = 'dernieres-offres';
    $lcRoutes['v-search'] = ':countryCode/dernieres-offres';

    // Search by Sub-Category
    $lcRoutes['search-subCat'] = '{countryCode}/categorie-emploi/{catSlug}/{subCatSlug}';
    $lcRoutes['t-search-subCat'] = 'categorie-emploi';
    $lcRoutes['v-search-subCat'] = ':countryCode/categorie-emploi/:catSlug/:subCatSlug';

    // Search by Category
    $lcRoutes['search-cat'] = '{countryCode}/categorie-emploi/{catSlug}';
    $lcRoutes['t-search-cat'] = 'categorie-emploi';
    $lcRoutes['v-search-cat'] = ':countryCode/categorie-emploi/:catSlug';

    // Search by Location
    $lcRoutes['search-city'] = '{countryCode}/offres-emploi/{city}/{id}';
    $lcRoutes['t-search-city'] = 'offres-emploi';
    $lcRoutes['v-search-city'] = ':countryCode/offres-emploi/:city/:id';

    // Search by User
    $lcRoutes['search-user'] = '{countryCode}/users/{id}/offres-emploi';
    $lcRoutes['t-search-user'] = 'users';
    $lcRoutes['v-search-user'] = ':countryCode/users/:id/offres-emploi';
	
	// Search by Username
	$lcRoutes['search-username'] = '{countryCode}/profile/{username}';
	$lcRoutes['v-search-username'] = ':countryCode/profile/:username';

    // Search by Company name
    $lcRoutes['search-company'] = '{countryCode}/entreprises/{id}/offres-emploi';
    $lcRoutes['t-search-company'] = 'entreprises-offres-emploi';
    $lcRoutes['v-search-company'] = ':countryCode/entreprises/:id/offres-emploi';
	$lcRoutes['companies-list'] = '{countryCode}/entreprises';
	
	// Search by Tag
	$lcRoutes['search-tag'] = '{countryCode}/mot-cle/{tag}';
	$lcRoutes['t-search-tag'] = 'mot-cle';
	$lcRoutes['v-search-tag'] = ':countryCode/mot-cle/:tag';
} else {
    // Sitemap
    $lcRoutes['sitemap'] = 'plan-du-site.html';
    $lcRoutes['v-sitemap'] = 'plan-du-site.html';

    // Latest Ads
    $lcRoutes['search'] = 'dernieres-offres';
    $lcRoutes['t-search'] = 'dernieres-offres';
    $lcRoutes['v-search'] = 'dernieres-offres';

    // Search by Sub-Category
    $lcRoutes['search-subCat'] = 'categorie-emploi/{catSlug}/{subCatSlug}';
    $lcRoutes['t-search-subCat'] = 'categorie-emploi';
    $lcRoutes['v-search-subCat'] = 'categorie-emploi/:catSlug/:subCatSlug';

    // Search by Category
    $lcRoutes['search-cat'] = 'categorie-emploi/{catSlug}';
    $lcRoutes['t-search-cat'] = 'categorie-emploi';
    $lcRoutes['v-search-cat'] = 'categorie-emploi/:catSlug';

    // Search by Location
    $lcRoutes['search-city'] = 'offres-emploi/{city}/{id}';
    $lcRoutes['t-search-city'] = 'offres-emploi';
    $lcRoutes['v-search-city'] = 'offres-emploi/:city/:id';

    // Search by User
    $lcRoutes['search-user'] = 'users/{id}/offres-emploi';
    $lcRoutes['t-search-user'] = 'users';
    $lcRoutes['v-search-user'] = 'users/:id/offres-emploi';
	
	// Search by Username
	$lcRoutes['search-username'] = 'profile/{username}';
	$lcRoutes['v-search-username'] = 'profile/:username';

    // Search by Company name
    $lcRoutes['search-company'] = 'entreprises/{id}/offres-emploi';
    $lcRoutes['t-search-company'] = 'entreprises-offres-emploi';
    $lcRoutes['v-search-company'] = 'entreprises/:id/offres-emploi';
	$lcRoutes['companies-list'] = 'entreprises';
	
	// Search by Tag
	$lcRoutes['search-tag'] = 'mot-cle/{tag}';
	$lcRoutes['t-search-tag'] = 'mot-cle';
	$lcRoutes['v-search-tag'] = 'mot-cle/:tag';
}

return $lcRoutes;
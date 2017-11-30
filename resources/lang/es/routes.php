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

    'countries' => 'paises',

    'login'    => 'login',
    'logout'   => 'cerrar-sesion',
    'register' => 'registrate',

    'page'   => 'pagina/{slug}.html',
    't-page' => 'pagina',
    'v-page' => 'pagina/:slug.html',

    'contact' => 'contacto.html',

];

if (config('larapen.core.multiCountriesWebsite')) {
    // Sitemap
    $lcRoutes['sitemap'] = '{countryCode}/mapa-del-sitio.html';
    $lcRoutes['v-sitemap'] = ':countryCode/mapa-del-sitio.html';

    // Latest Ads
    $lcRoutes['search'] = '{countryCode}/busqueda';
    $lcRoutes['t-search'] = 'busqueda';
    $lcRoutes['v-search'] = ':countryCode/busqueda';

    // Search by Sub-Category
    $lcRoutes['search-subCat'] = '{countryCode}/trabajo-categoria/{catSlug}/{subCatSlug}';
    $lcRoutes['t-search-subCat'] = 'trabajo-categoria';
    $lcRoutes['v-search-subCat'] = ':countryCode/trabajo-categoria/:catSlug/:subCatSlug';

    // Search by Category
    $lcRoutes['search-cat'] = '{countryCode}/trabajo-categoria/{catSlug}';
    $lcRoutes['t-search-cat'] = 'trabajo-categoria';
    $lcRoutes['v-search-cat'] = ':countryCode/trabajo-categoria/:catSlug';

    // Search by Location
    $lcRoutes['search-city'] = '{countryCode}/trabajos/{city}/{id}';
    $lcRoutes['t-search-city'] = 'trabajos';
    $lcRoutes['v-search-city'] = ':countryCode/trabajos/:city/:id';

    // Search by User
    $lcRoutes['search-user'] = '{countryCode}/users/{id}/trabajos';
    $lcRoutes['t-search-user'] = 'users';
    $lcRoutes['v-search-user'] = ':countryCode/users/:id/trabajos';
	
	// Search by Username
	$lcRoutes['search-username'] = '{countryCode}/profile/{username}';
	$lcRoutes['v-search-username'] = ':countryCode/profile/:username';

    // Search by Company name
    $lcRoutes['search-company'] = '{countryCode}/companias/{id}/trabajos';
    $lcRoutes['t-search-company'] = 'companias-trabajos';
    $lcRoutes['v-search-company'] = ':countryCode/companias/:id/trabajos';
	$lcRoutes['companies-list'] = '{countryCode}/companias';
	
	// Search by Tag
	$lcRoutes['search-tag'] = '{countryCode}/tag/{tag}';
	$lcRoutes['t-search-tag'] = 'tag';
	$lcRoutes['v-search-tag'] = ':countryCode/tag/:tag';
} else {
    // Sitemap
    $lcRoutes['sitemap'] = 'mapa-del-sitio.html';
    $lcRoutes['v-sitemap'] = 'mapa-del-sitio.html';

    // Latest Ads
    $lcRoutes['search'] = 'busqueda';
    $lcRoutes['t-search'] = 'busqueda';
    $lcRoutes['v-search'] = 'busqueda';

    // Search by Sub-Category
    $lcRoutes['search-subCat'] = 'trabajo-categoria/{catSlug}/{subCatSlug}';
    $lcRoutes['t-search-subCat'] = 'trabajo-categoria';
    $lcRoutes['v-search-subCat'] = 'trabajo-categoria/:catSlug/:subCatSlug';

    // Search by Category
    $lcRoutes['search-cat'] = 'trabajo-categoria/{catSlug}';
    $lcRoutes['t-search-cat'] = 'trabajo-categoria';
    $lcRoutes['v-search-cat'] = 'trabajo-categoria/:catSlug';

    // Search by Location
    $lcRoutes['search-city'] = 'trabajos/{city}/{id}';
    $lcRoutes['t-search-city'] = 'trabajos';
    $lcRoutes['v-search-city'] = 'trabajos/:city/:id';

    // Search by User
    $lcRoutes['search-user'] = 'users/{id}/trabajos';
    $lcRoutes['t-search-user'] = 'users';
    $lcRoutes['v-search-user'] = 'users/:id/trabajos';
	
	// Search by Username
	$lcRoutes['search-username'] = 'profile/{username}';
	$lcRoutes['v-search-username'] = 'profile/:username';

    // Search by Company name
    $lcRoutes['search-company'] = 'companias/{id}/trabajos';
    $lcRoutes['t-search-company'] = 'companias-trabajos';
    $lcRoutes['v-search-company'] = 'companias/:id/trabajos';
	$lcRoutes['companies-list'] = 'companias';
	
	// Search by Tag
	$lcRoutes['search-tag'] = 'tag/{tag}';
	$lcRoutes['t-search-tag'] = 'tag';
	$lcRoutes['v-search-tag'] = 'tag/:tag';
}

return $lcRoutes;
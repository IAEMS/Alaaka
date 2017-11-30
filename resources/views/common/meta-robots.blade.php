@if (
		(isset($country) and $country->has('lang') and config('app.locale') != $country->get('lang')->get('abbr')) or
		(config('larapen.core.noIndex.allSite') == true) or
		(str_contains(\Route::currentRouteAction(), 'Search\CategoryController') and config('larapen.core.noIndex.categories') == true) or
		(str_contains(\Route::currentRouteAction(), 'Search\TagController') and config('larapen.core.noIndex.tags') == true) or
		(str_contains(\Route::currentRouteAction(), 'Search\CityController') and config('larapen.core.noIndex.cities') == true) or
		(str_contains(\Route::currentRouteAction(), 'Search\UserController') and config('larapen.core.noIndex.users') == true) or
		(str_contains(\Route::currentRouteAction(), 'Search\CompanyController') and config('larapen.core.noIndex.companies') == true)
	)
	<meta name="robots" content="noindex,nofollow">
	<meta name="googlebot" content="noindex">
@endif
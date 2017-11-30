<?php
// Search parameters
$queryString = (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');

// Get the Default Language
$cacheExpiration = (isset($cacheExpiration)) ? $cacheExpiration : config('settings.app_cache_expiration', 60);
$defaultLang = Cache::remember('language.default', $cacheExpiration, function () {
    $defaultLang = \App\Models\Language::where('default', 1)->first();
    return $defaultLang;
});

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.activation_country_flag')) {
	if (isset($country) and !$country->isEmpty()) {
		if (\App\Models\Country::where('active', 1)->count() > 1) {
			$multiCountriesIsEnabled = true;
			$multiCountriesLabel = 'title="' . t('Select a Country') . '"';
		}
	}
}

// Logo Label
$logoLabel = '';
if (getSegment(1) != trans('routes.countries')) {
	$logoLabel = config('settings.app_name') . ((isset($country) and $country->has('name')) ? ' ' . $country->get('name') : '');
}
?>
<div class="header">
	<nav class="navbar navbar-site navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
				{{-- Toggle Nav --}}
				<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				{{-- Country Flag (Mobile) --}}
				@if (getSegment(1) != trans('routes.countries'))
					@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
						@if (isset($country) and !$country->isEmpty())
							@if (file_exists(public_path().'/images/flags/24/'.strtolower($country->get('code')).'.png'))
								<button class="flag-menu country-flag visible-xs btn btn-default hidden" href="#selectCountry" data-toggle="modal" >
									<img src="{{ url('images/flags/24/'.strtolower($country->get('code')).'.png') . getPictureVersion() }}" style="float: left;">
									<span class="caret hidden-xs"></span>
								</button>
							@endif
						@endif
					@endif
				@endif
				
				{{-- Logo --}}
				<a href="{{ lurl('/') }}" class="navbar-brand logo logo-title">
					<img src="{{ \Storage::url(config('settings.app_logo')) . getPictureVersion() }}"
						 alt="{{ strtolower(config('settings.app_name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
						 data-toggle="tooltip"
						 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
				</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					{{-- Country Flag --}}
					@if (getSegment(1) != trans('routes.countries'))
						@if (config('settings.activation_country_flag'))
							@if (isset($country) and !$country->isEmpty())
								@if (file_exists(public_path().'/images/flags/32/'.strtolower($country->get('code')).'.png'))
									<li class="flag-menu country-flag tooltipHere hidden-xs" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>
										@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
											<a href="#selectCountry" data-toggle="modal">
												<img class="flag-icon" src="{{ url('images/flags/32/'.strtolower($country->get('code')).'.png') . getPictureVersion() }}" style="float: left;">
												<span class="caret hidden-sm"></span>
											</a>
										@else
											<a style="cursor: default;">
												<img class="flag-icon" src="{{ url('images/flags/32/'.strtolower($country->get('code')).'.png') . getPictureVersion() }}" style="float: left;">
											</a>
										@endif
									</li>
								@endif
							@endif
						@endif
					@endif
					<li>
						<a href="{{ lurl(trans('routes.v-search', ['countryCode' => $country->get('icode')])) }}">
							<i class="icon-th-list-2 hidden-sm"></i>
							{{ t('Browse Jobs') }}
						</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if (!auth()->user())
						<li>
							@if (config('larapen.core.login.openInModal'))
								<a href="#quickLogin" data-toggle="modal"><i class="icon-user fa"></i> {{ t('Log In') }}</a>
							@else
								<a href="{{ lurl(trans('routes.login')) }}"><i class="icon-user fa"></i> {{ t('Log In') }}</a>
							@endif
						</li>
						<li><a href="{{ lurl(trans('routes.register')) }}"><i class="icon-user-add fa"></i> {{ t('Register') }}</a></li>
						<li class="postadd">
							@if (config('settings.guests_can_post_ads') != '1')
								<a class="btn btn-block btn-post btn-yellow" href="#quickLogin" data-toggle="modal">{{ t('Create a Job ad') }}</a>
							@else
								<a class="btn btn-block btn-post btn-yellow" href="{{ lurl('posts/create') }}">{{ t('Create a Job ad') }}</a>
							@endif
						</li>
					@else
						@if (isset($user))
							<li>
								<a href="{{ lurl(trans('routes.logout')) }}">
									<i class="glyphicon glyphicon-off hidden-sm"></i> {{ t('Log Out') }}
								</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-user fa hidden-sm"></i>
									<span>{{ $user->name }}</span>
									<i class="icon-down-open-big fa hidden-sm"></i>
								</a>
								<ul class="dropdown-menu user-menu">
									<li class="active"><a href="{{ lurl('account') }}"><i class="icon-home"></i> {{ t('Personal Home') }}</a></li>
                                    @if (in_array($user->user_type_id, [1, 2]))
									    <li><a href="{{ lurl('account/companies') }}"><i class="icon-town-hall"></i> {{ t('My companies') }} </a></li>
										<li><a href="{{ lurl('account/my-posts') }}"><i class="icon-th-thumb"></i> {{ t('My ads') }} </a></li>
                                        <li><a href="{{ lurl('account/pending-approval') }}"><i class="icon-hourglass"></i> {{ t('Pending approval') }} </a></li>
                                        <li><a href="{{ lurl('account/archived') }}"><i class="icon-folder-close"></i> {{ t('Archived ads') }}</a></li>
										<li><a href="{{ lurl('account/messages') }}"><i class="icon-mail-1"></i> {{ t('Messages') }}</a></li>
										<li><a href="{{ lurl('account/transactions') }}"><i class="icon-money"></i> {{ t('Transactions') }}</a></li>
                                    @endif
                                    @if (in_array($user->user_type_id, [1, 3]))
									    <li><a href="{{ lurl('account/resumes') }}"><i class="icon-attach"></i> {{ t('My resumes') }} </a></li>
										<li><a href="{{ lurl('account/favourite') }}"><i class="icon-heart"></i> {{ t('Favourite jobs') }} </a></li>
									    <li><a href="{{ lurl('account/saved-search') }}"><i class="icon-star-circled"></i> {{ t('Saved searches') }} </a></li>
                                    @endif
								</ul>
							</li>
                            @if (in_array($user->user_type_id, [1, 2]))
							<li class="postadd">
								<a class="btn btn-block btn-post btn-yellow" href="{{ lurl('posts/create') }}">{{ t('Create a Job ad') }}</a>
							</li>
							@endif
						@endif
					@endif

					@if (count(LaravelLocalization::getSupportedLocales()) > 1)
					<!-- Language selector -->
					<li class="dropdown lang-menu">
						<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
							{{ strtoupper(config('app.locale')) }}
							<span class="caret hidden-sm"> </span>
						</button>
						<ul class="dropdown-menu" role="menu">
							@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
								@if (strtolower($localeCode) != strtolower(config('app.locale')))
									<?php
										// Controller parameters
										$params = [
												'countryCode' 	=> $country->get('icode'),
												'catSlug' 		=> (isset($uriPathCatSlug) ? $uriPathCatSlug : null),
												'subCatSlug' 	=> (isset($uriPathSubCatSlug) ? $uriPathSubCatSlug : null),
												'cityName' 		=> (isset($uriPathCityName) ? $uriPathCityName : null),
												'cityId' 		=> (isset($uriPathCityId) ? $uriPathCityId : null),
                                                'pageSlug' 		=> (isset($uriPathPageSlug) ? $uriPathPageSlug : null),
												];
										// Default
										$link       = LaravelLocalization::getLocalizedURL($localeCode, null, [], $params);
										$localeCode = strtolower($localeCode);
									?>
									<li>
										<a href="{{ $link }}" tabindex="-1" rel="alternate" hreflang="{{ $localeCode }}">
											{{{ $properties['native'] }}}
										</a>
									</li>
								@endif
							@endforeach
						</ul>
					</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
</div>

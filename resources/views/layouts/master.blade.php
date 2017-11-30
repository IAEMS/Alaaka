{{--
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
--}}
<?php
	$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
	$detectAdsBlockerPlugin = load_installed_plugin('detectadsblocker');
?>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@include('common.meta-robots')
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-title" content="{{ config('settings.app_name') }}">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ \Storage::url('app/default/ico/apple-touch-icon-144-precomposed.png') . getPictureVersion() }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ \Storage::url('app/default/ico/apple-touch-icon-114-precomposed.png') . getPictureVersion() }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ \Storage::url('app/default/ico/apple-touch-icon-72-precomposed.png') . getPictureVersion() }}">
	<link rel="apple-touch-icon-precomposed" href="{{ \Storage::url('app/default/ico/apple-touch-icon-57-precomposed.png') . getPictureVersion() }}">
	<link rel="shortcut icon" href="{{ \Storage::url(config('settings.app_favicon')) . getPictureVersion() }}">
	<title>{{ MetaTag::get('title') }}</title>
	{!! MetaTag::tag('description') !!}{!! MetaTag::tag('keywords') !!}
	<link rel="canonical" href="{{ $fullUrl }}"/>
	@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
		@if (strtolower($localeCode) != strtolower(config('app.locale')))
			<link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" hreflang="{{ strtolower($localeCode) }}"/>
		@endif
	@endforeach
	@if (count($dnsPrefetch) > 0)
		@foreach($dnsPrefetch as $dns)
			<link rel="dns-prefetch" href="{{ $dns }}">
		@endforeach
	@endif
	@if (isset($post))
		@if (isVerifiedPost($post))
			@if (config('services.facebook.client_id'))
				<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
			@endif
			{!! $og->renderTags() !!}
			{!! MetaTag::twitterCard() !!}
		@endif
	@else
		@if (config('services.facebook.client_id'))
			<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
		@endif
		{!! $og->renderTags() !!}
		{!! MetaTag::twitterCard() !!}
	@endif
	@include('feed::links')
	@if (config('settings.google_site_verification'))
		<meta name="google-site-verification" content="{{ config('settings.google_site_verification') }}" />
	@endif
	@if (config('settings.msvalidate'))
		<meta name="msvalidate.01" content="{{ config('settings.msvalidate') }}" />
	@endif
	@if (config('settings.alexa_verify_id'))
		<meta name="alexaVerifyID" content="{{ config('settings.alexa_verify_id') }}" />
	@endif
	
	@yield('before_styles')
	
	@if (config('lang.direction') == 'rtl')
		<link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
		<link href="{{ url(mix('css/app.rtl.css')) }}" rel="stylesheet">
	@else
		<link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
	@endif
	@if (isset($detectAdsBlockerPlugin) and !empty($detectAdsBlockerPlugin))
		<link href="{{ url('assets/detectadsblocker/css/style.css') . getPictureVersion() }}" rel="stylesheet">
	@endif
	<link href="{{ url('css/custom.css') . getPictureVersion() }}" rel="stylesheet">
	
	@yield('after_styles')
	
	@if (isset($installedPlugins) and count($installedPlugins) > 0)
		@foreach($installedPlugins as $pluginName)
			@yield($pluginName . '_styles')
		@endforeach
	@endif
	
	@if (config('settings.custom_css'))
	<style type="text/css">
		<?php
        $customCss = config('settings.custom_css');
        $customCss = preg_replace('/<[^>]+>/i', '', $customCss);

		echo $customCss . "\n";
		?>
	</style>
	@endif

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<script>
		paceOptions = {
			elements: true
		};
	</script>
	<script src="{{ url('assets/js/pace.min.js') }}"></script>
</head>
<body class="{{ config('app.skin') }}">

<div id="wrapper">

	@section('header')
		@include('layouts.inc.header')
	@show

	@section('search')
	@show
		
	@section('wizard')
	@show

	@if (isset($siteCountryInfo))
		<div class="h-spacer"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-warning">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{!! $siteCountryInfo !!}
					</div>
				</div>
			</div>
		</div>
	@endif

	@yield('content')

	@section('info')
	@show
	
	@section('footer')
		@include('layouts.inc.footer')
	@show

</div>

@section('modal_location')
@show
@section('modal_abuse')
@show
@section('modal_message')
@show

@includeWhen(!\Auth::check(), 'layouts.inc.modal.login')
@include('layouts.inc.modal.change-country')

@if (isset($detectAdsBlockerPlugin) and !empty($detectAdsBlockerPlugin))
	@if (view()->exists('detectadsblocker::modal'))
		@include('detectadsblocker::modal')
	@endif
@endif

<script>
	{{-- Init. Translation vars --}}
	var langLayout = {
		'hideMaxListItems': {
			'moreText': "{{ t('View More') }}",
			'lessText': "{{ t('View Less') }}"
		}
	};
</script>

@yield('before_scripts')

<script src="{{ url(mix('js/app.js')) }}"></script>
@if (file_exists(public_path() . '/assets/plugins/select2/js/i18n/'.config('app.locale').'.js'))
	<script src="{{ url('assets/plugins/select2/js/i18n/'.config('app.locale').'.js') }}"></script>
@endif
@if (isset($detectAdsBlockerPlugin) and !empty($detectAdsBlockerPlugin))
	<script src="{{ url('assets/detectadsblocker/js/script.js') . getPictureVersion() }}"></script>
@endif
<script>
	$(document).ready(function () {
		{{-- Select Boxes --}}
		$('.selecter').select2({
			language: '{{ config('app.locale') }}',
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity
		});
		
		{{-- Searchable Select Boxes --}}
		$('.sselecter').select2({
			language: '{{ config('app.locale') }}',
			dropdownAutoWidth: 'true'
		});
		
		{{-- Social Share --}}
		$('.share').ShareLink({
			title: '{{ addslashes(MetaTag::get('title')) }}',
			text: '{!! addslashes(MetaTag::get('title')) !!}',
			url: '{!! $fullUrl !!}',
			width: 640,
			height: 480
		});
		
		{{-- Modal Login --}}
		@if (isset($errors) and $errors->any())
			@if ($errors->any() and old('quickLoginForm')=='1')
				$('#quickLogin').modal();
			@endif
		@endif
	});
</script>

@yield('after_scripts')

@if (isset($installedPlugins) and count($installedPlugins) > 0)
	@foreach($installedPlugins as $pluginName)
		@yield($pluginName . '_scripts')
	@endforeach
@endif

<?php
	/* Tracking Code */
	echo config('settings.tracking_code') . "\n";
?>
</body>
</html>
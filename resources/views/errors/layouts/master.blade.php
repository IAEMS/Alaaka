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
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex,nofollow">
	<meta name="googlebot" content="noindex">
	<link rel="shortcut icon" href="{{ \Storage::url(config('settings.app_favicon')) . getPictureVersion() }}">
	<title>@yield('title')</title>
	
	@yield('before_styles')
	
	@if (config('lang.direction') == 'rtl')
		<link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
		<link href="{{ url(mix('css/app.rtl.css')) }}" rel="stylesheet">
	@else
		<link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
	@endif
	<link href="{{ url('css/custom.css') . getPictureVersion() }}" rel="stylesheet">
	
	@yield('after_styles')
	
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
<body class="{{ config('settings.app_skin') }}">

<div id="wrapper">

	@section('header')
		@include('errors.layouts.inc.header')
	@show

	@section('search')
	@show

	@yield('content')

	@section('info')
	@show
	
	@section('footer')
		@include('errors.layouts.inc.footer')
	@show

</div>

@yield('before_scripts')

<script>
	{{-- Init. Translation vars --}}
	var langLayout = {
		'hideMaxListItems': {
			'moreText': "{{ t('View More') }}",
			'lessText': "{{ t('View Less') }}"
		}
	};
</script>
<script src="{{ url(mix('js/app.js')) }}"></script>

@yield('after_scripts')

<?php
	/* Tracking Code */
	echo config('settings.tracking_code') . "\n";
?>
</body>
</html>
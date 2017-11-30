<?php
// Init.
$sForm = [
	'enableFormAreaCustomization' => '0',
	'hideTitles'                  => '0',
	'title'                       => t('Find a job near you'),
	'subTitle'                    => t('Simple, fast and efficient'),
	'bigTitleColor'               => 'color: #FFF;',
	'subTitleColor'               => 'color: #FFF;',
	'backgroundColor'             => 'background-color: #444;',
	'backgroundImage'             => null,
	'height'                      => '450px',
	'parallax'                    => '0',
	'hideForm'                    => '0',
	'formBorderColor'             => 'background-color: #7324bc;',
	'formBorderSize'              => '5px',
	'formBtnBackgroundColor'      => 'background-color: #7324bc; border-color: #7324bc;',
	'formBtnTextColor'            => 'color: #FFF;',
];

// Blue Theme values
if (config('app.skin') == 'skin-blue') {
	$sForm['formBorderColor'] = 'background-color: #4682B4;';
	$sForm['formBtnBackgroundColor'] = 'background-color: #4682B4; border-color: #4682B4;';
}

// Green Theme values
if (config('app.skin') == 'skin-green') {
	$sForm['formBorderColor'] = 'background-color: #228B22;';
	$sForm['formBtnBackgroundColor'] = 'background-color: #228B22; border-color: #228B22;';
}

// Red Theme values
if (config('app.skin') == 'skin-red') {
	$sForm['formBorderColor'] = 'background-color: #fa2320;';
	$sForm['formBtnBackgroundColor'] = 'background-color: #fa2320; border-color: #fa2320;';
}

// Yellow Theme values
if (config('app.skin') == 'skin-yellow') {
	$sForm['formBorderColor'] = 'background-color: #FFD700;';
	$sForm['formBtnBackgroundColor'] = 'background-color: #FFD700; border-color: #FFD700;';
}

// Get Search Form Options
if (isset($searchFormOptions)) {
	if (isset($searchFormOptions['enable_form_area_customization']) and !empty($searchFormOptions['enable_form_area_customization'])) {
		$sForm['enableFormAreaCustomization'] = $searchFormOptions['enable_form_area_customization'];
	}
	if (isset($searchFormOptions['hide_titles']) and !empty($searchFormOptions['hide_titles'])) {
		$sForm['hideTitles'] = $searchFormOptions['hide_titles'];
	}
	if (isset($searchFormOptions['title_' . config('app.locale')]) and !empty($searchFormOptions['title_' . config('app.locale')])) {
		$sForm['title'] = $searchFormOptions['title_' . config('app.locale')];
		$sForm['title'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['title']);
		if (str_contains($sForm['title'], '{count_jobs}')) {
			try {
				$countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
			} catch (\Exception $e) {
				$countPosts = 0;
			}
			$sForm['title'] = str_replace('{count_jobs}', $countPosts, $sForm['title']);
		}
		if (str_contains($sForm['title'], '{count_users}')) {
			try {
				$countUsers = \App\Models\User::count();
			} catch (\Exception $e) {
				$countUsers = 0;
			}
			$sForm['title'] = str_replace('{count_users}', $countUsers, $sForm['title']);
		}
	}
	if (isset($searchFormOptions['sub_title_' . config('app.locale')]) and !empty($searchFormOptions['sub_title_' . config('app.locale')])) {
		$sForm['subTitle'] = $searchFormOptions['sub_title_' . config('app.locale')];
		$sForm['subTitle'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['subTitle']);
		if (str_contains($sForm['subTitle'], '{count_jobs}')) {
			try {
				$countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
			} catch (\Exception $e) {
				$countPosts = 0;
			}
			$sForm['subTitle'] = str_replace('{count_jobs}', $countPosts, $sForm['subTitle']);
		}
		if (str_contains($sForm['subTitle'], '{count_users}')) {
			try {
				$countUsers = \App\Models\User::count();
			} catch (\Exception $e) {
				$countUsers = 0;
			}
			$sForm['subTitle'] = str_replace('{count_users}', $countUsers, $sForm['subTitle']);
		}
	}
	if (isset($searchFormOptions['big_title_color']) and !empty($searchFormOptions['big_title_color'])) {
		$sForm['bigTitleColor'] = 'color: ' . $searchFormOptions['big_title_color'] . ';';
	}
	if (isset($searchFormOptions['sub_title_color']) and !empty($searchFormOptions['sub_title_color'])) {
		$sForm['subTitleColor'] = 'color: ' . $searchFormOptions['sub_title_color'] . ';';
	}
	if (isset($searchFormOptions['background_color']) and !empty($searchFormOptions['background_color'])) {
		$sForm['backgroundColor'] = 'background-color: ' . $searchFormOptions['background_color'] . ';';
	}
	if (isset($searchFormOptions['background_image']) and !empty($searchFormOptions['background_image'])) {
		$sForm['backgroundImage'] = 'background-image: url(' . \Storage::url($searchFormOptions['background_image']) . getPictureVersion() . ');';
	}
	if (isset($searchFormOptions['height']) and !empty($searchFormOptions['height'])) {
		$sForm['height'] = 'height: ' . $searchFormOptions['height'] . ';';
		$sForm['height'] .= 'max-height: ' . $searchFormOptions['height'] . ';';
	}
	if (isset($searchFormOptions['parallax']) and !empty($searchFormOptions['parallax'])) {
		$sForm['parallax'] = $searchFormOptions['parallax'];
	}
	if (isset($searchFormOptions['hide_form']) and !empty($searchFormOptions['hide_form'])) {
		$sForm['hideForm'] = $searchFormOptions['hide_form'];
	}
	if (isset($searchFormOptions['form_border_color']) and !empty($searchFormOptions['form_border_color'])) {
		$sForm['formBorderColor'] = 'background-color: ' . $searchFormOptions['form_border_color'] . ';';
	}
	if (isset($searchFormOptions['form_border_size']) and !empty($searchFormOptions['form_border_size'])) {
		$sForm['formBorderSize'] = 'padding: ' . $searchFormOptions['form_border_size'] . ';';
	}
	if (isset($searchFormOptions['form_btn_background_color']) and !empty($searchFormOptions['form_btn_background_color'])) {
		$sForm['formBtnBackgroundColor'] = 'background-color: ' . $searchFormOptions['form_btn_background_color'] . ';';
		$sForm['formBtnBackgroundColor'] .= 'border-color: ' . $searchFormOptions['form_btn_background_color'] . ';';
	}
	if (isset($searchFormOptions['form_btn_text_color']) and !empty($searchFormOptions['form_btn_text_color'])) {
		$sForm['formBtnTextColor'] = 'color: ' . $searchFormOptions['form_btn_text_color'] . ';';
	}
}

// Get Search Form Countries table
if (isset($country) and $country->has('background_image')) {
	if (!empty($country->get('background_image')) and \Storage::exists($country->get('background_image'))) {
		$sForm['backgroundImage'] = 'background-image: url(' . \Storage::url($country->get('background_image')) . getPictureVersion() . ');';
	}
}
?>
@if (isset($sForm['enableFormAreaCustomization']) and $sForm['enableFormAreaCustomization'] == '1')
	
	@if (isset($firstSection) and !$firstSection)
		<div class="h-spacer"></div>
	@endif
	
	<?php $parallax = (isset($sForm['parallax']) and $sForm['parallax'] == '1') ? 'parallax' : ''; ?>
	<div class="wide-intro {{ $parallax }}" style="{!! $sForm['backgroundColor'] !!}{!! $sForm['backgroundImage'] !!}{!! $sForm['height'] !!}">
		<div class="dtable hw100">
			<div class="dtable-cell hw100">
				<div class="container text-center">
					
					@if ($sForm['hideTitles'] != '1')
						<h1 class="intro-title animated fadeInDown" style="{!! $sForm['bigTitleColor'] !!}"> {{ $sForm['title'] }} </h1>
						<p class="sub animateme fittext3 animated fadeIn" style="{!! $sForm['subTitleColor'] !!}">
							{!! $sForm['subTitle'] !!}
						</p>
					@endif
					
					@if ($sForm['hideForm'] != '1')
						<div class="row search-row fadeInUp" style="{!! $sForm['formBorderColor'] !!}{!! $sForm['formBorderSize'] !!}">
							<form id="seach" name="search" action="{{ lurl(trans('routes.v-search', ['countryCode' => $country->get('icode')])) }}" method="GET">
								<div class="col-lg-5 col-sm-5 search-col relative">
									<i class="icon-docs icon-append"></i>
									<input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('What?') }}" value="">
								</div>
								<div class="col-lg-5 col-sm-5 search-col relative locationicon">
									<i class="icon-location-2 icon-append"></i>
									<input type="hidden" id="lSearch" name="l" value="">
									<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
										   placeholder="{{ t('Where?') }}" value="" title="" data-placement="bottom"
										   data-toggle="tooltip" type="button"
										   data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
								</div>
								<div class="col-lg-2 col-sm-2 search-col">
									<button class="btn btn-primary btn-search btn-block" style="{!! $sForm['formBtnBackgroundColor'] !!}{!! $sForm['formBtnTextColor'] !!}">
										<i class="icon-search"></i> <strong>{{ t('Find') }}</strong>
									</button>
								</div>
								{!! csrf_field() !!}
							</form>
						</div>
					@endif
				
				</div>
			</div>
		</div>
	</div>

@else
	
	@include('home.inc.spacer')
	<div class="container">
		<div class="intro">
			<div class="dtable hw100">
				<div class="dtable-cell hw100">
					<div class="container text-center">
						<div class="row search-row">
							<form id="seach" name="search" action="{{ lurl(trans('routes.v-search', ['countryCode' => $country->get('icode')])) }}" method="GET">
								<div class="col-lg-5 col-sm-5 search-col relative">
									<i class="icon-docs icon-append"></i>
									<input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('What?') }}" value="">
								</div>
								<div class="col-lg-5 col-sm-5 search-col relative locationicon">
									<i class="icon-location-2 icon-append"></i>
									<input type="hidden" id="lSearch" name="l" value="">
									<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
										   placeholder="{{ t('Where?') }}" value="" title="" data-placement="bottom"
										   data-toggle="tooltip" type="button"
										   data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
								</div>
								<div class="col-lg-2 col-sm-2 search-col">
									<button class="btn btn-primary btn-search btn-block"><i class="icon-search"></i> <strong>{{ t('Search') }}</strong>
									</button>
								</div>
								{!! csrf_field() !!}
							</form>
						</div>
	
					</div>
				</div>
			</div>
		</div>
	</div>
	
@endif

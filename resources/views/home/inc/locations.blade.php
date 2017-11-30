<?php
// Default Map's values
$map = ['show' => false];

// Get Admin Map's values
if (isset($citiesOptions)) {
    if (file_exists(config('larapen.core.maps.path') . strtolower($country->get('code')) . '.svg')) {
        if (isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
            $map['show'] = true;
        }
    }
}
?>
@include('home.inc.spacer')
<div class="container">
	<div class="row">
		<div class="col-lg-12 page-content">
			<div>
				<?php
				if ($map['show']):
					// Display the Map
					$leftClassCol = 'col-lg-8 col-md-8 col-sm-12';
					$ulCol = 'col-xs-4';
				else:
					// Hide the Map
					$leftClassCol = 'col-lg-12 col-md-12 col-sm-12';
					$ulCol = 'col-xs-3';
				endif
				?>
				<div class="{{ $leftClassCol }} page-content no-margin no-padding">
					@if (isset($cities))
						<div class="relative location-content">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div>
										<h2 class="title-3">
											<i class="icon-location-2"></i>&nbsp;
											{{ t('Choose a city') }}
										</h2>
										<div class="row" style="padding: 0 10px 0 20px;">
											@foreach ($cities as $key => $items)
												<ul class="cat-list {{ $ulCol }} {{ (count($cities) == $key+1) ? 'cat-list-border' : '' }}">
													@foreach ($items as $k => $city)
														<li>
															@if ($city->id == 999999999)
																<a href="#browseAdminCities" id="dropdownMenu1" data-toggle="modal">{{ $city->name }}</a>
															@else
																<a href="{{ lurl(trans('routes.v-search-city',
																[
																	'countryCode' => $country->get('icode'),
																	'city'        => slugify($city->name),
																	'id'          => $city->id
																])) }}">
																	{{ $city->name }}
																</a>
															@endif
														</li>
													@endforeach
												</ul>
											@endforeach
										</div>
									</div>
								</div>
							</div>
	
							@if (!auth()->check())
								<a class="btn btn-lg btn-yellow" href="{{ lurl(trans('routes.register')) . '?type=3' }}" style="padding-left: 30px; padding-right: 30px; text-transform: none;">
									{{ t('Add your Resume') }}
								</a>
							@else
								@if (in_array($user->user_type_id, [1, 2]))
									<a class="btn btn-lg btn-yellow" href="{{ lurl('posts/create') }}" style="padding-left: 30px; padding-right: 30px; text-transform: none;">
										{{ t('Post a Job') }}
									</a>
								@endif
							@endif
	
						</div>
					@endif
				</div>
				
				@include('layouts.inc.tools.svgmap')
				
			</div>
		</div>
	</div>
</div>

@section('modal_location')
	@parent
	@include('layouts.inc.modal.location')
@endsection

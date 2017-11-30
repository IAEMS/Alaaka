@if (isset($featuredCompanies) and !empty($featuredCompanies))
	@if (isset($featuredCompanies->companies) and $featuredCompanies->companies->count() > 0)
		@include('home.inc.spacer')
		<div class="container">
			<div class="col-lg-12 content-box layout-section">
				<div class="row row-featured row-featured-category row-featured-company">
					<div class="col-lg-12  box-title no-border">
						<div class="inner">
							<h2>
								<span class="title-3">{!! $featuredCompanies->title !!}</span>
								<a class="sell-your-item" href="{{ $featuredCompanies->link }}">
									{{ t('View more') }}
									<i class="icon-th-list"></i>
								</a>
							</h2>
						</div>
					</div>
			
					@foreach($featuredCompanies->companies as $key => $iCompany)
						<?php
						// Company URL setting
						$companyUrl = lurl(trans('routes.v-search-company', ['countryCode' => $country->get('icode'), 'id' => $iCompany->id]));
						?>
						<div class="col-lg-2 col-md-3 col-sm-3 col-xs-4 f-category">
							<a href="{{ $companyUrl }}">
								<img alt="{{ mb_ucfirst($iCompany->name) }}" class="img-responsive" src="{{ resize(\App\Models\Company::getLogo($iCompany->logo), 'medium') }}">
								<h6> {{ t('Jobs at') }}
									<span class="company-name">{{ mb_ucfirst($iCompany->name) }}</span>
									<span class="jobs-count text-muted">({{ mb_ucfirst($iCompany->posts_count) }})</span>
								</h6>
							</a>
						</div>
					@endforeach
			
				</div>
			</div>
		</div>
	@endif
@endif

<footer class="main-footer">
	<div class="footer-content">
		<div class="container">
			<div class="row">
				
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<div class="footer-col">
						<h4 class="footer-title">{{ t('About us') }}</h4>
						<ul class="list-unstyled footer-nav">
							@if (isset($pages) and $pages->count() > 0)
								@foreach($pages as $page)
									<li>
										<?php
											$linkTarget = '';
											if ($page->target_blank == 1) {
												$linkTarget = 'target="_blank"';
											}
										?>
										@if (!empty($page->external_link))
											<a href="{!! $page->external_link !!}" rel="nofollow" {!! $linkTarget !!}> {{ $page->name }} </a>
										@else
											<a href="{{ lurl(trans('routes.v-page', ['slug' => $page->slug])) }}" {!! $linkTarget !!}> {{ $page->name }} </a>
										@endif
									</li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<div class="footer-col">
						<h4 class="footer-title">{{ t('Contact & Sitemap') }}</h4>
						<ul class="list-unstyled footer-nav">
							<li><a href="{{ lurl(trans('routes.contact')) }}"> {{ t('Contact') }} </a></li>
							<li><a href="{{ lurl(trans('routes.companies-list', ['countryCode' => $country->get('icode')])) }}"> {{ t('Companies') }} </a></li>
							<li><a href="{{ lurl(trans('routes.v-sitemap', ['countryCode' => $country->get('icode')])) }}"> {{ t('Sitemap') }} </a></li>
							@if (\App\Models\Country::where('active', 1)->count() > 1)
								<li><a href="{{ lurl(trans('routes.countries')) }}"> {{ t('Countries') }} </a></li>
							@endif
						</ul>
					</div>
				</div>
				
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="footer-col">
						<h4 class="footer-title">{{ t('My Account') }}</h4>
						<ul class="list-unstyled footer-nav">
							@if (!auth()->user())
								<li>
									@if (config('larapen.core.login.openInModal'))
										<a href="#quickLogin" data-toggle="modal"> {{ t('Log In') }} </a>
									@else
										<a href="{{ lurl(trans('routes.login')) }}"> {{ t('Log In') }} </a>
									@endif
								</li>
								<li><a href="{{ lurl(trans('routes.register')) }}"> {{ t('Register') }} </a></li>
							@else
								<li><a href="{{ lurl('account') }}"> {{ t('Personal Home') }} </a></li>
								@if (isset($user))
									@if (in_array($user->user_type_id, [1, 2]))
										<li><a href="{{ lurl('account/my-posts') }}"> {{ t('My ads') }} </a></li>
										<li><a href="{{ lurl('account/companies') }}"> {{ t('My companies') }} </a></li>
									@endif
									@if (in_array($user->user_type_id, [1, 3]))
										<li><a href="{{ lurl('account/resumes') }}"> {{ t('My resumes') }} </a></li>
										<li><a href="{{ lurl('account/favourite') }}"> {{ t('Favourite jobs') }} </a></li>
									@endif
								@endif
							@endif
						</ul>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="footer-col row">
						<?php
							$footerSocialClass = '';
							$footerSocialTitleClass = '';
						?>
						{{-- @todo: API Plugin --}}
						@if (config('settings.ios_app_url') or config('settings.android_app_url'))
							<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
								<div class="mobile-app-content">
									<h4 class="footer-title">{{ t('Mobile Apps') }}</h4>
									<div class="row ">
										@if (config('settings.ios_app_url'))
											<div class="col-xs-12 col-sm-6">
												<a class="app-icon" target="_blank" href="{{ config('settings.ios_app_url') }}">
													<span class="hide-visually">{{ t('iOS app') }}</span>
													<img src="{{ url('images/site/app-store-badge.svg') }}" alt="{{ t('Available on the App Store') }}">
												</a>
											</div>
										@endif
										@if (config('settings.android_app_url'))
											<div class="col-xs-12 col-sm-6">
												<a class="app-icon" target="_blank" href="{{ config('settings.android_app_url') }}">
													<span class="hide-visually">{{ t('Android App') }}</span>
													<img src="{{ url('images/site/google-play-badge.svg') }}" alt="{{ t('Available on Google Play') }}">
												</a>
											</div>
										@endif
									</div>
								</div>
							</div>
							<?php
								$footerSocialClass = 'hero-subscribe';
								$footerSocialTitleClass = 'no-margin';
							?>
						@endif
						
						<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
							<div class="{!! $footerSocialClass !!}">
								<h4 class="footer-title {!! $footerSocialTitleClass !!}">{{ t('Follow us on') }}</h4>
								<ul class="list-unstyled list-inline footer-nav social-list-footer social-list-color footer-nav-inline">
									@if (config('settings.facebook_page_url'))
										<li>
											<a class="icon-color fb" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.facebook_page_url') }}" data-original-title="Facebook">
												<i class="fa fa-facebook"></i>
											</a>
										</li>
									@endif
									@if (config('settings.twitter_url'))
										<li>
											<a class="icon-color tw" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.twitter_url') }}" data-original-title="Twitter">
												<i class="fa fa-twitter"></i>
											</a>
										</li>
									@endif
									@if (config('settings.google_plus_url'))
										<li>
											<a class="icon-color gp" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.google_plus_url') }}" data-original-title="Google+">
												<i class="fa fa-google-plus"></i>
											</a>
										</li>
									@endif
									@if (config('settings.linkedin_url'))
										<li>
											<a class="icon-color lin" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.linkedin_url') }}" data-original-title="Linkedin">
												<i class="fa fa-linkedin"></i>
											</a>
										</li>
									@endif
									@if (config('settings.pinterest_url'))
										<li>
											<a class="icon-color pin" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.pinterest_url') }}" data-original-title="Pinterest">
												<i class="fa fa-pinterest-p"></i>
											</a>
										</li>
									@endif
								</ul>
							</div>
						
						</div>
					</div>
				</div>
				
				<div style="clear: both"></div>
				
				<div class="col-lg-12">
					@if (isset($paymentMethods) and $paymentMethods->count() > 0)
						<div class="text-center paymanet-method-logo">
							{{-- Payment Plugins --}}
							@foreach($paymentMethods as $paymentMethod)
								@if (file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png')))
									<img src="{{ url('images/' . $paymentMethod->name . '/payment.png') }}" alt="{{ $paymentMethod->display_name }}" title="{{ $paymentMethod->display_name }}">
								@endif
							@endforeach
						</div>
					@else
						<hr>
					@endif
					
					<div class="copy-info text-center">
						© {{ date('Y') }} {{ config('settings.app_name') }}. {{ t('All Rights Reserved') }}.
						@if (config('settings.show_powered_by'))
							{{ t('Powered by') }} <a href="http://www.bedigit.com" title="BedigitCom">Bedigit</a>.
						@endif
					</div>
				</div>
			
			</div>
		</div>
	</div>
</footer>

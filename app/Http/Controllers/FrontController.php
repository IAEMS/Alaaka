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

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use ChrisKonnertz\OpenGraph\OpenGraph;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Language as LanguageLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use Torann\LaravelMetaTags\Facades\MetaTag;
use JavaScript;

class FrontController extends Controller
{
    public $request;
    public $data = array();

    public $lang;
    public $country;
	public $ipCountry;
    public $user;
    public $og;

    public $countries = null;

    public $cookieExpiration;
    public $cacheExpiration = 60; // In minutes (e.g. 60 for 1h)
    public $postsPicturesNumber = 1;
	
	public $paymentMethods;
	public $countPaymentMethods = 0;

    /**
     * FrontController constructor.
     */
    public function __construct()
    {
		// Initialization
        $this->lang = collect([]);
        $this->country = collect([]);
        $this->ipCountry = collect([]);
        $this->user = null;

        // From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next)
		{
			$this->getLocalization();
			$this->setFrontSettings();

			return $next($request);
		});
    }

    /**
     * Get Localization
     * Get Locale from browser or from country spoken language
     * and get Country by user IP
     */
    private function getLocalization()
    {
        // Language
        $langObj = new LanguageLocalization();
        $lang = $langObj->find();

        // Country
        $countryObj = new CountryLocalization();
        $countryObj->find();
        $countryObj->setCountryParameters();


        // Share var in Controller
        $this->lang = (!empty($lang)) ? $lang : collect([]);
        $this->country = (!empty($countryObj->country)) ? $countryObj->country : collect([]);
        $this->ipCountry = (!empty($countryObj->ipCountry)) ? $countryObj->ipCountry : collect([]);
        $this->user = (!empty($countryObj->user)) ? $countryObj->user : null;


        // Session : Set Country Code
        if (!$this->country->isEmpty() and $this->country->has('code')) {
            session(['country_code' => $this->country->get('code')]);
			$countryLangExists = $this->country->has('lang') && $this->country->get('lang')->has('abbr');
			Config::set('country.locale', ($countryLangExists) ? $this->country->get('lang')->get('abbr') : config('app.locale'));
            Config::set('country.code', $this->country->get('code'));
            Config::set('country.name', $this->country->get('name'));
			Config::set('country.currency', $this->country->get('currency_code'));
            Config::set('country.admin_type', $this->country->get('admin_type'));
            Config::set('country.admin_field_active', $this->country->get('admin_field_active'));
        }
        // Config : Currency
        if (!$this->country->isEmpty() && $this->country->has('currency') && !empty($this->country->get('currency'))) {
            Config::set('currency', $this->country->get('currency')->toArray());
        }
        // Config : Set TimeZome
        if (!$this->country->isEmpty() and $this->country->has('timezone') and !empty($this->country->get('timezone'))) {
            Config::set('timezone.id', $this->country->get('timezone')->time_zone_id);
        }
        // Config : Language Code
        if (!$this->lang->isEmpty()) {
            session(['language_code' => $this->lang->get('abbr')]);
            Config::set('lang.abbr', $this->lang->get('abbr'));
            Config::set('lang.locale', $this->lang->get('locale'));
			Config::set('lang.direction', $this->lang->get('direction'));
            Config::set('lang.russian_pluralization', $this->lang->get('russian_pluralization'));
        }


        // Share vars to views
        view()->share('lang', $lang);
        view()->share('user', $this->user);
        view()->share('country', $this->country);
        view()->share('ipCountry', $this->ipCountry);
    }

	/**
	 * Set all the front-end settings
	 */
    public function setFrontSettings()
	{
        // Cache Expiration Time /==============================================================
		$this->cacheExpiration = (int)config('settings.app_cache_expiration');
        view()->share('cacheExpiration', $this->cacheExpiration);

		// Ads photos number
		$postsPicturesNumber = (int)config('settings.posts_pictures_number');
		if ($postsPicturesNumber >= 1 and $postsPicturesNumber <= 20) {
			$this->postsPicturesNumber = $postsPicturesNumber;
		}
		if ($postsPicturesNumber > 20) {
			$this->postsPicturesNumber = 20;
		}
		view()->share('postsPicturesNumber', $this->postsPicturesNumber);


		// Default language for Bots /==========================================================
		$crawler = new CrawlerDetect();
		if ($crawler->isCrawler()) {
			$lang = $this->country->get('lang');
			if ($lang->has('abbr')) {
				$this->lang = $lang;
			}
			view()->share('lang', $this->lang);
			App::setLocale($this->lang->get('abbr'));
		}

		// Set Local
		if (!$this->lang->isEmpty()) {
			setlocale(LC_ALL, $this->lang->get('locale'));
		}

		// Set Language for Countries /=========================================================
		$this->country = CountryLocalizationHelper::trans($this->country, $this->lang->get('abbr'));
		view()->share('country', $this->country);

		// DNS Prefetch meta tags
		$dnsPrefetch = [
			'//fonts.googleapis.com',
			'//graph.facebook.com',
			'//google.com',
			'//apis.google.com',
			'//ajax.googleapis.com',
			'//www.google-analytics.com',
			'//pagead2.googlesyndication.com',
			'//gstatic.com',
			'//cdn.api.twitter.com',
			'//oss.maxcdn.com',
		];
		view()->share('dnsPrefetch', $dnsPrefetch);


		// SEO /================================================================================
        $title = getMetaTag('title', 'home');
        $description = getMetaTag('description', 'home');
        $keywords = getMetaTag('keywords', 'home');

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);


		// Open Graph /=========================================================================
		$this->og = new OpenGraph();
		$locale = $this->lang->has('locale') ? $this->lang->get('locale') : 'en_US';
		$this->og->siteName(config('settings.app_name'))->locale($locale)->type('website')->url(url()->current());
		view()->share('og', $this->og);


		// CSRF Control /=======================================================================
		// CSRF - Some JavaScript frameworks, like Angular, do this automatically for you.
		// It is unlikely that you will need to use this value manually.
		setcookie('X-XSRF-TOKEN', csrf_token(), $this->cookieExpiration, '/', getDomain());


		// Skin selection /=====================================================================
		if (Input::filled('skin')) {
			if (file_exists(public_path() . '/assets/css/skins/' . Input::get('skin') . '.css')) {
				config(['app.skin' => Input::get('skin')]);
			} else {
				//config(['app.skin' => config('settings.app_skin')]);
                config(['app.skin' => 'skin-default']);
			}
		} else {
			config(['app.skin' => config('settings.app_skin', 'skin-default')]);
		}

		// Reset session Post view counter /====================================================
		if (! str_contains(Route::currentRouteAction(), 'Post\DetailsController')) {
			if (session()->has('postIsVisited')) {
				session()->forget('postIsVisited');
			}
		}

        // Pages Menu /=========================================================================
        $pages = Cache::remember('pages.' . config('app.locale') . '.menu', $this->cacheExpiration, function () {
            $pages = Page::trans()->where('excluded_from_footer', '!=', 1)->orderBy('lft', 'ASC')->get();
            return $pages;
        });
        view()->share('pages', $pages);

        // Get all installed plugins name /=====================================================
        view()->share('installedPlugins', array_keys(plugin_installed_list()));
		
		
		// Get all Countries /==================================================================
		$countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
		$cols = round($countries->count() / 4, 0, PHP_ROUND_HALF_EVEN);
		$cols = ($cols > 0) ? $cols : 1; // Fix array_chunk with 0
		view()->share('countryCols', $countries->chunk($cols)->all());
		
		
		// Get Payment Methods /================================================================
		$this->paymentMethods = Cache::remember('paymentMethods.all', $this->cacheExpiration, function () {
			$paymentMethods = PaymentMethod::where(function ($query) {
				$query->whereRaw('FIND_IN_SET("' . $this->country->get('icode') . '", LOWER(countries)) > 0')
					  ->orWhereNull('countries');
			})->orderBy('lft')->get();
			
			return $paymentMethods;
		});
		$this->countPaymentMethods = $this->paymentMethods->count();
		view()->share('paymentMethods', $this->paymentMethods);
		view()->share('countPaymentMethods', $this->countPaymentMethods);
		
		
		// Bind JS vars to view /===============================================================
		JavaScript::put([
			'siteUrl'      => url('/'),
			'languageCode' => config('app.locale'),
			'countryCode'  => config('country.code', 0),
		]);
	}
}

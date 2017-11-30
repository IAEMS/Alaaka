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

namespace App\Http\Controllers\Post\Traits;

use App\Helpers\Arr;
use App\Helpers\Ip;
use App\Http\Requests\PostRequest;
use App\Models\Company;
use App\Models\Post;
use App\Models\City;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Torann\LaravelMetaTags\Facades\MetaTag;

trait EditTrait
{
	/**
	 * Show the form the create a new ad post.
	 *
	 * @param $postIdOrToken
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getUpdateForm($postIdOrToken)
	{
		$data = [];
		
		// Get Post
		if (getSegment(2) == 'create') {
			if (!Session::has('tmpPostId')) {
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('user_id', $this->user->id)->where('id', $postIdOrToken)->first();
		}
		
		if (empty($post)) {
			abort(404);
		}
		view()->share('post', $post);
		
		// Get the Post's Company
		if (!empty($post->company_id)) {
			$data['postCompany'] = Company::find($post->company_id);
			view()->share('postCompany', $data['postCompany']);
		}
		
		// Get the Post's Administrative Division
		if (config('country.admin_field_active') == 1 && in_array(config('country.admin_type'), ['1', '2'])) {
			// Get the Post's City
			$city = City::find($post->city_id);
			if (!empty($city)) {
				$adminType = config('country.admin_type');
				$adminModel = '\App\Models\SubAdmin' . $adminType;
				
				// Get the City's Administrative Division
				$admin = $adminModel::where('code', $city->{'subadmin' . $adminType . '_code'})->first();
				if (!empty($admin)) {
					view()->share('admin', $admin);
				}
			}
		}
		
		// Meta Tags
		MetaTag::set('title', t('Update My Ad'));
		MetaTag::set('description', t('Update My Ad'));
		
		return view('post.edit', $data);
	}
	
	/**
	 * Update the Post
	 *
	 * @param $postIdOrToken
	 * @param PostRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postUpdateForm($postIdOrToken, PostRequest $request)
	{
		// Get Post
		if (getSegment(2) == 'create') {
			if (!Session::has('tmpPostId')) {
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('user_id', $this->user->id)->where('id', $postIdOrToken)->first();
		}
		
		if (empty($post)) {
			abort(404);
		}
		
		// Get the Post's City
		$city = City::find($request->input('city', 0));
		if (empty($city)) {
			flash(t("Posting Ads was disabled for this time. Please try later. Thank you."))->error();
			
			return back()->withInput($request->except('company.logo'));
		}
		
		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.email_verification') == 1 && $request->filled('email') && $request->input('email') != $post->email;
		$phoneVerificationRequired = config('settings.phone_verification') == 1 && $request->filled('phone') && $request->input('phone') != $post->phone;
		
		// Get or Create Company
		if ($request->filled('company_id') && !empty($request->input('company_id'))) {
			// Get the User's Company
			$company = Company::where('id', $request->input('company_id'))->where('user_id', Auth::user()->id)->first();
		} else {
			$companyInfo = $request->input('company');
			if (!isset($companyInfo['country_code']) || empty($companyInfo['country_code'])) {
				$companyInfo += ['country_code' => config('country.code')];
			}
			
			// Logged Users
			if (!isset($companyInfo['user_id']) || empty($companyInfo['user_id'])) {
				$companyInfo += ['user_id' => Auth::user()->id];
			}
			
			// Store the User's Company
			$company = new Company($companyInfo);
			$company->save();
			
			// Save the Company's Logo
			if ($request->hasFile('company.logo')) {
				$company->logo = $request->file('company.logo');
				$company->save();
			}
		}
		
		// Return error if company is not set
		if (empty($company)) {
			flash(t("Please select a company or 'New Company' to create one."))->error();
			
			return back()->withInput($request->except('company.logo'));
		}
		
		// Update the Post
		// $post->country_code = $request->input('country_code');
		$post->category_id = $request->input('category');
		$post->post_type_id = $request->input('post_type');
		$post->company_id = (isset($company->id)) ? $company->id : 0;
		$post->company_name = (isset($company->name)) ? $company->name : null;
		$post->logo = (isset($company->logo)) ? $company->logo : null;
		$post->company_description = (isset($company->description)) ? $company->description : null;
		$post->title = $request->input('title');
		$post->description = $request->input('description');
		$post->tags = $request->input('tags');
		$post->salary_min = $request->input('salary_min');
		$post->salary_max = $request->input('salary_max');
		$post->salary_type_id = $request->input('salary_type');
		$post->negotiable = $request->input('negotiable');
		$post->start_date = $request->input('start_date');
		$post->contact_name = $request->input('contact_name');
		$post->email = $request->input('email');
		$post->phone = $request->input('phone');
		$post->phone_hidden = $request->input('phone_hidden');
		$post->city_id = $request->input('city');
		$post->lat = $city->latitude;
		$post->lon = $city->longitude;
		$post->application_url = $request->input('application_url');
		$post->ip_addr = Ip::get();
		
		// Email verification key generation
		if ($emailVerificationRequired) {
			$post->email_token = md5(microtime() . mt_rand());
			$post->verified_email = 0;
		}
		
		// Phone verification key generation
		if ($phoneVerificationRequired) {
			$post->phone_token = mt_rand(100000, 999999);
			$post->verified_phone = 0;
		}
		
		// Save Post
		$post->save();
		
		// Get Next URL
		$creationPath = (getSegment(2) == 'create') ? 'create/' : '';
		if (
			isset($this->data['countPackages']) &&
			isset($this->data['countPaymentMethods']) &&
			$this->data['countPackages'] > 0 &&
			$this->data['countPaymentMethods'] > 0
		) {
			flash(t("Your ad has been updated."))->success();
			$nextStepUrl = config('app.locale') . '/posts/' . $creationPath . $postIdOrToken . '/packages';
		} else {
			if (getSegment(1) == 'create') {
				$request->session()->flash('message', t('Your ad has been created.'));
				$nextStepUrl = config('app.locale') . '/posts/create/' . $postIdOrToken . '/finish';
			} else {
				flash(t("Your ad has been updated."))->success();
				$nextStepUrl = config('app.locale') . '/' . slugify($post->title) . '/' . $postIdOrToken . '.html';
			}
		}
		
		// Send Email Verification message
		if ($emailVerificationRequired) {
			$this->sendVerificationEmail($post);
			$this->showReSendVerificationEmailLink($post, 'post');
		}
		
		// Send Phone Verification message
		if ($phoneVerificationRequired) {
			// Save the Next URL before verification
			session(['itemNextUrl' => $nextStepUrl]);
			
			$this->sendVerificationSms($post);
			$this->showReSendVerificationSmsLink($post, 'post');
			
			// Go to Phone Number verification
			$nextStepUrl = config('app.locale') . '/verify/post/phone/';
		}
		
		// Redirection
		return redirect($nextStepUrl);
	}
}

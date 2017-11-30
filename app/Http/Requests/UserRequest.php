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

namespace App\Http\Requests;

use App\Models\Resume;
use Illuminate\Support\Facades\Auth;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Check if these fields has changed
        $emailChanged = ($this->input('email') != Auth::user()->email);
        $phoneChanged = ($this->input('phone') != Auth::user()->phone);
        $usernameChanged = ($this->filled('username') && $this->input('username') != Auth::user()->username);
	
		// Country Exception
		$countryCode = $this->input('country', config('country.code'));
		if ($countryCode == 'UK') {
			$countryCode = 'GB';
		}
    
        // Validation Rules
        $rules = [];
        if (empty(Auth::user()->user_type_id) || Auth::user()->user_type_id == 0) {
            $rules['user_type'] = 'required|not_in:0';
        } else {
            $rules['gender']    = 'required|not_in:0';
            $rules['name']      = 'required|max:100';
            $rules['phone']     = 'required|phone:' . $countryCode . ',mobile|max:20';
            $rules['email']     = 'required|email|whitelist_email|whitelist_domain';
            $rules['username']  = 'valid_username|allowed_username|between:3,100';
        
            if ($phoneChanged) {
                $rules['phone'] = 'unique:users,phone|' . $rules['phone'];
            }
            if ($emailChanged) {
                $rules['email'] = 'unique:users,email|' . $rules['email'];
            }
            if ($usernameChanged) {
                $rules['username'] = 'required|unique:users,username|' . $rules['username'];
            }
        }
        
        return $rules;
    }
    
    /**
     * @return array
     */
    public function messages()
    {
        $messages = [];
        
        return $messages;
    }
}

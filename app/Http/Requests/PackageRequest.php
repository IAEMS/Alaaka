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

use App\Models\Package;
use App\Models\PaymentMethod;

class PackageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
    
        // Get all the Packages & Payment Methods in the database
        $countPackages = Package::where('translation_lang', config('app.locale'))->count();
        $countPaymentMethods = PaymentMethod::count();
    
        // Check if 'package' & 'payment_method' are required
        if ($countPackages > 0 && $countPaymentMethods > 0) {
            // Require 'package' if Packages are available
            $rules['package'] = 'required';
            
            // Require 'payment_method' if the Package price > 0
            if ($this->filled('package')) {
                $package = Package::find($this->input('package'));
                if (!empty($package) && $package->price > 0) {
                    $rules['payment_method'] = 'required|not_in:0';
                }
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

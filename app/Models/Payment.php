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

namespace App\Models;


use App\Models\Scopes\StrictActiveScope;

class Payment extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    // public $timestamps = false;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'package_id', 'payment_method_id', 'transaction_id', 'active'];
    
    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    // protected $hidden = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	protected static function boot()
	{
		parent::boot();
		
		static::addGlobalScope(new StrictActiveScope());
	}
	
    public function getPostTitleHtml()
    {
		$out = '#' . $this->post_id;
        if ($this->post) {
			$out .=  ' | <a href="/' . config('app.locale') . '/' . slugify($this->post->title) . '/' . $this->post_id . '.html" target="_blank">' . $this->post->title . '</a>';
        }
	
		return $out;
    }
    
    public function getPackageNameHtml()
    {
        $package = Package::transById($this->package_id);
        if (!empty($package)) {
            return $package->name . ' (' . $package->price . ' ' . $package->currency_code . ')';
        } else {
            return $this->package_id;
        }
    }

    public function getPaymentMethodNameHtml()
    {
        $paymentMethod = PaymentMethod::find($this->payment_method_id);
        if (!empty($paymentMethod)) {
			if ($paymentMethod->name == 'offlinepayment') {
				return trans('offlinepayment::messages.Offline Payment');
			} else {
				return $paymentMethod->display_name;
			}
        } else {
            return '--';
        }
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
    
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

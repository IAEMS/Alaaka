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

use App\Models\Traits\TranslatedTrait;
use App\Observer\MetaTagObserver;

class MetaTag extends BaseModel
{
    use TranslatedTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meta_tags';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    protected $appends = ['tid'];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;
    
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
    protected $fillable = ['page', 'title', 'description', 'keywords', 'translation_lang', 'translation_of', 'active'];
    public $translatable = ['title', 'description', 'keywords'];
    
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
	
		MetaTag::observe(MetaTagObserver::class);
    }
	
	public function getPageHtml()
	{
		$entries = [
			'home'      => 'Homepage',
			'register'  => 'Register',
			'login'     => 'Login',
			'create'    => 'Ads Creation',
			'countries' => 'Countries',
			'contact'   => 'Contact',
			'sitemap'   => 'Sitemap',
			'password'  => 'Password',
		];
		
		// Get Page Name
		$out = $this->page;
		if (isset($entries[$this->page])) {
			$editUrl = url(config('larapen.admin.route_prefix', 'admin') . '/meta_tag/' . $this->id . '/edit');
			$out = '<a href="' . $editUrl . '">' . $entries[$this->page] . '</a>';
		}
		
		return $out;
	}
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    
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

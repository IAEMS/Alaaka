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

use App\Helpers\Geo;
use App\Models\Traits\CountryTrait;
use App\Observer\SubAdmin1Observer;

class SubAdmin1 extends BaseModel
{
    use CountryTrait;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subadmin1';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';
    public $incrementing = false;
    
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
    protected $fillable = ['country_code', 'code', 'name', 'asciiname', 'active'];
    
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
	
		SubAdmin1::observe(SubAdmin1Observer::class);
    }
    
    public function getNameHtml()
    {
        $out = '';
        
        $currentUrl = preg_replace('#/(search)$#', '', url()->current());
        $editUrl = $currentUrl . '/' . $this->code . '/edit';
        $admin2Url = url(config('larapen.admin.route_prefix', 'admin') . '/loc_admin1/' . $this->code . '/loc_admin2');
        $cityUrl = url(config('larapen.admin.route_prefix', 'admin') . '/loc_admin1/' . $this->code . '/city');
        
        $out .= '<a href="' . $editUrl . '" style="float:left;">' . $this->asciiname . '</a>';
        $out .= ' ';
        $out .= '<span style="float:right;">';
        $out .= '<a class="btn btn-xs btn-primary" href="' . $admin2Url . '"><i class="fa fa-folder"></i> ' . mb_ucfirst(__t('admin. divisions 2')) . '</a>';
        $out .= ' ';
        $out .= '<a class="btn btn-xs btn-primary" href="' . $cityUrl . '"><i class="fa fa-folder"></i> ' . mb_ucfirst(__t('cities')) . '</a>';
        $out .= '</span>';
        
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
    public function getIdAttribute($value)
    {
        return $this->attributes['code'];
    }
    
    public function getNameAttribute($value)
    {
        return Geo::getShortName($value);
    }
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

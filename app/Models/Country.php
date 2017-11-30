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

use App\Models\Scopes\ActiveScope;
use App\Observer\CountryObserver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Prologue\Alerts\Facades\Alert;

class Country extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $appends = ['icode'];
    protected $visible = ['code', 'name', 'asciiname', 'icode', 'currency_code', 'phone', 'languages', 'currency', 'background_image', 'admin_type', 'admin_field_active'];
    
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
    protected $fillable = [
        'code',
        'name',
        'asciiname',
        'capital',
        'continent_code',
        'tld',
        'currency_code',
        'phone',
        'languages',
		'background_image',
        'admin_type',
        'admin_field_active',
        'active'
    ];
    
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
    protected $dates = ['created_at', 'created_at'];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
	
		Country::observe(CountryObserver::class);
		
        static::addGlobalScope(new ActiveScope());
    }
    
    public function getNameHtml()
    {
        $out = '';
        
        $editUrl = url(config('larapen.admin.route_prefix', 'admin') . '/country/' . $this->id . '/edit');
        $admin1Url = url(config('larapen.admin.route_prefix', 'admin') . '/country/' . $this->id . '/loc_admin1');
        $cityUrl = url(config('larapen.admin.route_prefix', 'admin') . '/country/' . $this->id . '/city');
        
        $out .= '<a href="' . $editUrl . '" style="float:left;">' . $this->asciiname . '</a>';
        $out .= ' ';
        $out .= '<span style="float:right;">';
        $out .= '<a class="btn btn-xs btn-primary" href="' . $admin1Url . '"><i class="fa fa-folder"></i> ' . mb_ucfirst(__t('admin. divisions 1')) . '</a>';
        $out .= ' ';
        $out .= '<a class="btn btn-xs btn-primary" href="' . $cityUrl . '"><i class="fa fa-folder"></i> ' . mb_ucfirst(__t('cities')) . '</a>';
        $out .= '</span>';
        
        return $out;
    }

	public function getActiveHtml()
	{
		if (!isset($this->active)) return false;

        return installAjaxCheckboxDisplay($this->{$this->primaryKey}, $this->getTable(), 'active', $this->active);
	}
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }
    public function continent()
    {
        return $this->belongsTo(Continent::class, 'continent_code', 'code');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        if (Request::segment(1) == config('larapen.admin.route_prefix', 'admin')) {
			if (str_contains(Route::currentRouteAction(), 'Admin\CountryController')) {
				return $query;
			}
        }
        
        return $query->where('active', 1);
    }
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getIcodeAttribute()
    {
        return strtolower($this->attributes['code']);
    }
    
    public function getIdAttribute($value)
    {
        return $this->attributes['code'];
    }
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
	public function setBackgroundImageAttribute($value)
	{
		$attribute_name = 'background_image';
		$destination_path = 'app/logo';
		
		// If the image was erased
		if (empty($value)) {
			// delete the image from disk
			if (!str_contains($this->{$attribute_name}, config('larapen.core.picture.default'))) {
				Storage::delete($this->{$attribute_name});
			}
			
			// set null in the database column
			$this->attributes[$attribute_name] = null;
			
			return false;
		}
		
		// If a base64 was sent, store it in the db
		if (starts_with($value, 'data:image')) {
			try {
				// Get file extension
				$extension = (is_png($value)) ? 'png' : 'jpg';
				
				// Make the image (Size: 2000x1000)
				if (exifExtIsEnabled()) {
					$image = Image::make($value)->orientate()->resize(2000, 1000, function ($constraint) {
						$constraint->aspectRatio();
					})->encode($extension, 100);
				} else {
					$image = Image::make($value)->resize(2000, 1000, function ($constraint) {
						$constraint->aspectRatio();
					})->encode($extension, 100);
				}
			} catch (\Exception $e) {
				Alert::error($e->getMessage())->flash();
				$this->attributes[$attribute_name] = null;
				
				return false;
			}
			
			// Save the file on server
			$filename = uniqid('header-') . '.' . $extension;
			Storage::put($destination_path . '/' . $filename, $image->stream());
			
			// Save the path to the database
			$this->attributes[$attribute_name] = $destination_path . '/' . $filename;
		} else {
			// Get, Transform and Save the path to the database
			$this->attributes[$attribute_name] = $destination_path . last(explode($destination_path, $value));
		}
	}
}

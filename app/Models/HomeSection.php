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
use App\Observer\HomeSectionObserver;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Prologue\Alerts\Facades\Alert;

class HomeSection extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'home_sections';
    
    protected $fakeColumns = ['options'];
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
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
    protected $fillable = ['name', 'method', 'options', 'parent_id', 'lft', 'rgt', 'depth', 'active'];
    
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
    
    protected $casts = [
        'options' => 'array',
    ];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
	
		HomeSection::observe(HomeSectionObserver::class);
		
        static::addGlobalScope(new ActiveScope());
    }
    
    public function getNameHtml()
    {
        $out = '';
        
        $url = url(config('larapen.admin.route_prefix', 'admin') . '/home_section/' . $this->id . '/edit');
        $out .= '<a href="' . $url . '">' . $this->name . '</a>';
        
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
	public function setOptionsAttribute($value)
	{
		$attribute_name = 'background_image';
		$destination_path = 'app/logo';
		
		// If 'background_image' option doesn't exist, don't make the upload and save data
		if (!isset($value[$attribute_name])) {
			$this->attributes['options'] = json_encode($value);
			
			return false;
		}
		
		// If the image was erased
		if ($value[$attribute_name] == null) {
			// Delete the image from disk
			if (isset($this->options) && isset($this->options[$attribute_name])) {
				Storage::delete($this->options[$attribute_name]);
			}
			
			// Set null in the database column
			$value[$attribute_name] = null;
			$this->attributes['options'] = json_encode($value);
		}
		
		// If a base64 was sent, store it in the db
		if (starts_with($value[$attribute_name], 'data:image')) {
			try {
				// Get file extension
				$extension = (is_png($value[$attribute_name])) ? 'png' : 'jpg';
				
				// Make the image (Size: 2000x1000)
				if (exifExtIsEnabled()) {
					$image = Image::make($value[$attribute_name])->orientate()->resize(2000, 1000, function ($constraint) {
						$constraint->aspectRatio();
					})->encode($extension, 100);
				} else {
					$image = Image::make($value[$attribute_name])->resize(2000, 1000, function ($constraint) {
						$constraint->aspectRatio();
					})->encode($extension, 100);
				}
			} catch (\Exception $e) {
				Alert::error($e->getMessage())->flash();
				$value[$attribute_name] = null;
				$this->attributes['options'] = json_encode($value);
				
				return false;
			}
			
			// Save the file on server
			$filename = uniqid('header-') . '.' . $extension;
			Storage::put($destination_path . '/' . $filename, $image->stream());
			
			// Save the path to the database
			$value[$attribute_name] = $destination_path . '/' . $filename;
			$this->attributes['options'] = json_encode($value);
		} else {
			// Get, Transform and Save the path to the database
			$value[$attribute_name] = $destination_path . last(explode($destination_path, $value[$attribute_name]));
			$this->attributes['options'] = json_encode($value);
		}
	}
}

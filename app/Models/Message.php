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

use App\Observer\MessageObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Message extends BaseModel
{
	use Notifiable;
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';
    
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
    protected $fillable = ['post_id', 'name', 'email', 'phone', 'message', 'filename'];
    
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
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
	
		Message::observe(MessageObserver::class);
    }
	
	public function routeNotificationForMail()
	{
		return $this->email;
	}
	
	public function routeNotificationForNexmo()
	{
		$phone = phoneFormatInt($this->phone, config('country.code'));
		$phone = setPhoneSign($phone, 'nexmo');
		
		return $phone;
	}
	
	public function routeNotificationForTwilio()
	{
        $phone = phoneFormatInt($this->phone, config('country.code'));
		$phone = setPhoneSign($phone, 'twilio');
        
        return $phone;
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
    public function getFilenameFromOldPath()
    {
        if (!isset($this->attributes) || !isset($this->attributes['filename'])) {
            return null;
        }

        $value = $this->attributes['filename'];

        // Fix path
        $value = str_replace('uploads/resumes/', '', $value);
        $value = str_replace('resumes/', '', $value);
        $value = 'resumes/' . $value;

        if (!Storage::exists($value)) {
            return null;
        }

        // $value = 'uploads/' . $value;

        return $value;
    }

    public function getFilenameAttribute()
    {
        $value = $this->getFilenameFromOldPath();
        if (!empty($value)) {
            return $value;
        }

        if (!isset($this->attributes) || !isset($this->attributes['filename'])) {
            return null;
        }

        $value = $this->attributes['filename'];
        // $value = 'uploads/' . $value;

        return $value;
    }
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setFilenameAttribute($value)
    {
		$field_name = 'resume.filename';
        $attribute_name = 'filename';
        $disk = config('filesystems.default');
	
        // Set the right field name
		$request = \Request::instance();
		if (!$request->hasFile($field_name)) {
			$field_name = $attribute_name;
		}
	
		// Don't make an upload for Message->filename for logged users
		if (Auth::check()) {
			$this->attributes[$attribute_name] = $value;
		
			return $this->attributes[$attribute_name];
		}

        // Get ad details
        $post = Post::find($this->post_id);
        if (empty($post)) {
            $this->attributes[$attribute_name] = null;
            return false;
        }

        // Path
        $destination_path = 'files/' . strtolower($post->country_code) . '/' . $post->id . '/applications';

        // Upload
        $this->uploadFileToDiskCustom($value, $field_name, $attribute_name, $disk, $destination_path);
    }
}

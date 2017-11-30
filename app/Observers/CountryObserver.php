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

namespace App\Observer;

use App\Models\City;
use App\Models\Country;
use App\Models\Post;
use App\Models\SubAdmin1;
use App\Models\SubAdmin2;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CountryObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Country $country
     * @return void
     */
    public function deleting(Country $country)
    {
		// Remove background_image files (if exists)
		if (!empty($country->background_image)) {
			$filename = str_replace('uploads/', '', $country->background_image);
			if (!str_contains($filename, config('larapen.core.picture.default'))) {
				Storage::delete($filename);
			}
		}
		
        // Delete all Geonames entries
        $deletedRows = SubAdmin1::countryOf($country->code)->delete();
        $deletedRows = SubAdmin2::countryOf($country->code)->delete();
        $deletedRows = City::countryOf($country->code)->delete();
    
        // Delete all Posts entries
        $posts = Post::countryOf($country->code)->get();
        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                $post->delete();
            }
        }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  Country $country
     * @return void
     */
    public function saved(Country $country)
    {
        // Removing Entries from the Cache
        $this->clearCache($country);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Country $country
     * @return void
     */
    public function deleted(Country $country)
    {
        // Removing Entries from the Cache
        $this->clearCache($country);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $country
     */
    private function clearCache($country)
    {
        Cache::flush();
    }
}

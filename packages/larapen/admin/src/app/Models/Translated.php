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

namespace Larapen\Admin\app\Models;

use Illuminate\Support\Facades\Request;

trait Translated
{
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getTranslationOfAttribute()
    {
        $translationOf = (isset($this->attributes['translation_of'])) ? $this->attributes['translation_of'] : null;
        $entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : $translationOf;

        // Admin panel
        if (Request::segment(1) == config('larapen.admin.route_prefix', 'admin')) {
            return $translationOf;
        }

        // FrontOffice
        if (!empty($translationOf)) {
            if ($this->attributes['translation_lang'] == config('applang.abbr')) {
                return $entityId;
            } else {
                return $translationOf;
            }
        } else {
            return $entityId;
        }
    }

    public function getTidAttribute()
    {
        $translationOf = (isset($this->attributes['translation_of'])) ? $this->attributes['translation_of'] : null;
        $entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : $translationOf;

        // Admin panel
        if (Request::segment(1) == config('larapen.admin.route_prefix', 'admin')) {
            return $translationOf;
        }

        // FrontOffice
        if (!empty($translationOf)) {
            if ($this->attributes['translation_lang'] == config('applang.abbr')) {
                return $entityId;
            } else {
                return $translationOf;
            }
        } else {
            return $entityId;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setTranslationOfAttribute($value)
    {
        $entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : null;

        if (empty($value)) {
            if ($this->attributes['translation_lang'] == config('applang.abbr')) {
                $this->attributes['translation_of'] = $entityId;
            } else {
                $this->attributes['translation_of'] = $value;
            }
        } else {
            $this->attributes['translation_of'] = $value;
        }
    }
}
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

use App\Models\Traits\VerifiedTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Larapen\Admin\app\Models\Crud;

class BaseUser extends Authenticatable
{
    use Crud, VerifiedTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
    
    // ...
}

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

use App\Models\Package;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;

class PackageObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Package $package
     * @return void
     */
    public function deleting(Package $package)
    {
        // Delete all translated entries
        $package->translated()->delete();
    
        // Delete all payment entries in database
        $payments = Payment::where('package_id', $package->id)->get();
        if (!empty($payments)) {
            foreach ($payments as $payment) {
                $payment->delete();
            }
        }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  Package $package
     * @return void
     */
    public function saved(Package $package)
    {
        // Removing Entries from the Cache
        $this->clearCache($package);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Package $package
     * @return void
     */
    public function deleted(Package $package)
    {
        // Removing Entries from the Cache
        $this->clearCache($package);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $package
     */
    private function clearCache($package)
    {
        Cache::flush();
    }
}

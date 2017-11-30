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

use App\Models\Message;
use Illuminate\Support\Facades\Storage;

class MessageObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Message $message
     * @return void
     */
    public function deleting(Message $message)
    {
        // Delete all files
        if (!empty($message->filename)) {
            $filename = str_replace('uploads/', '', $message->filename);
            Storage::delete($filename);
        }
    }
}

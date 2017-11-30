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

namespace App\Http\Controllers\Admin;

use Larapen\Admin\app\Http\Controllers\PanelController;
use Larapen\Admin\app\Http\Requests\Request as StoreRequest;
use Larapen\Admin\app\Http\Requests\Request as UpdateRequest;

class BlacklistController extends PanelController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->xPanel->setModel('App\Models\Blacklist');
        $this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/blacklist');
        $this->xPanel->setEntityNameStrings(__t('blacklist'), __t('blacklists'));

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        // COLUMNS
        $this->xPanel->addColumn([
            'name'  => 'id',
            'label' => "ID",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'type',
            'label' => __t("Type"),
        ]);
        $this->xPanel->addColumn([
            'name'  => 'entry',
            'label' => __t("Entry"),
        ]);

        // FIELDS
        $this->xPanel->addField([
            'name'  => 'type',
            'label' => __t("Type"),
            'type'  => 'enum',
        ]);
        $this->xPanel->addField([
            'name'       => 'entry',
            'label'      => __t("Entry"),
            'type'       => 'text',
            'attributes' => [
                'placeholder' => __t("Entry"),
            ],
        ]);
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}

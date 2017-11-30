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
use App\Http\Requests\Admin\MetaTagRequest as StoreRequest;
use App\Http\Requests\Admin\MetaTagRequest as UpdateRequest;

class MetaTagController extends PanelController
{
	public function __construct()
	{
		parent::__construct();
		
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\MetaTag');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/meta_tag');
		$this->xPanel->setEntityNameStrings(__t('meta tag'), __t('meta tags'));
		$this->xPanel->enableDetailsRow();
		$this->xPanel->allowAccess(['details_row']);
		
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
			'name'          => 'page',
			'label'         => __t("Page"),
			'type'          => 'model_function',
			'function_name' => 'getPageHtml',
		]);
		$this->xPanel->addColumn([
			'name'  => 'title',
			'label' => __t("Title"),
		]);
		$this->xPanel->addColumn([
			'name'  => 'description',
			'label' => __t("Description"),
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => __t("Active"),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'        => 'page',
			'label'       => __t("Page"),
			'type'        => 'select2_from_array',
			'options'     => $this->pages(),
			'allows_null' => false,
		]);
		$this->xPanel->addField([
			'name'       => 'title',
			'label'      => __t("Title"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => __t("Title"),
			],
			'hint'       => __t('You can use dynamic variables such as {app_name} and {country} - e.g. {app_name} will be replaced with the name of your website and {country} by the selected country.'),
		]);
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => __t("Description"),
			'type'       => 'textarea',
			'attributes' => [
				'placeholder' => __t("Description"),
			],
			'hint'       => __t('You can use dynamic variables such as {app_name} and {country} - e.g. {app_name} will be replaced with the name of your website and {country} by the selected country.'),
		]);
		$this->xPanel->addField([
			'name'       => 'keywords',
			'label'      => __t("Keywords"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => __t("Keywords"),
			],
			'hint'       => __t('You can use dynamic variables such as {app_name} and {country} - e.g. {app_name} will be replaced with the name of your website and {country} by the selected country.'),
		]);
		$this->xPanel->addField([
			'name'  => 'active',
			'label' => __t("Active"),
			'type'  => 'checkbox',
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
	
	public function pages()
	{
		$entries = [
			'home'      => 'Homepage',
			'register'  => 'Register',
			'login'     => 'Login',
			'create'    => 'Ads Creation',
			'countries' => 'Countries',
			'contact'   => 'Contact',
			'sitemap'   => 'Sitemap',
			'password'  => 'Password',
		];
		
		return $entries;
	}
}

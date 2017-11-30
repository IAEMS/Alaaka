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

use App\Models\Language;
use Larapen\Admin\app\Http\Controllers\PanelController;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;

class HomeSectionController extends PanelController
{
    public function __construct()
    {
        parent::__construct();
        
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->xPanel->setModel('App\Models\HomeSection');
        $this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/home_section');
        $this->xPanel->setEntityNameStrings(__t('home section'), __t('home sections'));
        $this->xPanel->denyAccess(['create', 'delete']);
        $this->xPanel->allowAccess(['reorder']);
        $this->xPanel->enableReorder('name', 1);
        $this->xPanel->enableAjaxTable();
        $this->xPanel->orderBy('lft', 'ASC');
        
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
            'name'          => 'name',
            'label'         => __t("Name"),
            'type'          => 'model_function',
            'function_name' => 'getNameHtml',
        ]);
        $this->xPanel->addColumn([
            'name'          => 'active',
            'label'         => __t("Active"),
            'type'          => 'model_function',
            'function_name' => 'getActiveHtml',
        ]);
        
        // FIELDS
        $this->xPanel->addField([
            'name'       => 'name',
            'label'      => __t("Name"),
            'type'       => 'text',
            'attributes' => [
                'placeholder' => __t("Name"),
                'disabled'    => 'disabled',
            ],
        ]);
        
        $section = $this->xPanel->model->find(Request::segment(3));
        if (!empty($section)) {
			// getSearchForm
			if (in_array($section->method, ['getSearchForm'])) {
				$enableCustomFormField = [
					'name'     => 'enable_form_area_customization',
					'label'    => __t("Enable search form area customization"),
					'fake'     => true,
					'store_in' => 'options',
					'type'     => 'checkbox',
					'hint'     => __t("NOTE: The options below require to enable the search form area customization."),
				];
				$this->xPanel->addField($enableCustomFormField);
				
				$backgroundColorField = [
					'name'                => 'background_color',
					'label'               => __t("Background Color"),
					'fake'                => true,
					'store_in'            => 'options',
					'type'                => 'color_picker',
					'colorpicker_options' => [
						'customClass' => 'custom-class',
					],
					'attributes'          => [
						'placeholder' => "#444",
					],
					'hint'                => __t("Enter a RGB color code."),
				];
				$this->xPanel->addField($backgroundColorField);
				
				$backgroundImageField = [
					'name'     => 'background_image',
					'label'    => __t("Background Image"),
					'fake'     => true,
					'store_in' => 'options',
					'type'     => 'image',
					'upload'   => true,
					'disk'     => 'uploads',
					'hint'     => __t('Choose a picture from your computer.') . '<br>' . __t('You can set a background image by country in Admin panel -> International -> Countries -> [Edit] -> Background Image'),
				];
				$this->xPanel->addField($backgroundImageField);
				
				$heightField = [
					'name'     => 'height',
					'label'    => __t("Height"),
					'fake'     => true,
					'store_in' => 'options',
					'attributes'          => [
						'placeholder' => "450px",
					],
					'hint'     => __t('Enter a value greater than 50px.') . ' (' . __t('Example: 400px') . ')',
				];
				$this->xPanel->addField($heightField);
				
				$parallaxField = [
					'name'     => 'parallax',
					'label'    => __t("Enable Parallax Effect"),
					'fake'     => true,
					'store_in' => 'options',
					'type'     => 'checkbox',
				];
				$this->xPanel->addField($parallaxField);
				
				$hideFormField = [
					'name'     => 'hide_form',
					'label'    => __t("Hide the Form"),
					'fake'     => true,
					'store_in' => 'options',
					'type'     => 'checkbox',
				];
				$this->xPanel->addField($hideFormField);
				
				$formBorderColorField = [
					'name'                => 'form_border_color',
					'label'               => __t("Form Border Color"),
					'fake'                => true,
					'store_in'            => 'options',
					'type'                => 'color_picker',
					'colorpicker_options' => [
						'customClass' => 'custom-class',
					],
					'attributes'          => [
						'placeholder' => "#7324bc",
					],
					'hint'                => __t("Enter a RGB color code."),
				];
				$this->xPanel->addField($formBorderColorField);
				
				$formBorderSizeField = [
					'name'     => 'form_border_size',
					'label'    => __t("Form Border Size"),
					'fake'     => true,
					'store_in' => 'options',
					'attributes'          => [
						'placeholder' => "5px",
					],
				];
				$this->xPanel->addField($formBorderSizeField);
				
				$formBtnBackgroundColorField = [
					'name'                => 'form_btn_background_color',
					'label'               => __t("Form Button Background Color"),
					'fake'                => true,
					'store_in'            => 'options',
					'type'                => 'color_picker',
					'colorpicker_options' => [
						'customClass' => 'custom-class',
					],
					'attributes'          => [
						'placeholder' => "#7324bc",
					],
					'hint'                => __t("Enter a RGB color code."),
				];
				$this->xPanel->addField($formBtnBackgroundColorField);
				
				$formBtnTextColorField = [
					'name'                => 'form_btn_text_color',
					'label'               => __t("Form Button Text Color"),
					'fake'                => true,
					'store_in'            => 'options',
					'type'                => 'color_picker',
					'colorpicker_options' => [
						'customClass' => 'custom-class',
					],
					'attributes'          => [
						'placeholder' => "#FFF",
					],
					'hint'                => __t("Enter a RGB color code."),
				];
				$this->xPanel->addField($formBtnTextColorField);
				
				$hideTitlesField = [
					'name'     => 'hide_titles',
					'label'    => __t("Hide Titles"),
					'fake'     => true,
					'store_in' => 'options',
					'type'     => 'checkbox',
				];
				$this->xPanel->addField($hideTitlesField);
				
				$languages = Language::active()->get();
				if ($languages->count() > 0) {
					foreach($languages as $language) {
						${'titleField' . $language->abbr} = [
							'name'     => 'title_' . $language->abbr,
							'label'    => __t("Title") . ' (' . $language->name . ')',
							'fake'     => true,
							'store_in' => 'options',
							'attributes'          => [
								'placeholder' => t('Find a job near you', [], 'global', $language->abbr),
							],
							'hint'                => __t("You can use dynamic variables such as {app_name}, {country}, {count_jobs} and {count_users}."),
						];
						$this->xPanel->addField(${'titleField' . $language->abbr});
						
						${'subTitleField' . $language->abbr} = [
							'name'     => 'sub_title_' . $language->abbr,
							'label'    => __t("Sub Title") . ' (' . $language->name . ')',
							'fake'     => true,
							'store_in' => 'options',
							'attributes'          => [
								'placeholder' => t('Simple, fast and efficient', [], 'global', $language->abbr),
							],
							'hint'                => __t("You can use dynamic variables such as {app_name}, {country}, {count_jobs} and {count_users}."),
						];
						$this->xPanel->addField(${'subTitleField' . $language->abbr});
					}
				}
		
				$bigTitleColorField = [
					'name'                => 'big_title_color',
					'label'               => __t("Big Title Color"),
					'fake'                => true,
					'store_in'            => 'options',
					'type'                => 'color_picker',
					'colorpicker_options' => [
						'customClass' => 'custom-class',
					],
					'attributes'          => [
						'placeholder' => "#FFF",
					],
					'hint'                => __t("Enter a RGB color code."),
				];
				$this->xPanel->addField($bigTitleColorField);
		
				$subTitleColorField = [
					'name'                => 'sub_title_color',
					'label'               => __t("Sub Title Color"),
					'fake'                => true,
					'store_in'            => 'options',
					'type'                => 'color_picker',
					'colorpicker_options' => [
						'customClass' => 'custom-class',
					],
					'attributes'          => [
						'placeholder' => "#FFF",
					],
					'hint'                => __t("Enter a RGB color code."),
				];
				$this->xPanel->addField($subTitleColorField);
			}
			
            // getCategories, getSponsoredPosts, getLatestPosts & getFeaturedPostsCompanies
            if (in_array($section->method, ['getCategories', 'getSponsoredPosts', 'getLatestPosts', 'getFeaturedPostsCompanies'])) {
                $maxItemsField = [
                    'name'     => 'max_items',
                    'label'    => __t("Max Items"),
                    'fake'     => true,
                    'store_in' => 'options',
                ];
                $this->xPanel->addField($maxItemsField);
            }
	
			// getSponsoredPosts, getLatestPosts & getFeaturedPostsCompanies
			if (in_array($section->method, ['getSponsoredPosts', 'getLatestPosts', 'getFeaturedPostsCompanies'])) {
				$orderByField = [
					'name'        => 'order_by',
					'label'       => __t("Order By"),
					'fake'        => true,
					'store_in'    => 'options',
					'type'        => 'select2_from_array',
					'options'     => [
						'date'   => __t("Date"),
						'random' => __t("Random"),
					],
					'allows_null' => false,
				];
				$this->xPanel->addField($orderByField);
			}
            
            // getLocations
            if ($section->method == 'getLocations') {
                $maxItemsField = [
                    'name'       => 'max_items',
                    'label'      => __t("Max Cities"),
                    'fake'       => true,
                    'store_in'   => 'options',
                    'attributes' => [
                        'placeholder' => 12,
                    ],
                ];
                $this->xPanel->addField($maxItemsField);
                
                $showMapField = [
                    'name'     => 'show_map',
                    'label'    => __t("Show the Country Map"),
                    'fake'     => true,
                    'store_in' => 'options',
                    'type'     => 'checkbox',
                ];
                $this->xPanel->addField($showMapField);
                
                $mapBackgroundColorField = [
                    'name'                => 'map_background_color',
                    'label'               => __t("Map's Background Color"),
                    'fake'                => true,
                    'store_in'            => 'options',
                    'type'                => 'color_picker',
                    'colorpicker_options' => [
                        'customClass' => 'custom-class',
                    ],
                    'attributes'          => [
                        'placeholder' => "transparent",
                    ],
                    'hint'                => __t("Enter a RGB color code or the word 'transparent'."),
                ];
                $this->xPanel->addField($mapBackgroundColorField);
                
                $mapBorderField = [
                    'name'                => 'map_border',
                    'label'               => __t("Map's Border"),
                    'fake'                => true,
                    'store_in'            => 'options',
                    'type'                => 'color_picker',
                    'colorpicker_options' => [
                        'customClass' => 'custom-class',
                    ],
                    'attributes'          => [
                        'placeholder' => "#c7c5c1",
                    ],
                ];
                $this->xPanel->addField($mapBorderField);
                
                $mapHoverBorderField = [
                    'name'                => 'map_hover_border',
                    'label'               => __t("Map's Hover Border"),
                    'fake'                => true,
                    'store_in'            => 'options',
                    'type'                => 'color_picker',
                    'colorpicker_options' => [
                        'customClass' => 'custom-class',
                    ],
                    'attributes'          => [
                        'placeholder' => "#c7c5c1",
                    ],
                ];
                $this->xPanel->addField($mapHoverBorderField);
                
                $mapBorderWidthField = [
                    'name'       => 'map_border_width',
                    'label'      => __t("Map's Border Width"),
                    'fake'       => true,
                    'store_in'   => 'options',
                    'attributes' => [
                        'placeholder' => 4,
                    ],
                ];
                $this->xPanel->addField($mapBorderWidthField);
                
                $mapColorField = [
                    'name'                => 'map_color',
                    'label'               => __t("Map's Color"),
                    'fake'                => true,
                    'store_in'            => 'options',
                    'type'                => 'color_picker',
                    'colorpicker_options' => [
                        'customClass' => 'custom-class',
                    ],
                    'attributes'          => [
                        'placeholder' => "#f2f0eb",
                    ],
                ];
                $this->xPanel->addField($mapColorField);
                
                $mapHoverField = [
                    'name'                => 'map_hover',
                    'label'               => __t("Map's Hover"),
                    'fake'                => true,
                    'store_in'            => 'options',
                    'type'                => 'color_picker',
                    'colorpicker_options' => [
                        'customClass' => 'custom-class',
                    ],
                    'attributes'          => [
                        'placeholder' => "#4682B4",
                    ],
                ];
                $this->xPanel->addField($mapHoverField);
                
                $mapWidthField = [
                    'name'       => 'map_width',
                    'label'      => __t("Map's Width"),
                    'fake'       => true,
                    'store_in'   => 'options',
                    'attributes' => [
                        'placeholder' => "300px",
                    ],
                ];
                $this->xPanel->addField($mapWidthField);
                
                $mapHeightField = [
                    'name'       => 'map_height',
                    'label'      => __t("Map's Height"),
                    'fake'       => true,
                    'store_in'   => 'options',
                    'attributes' => [
                        'placeholder' => "300px",
                    ],
                ];
                $this->xPanel->addField($mapHeightField);
            }
            
            // getSponsoredPosts
            if ($section->method == 'getSponsoredPosts') {
                $carouselAutoplayField = [
                    'name'     => 'autoplay',
                    'label'    => __t("Carousel's Autoplay"),
                    'fake'     => true,
                    'store_in' => 'options',
                    'type'     => 'checkbox',
                ];
                $this->xPanel->addField($carouselAutoplayField);
                
                $carouselAutoplayTimeout = [
                    'name'       => 'autoplay_timeout',
                    'label'      => __t("Carousel's Autoplay Timeout"),
                    'fake'       => true,
                    'store_in'   => 'options',
                    'attributes' => [
                        'placeholder' => 1500,
                    ],
                ];
                $this->xPanel->addField($carouselAutoplayTimeout);
            }
    
            // getLocations, getSponsoredPosts, getLatestPosts, getCategories & getFeaturedPostsCompanies
            if (in_array($section->method, ['getLocations', 'getSponsoredPosts', 'getLatestPosts', 'getCategories', 'getFeaturedPostsCompanies'])) {
                $cacheExpirationField = [
                    'name'     => 'cache_expiration',
                    'label'    => __t("Cache Expiration Time for this section"),
                    'fake'     => true,
                    'store_in' => 'options',
                    'attributes' => [
                        'placeholder' => __t("In minutes (e.g. 60 for 1h, 0 or empty value to disable the cache)"),
                    ],
                    'hint' => __t("In minutes (e.g. 60 for 1h, 0 or empty value to disable the cache)"),
                ];
                $this->xPanel->addField($cacheExpirationField);
            }
        }
        
        $activeField = [
            'name'  => 'active',
            'label' => __t("Active"),
            'type'  => 'checkbox',
        ];
		if (!empty($section) && $section->method == 'getTopAdvertising') {
			$activeField['hint'] = __t('To enable this feature, you have to configure the top advertisement in the Admin panel -> Advertising -> top (Edit)');
		}
		if (!empty($section) && $section->method == 'getBottomAdvertising') {
			$activeField['hint'] = __t('To enable this feature, you have to configure the bottom advertisement in the Admin panel -> Advertising -> bottom (Edit)');
		}
        $this->xPanel->addField($activeField);
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

<?php
return [
	'settings' => [
		'general' => [
			'id' => 'general_settings',
			'label' => ilangs('General'),
			'fields' => [
				[
					'id' => 'post_title',
					'label' => ilangs('Title'),
					'type' => 'text',
					'std' => '',
					'break' => true,
                    'validation' => 'required',
					'translation' => true,
				],
                [
                    'id' => 'post_slug',
                    'label' => ilangs('Permalink'),
                    'type' => 'permalink',
                    'post_type' => GMZ_SERVICE_PROPERTY,
                    'break' => true,
                ],
				[
					'id' => 'post_content',
					'label' => ilangs('Content'),
					'type' => 'editor',
					'layout' => 'col-12',
					'std' => '',
					'break' => true,
					'translation' => true
				],
                [
                    'id' => 'post_description',
                    'label' => ilangs('Short Description'),
                    'type' => 'textarea',
                    'layout' => 'col-12',
                    'std' => '',
                    'break' => true,
                    'translation' => true
                ],
                [
                    'id' => 'is_featured',
                    'label' => ilangs('Is Featured'),
                    'type' => 'switcher',
                    'std' => 'on',
                    'break' => true,
                ],
                [
                    'id' => 'status',
                    'label' => ilangs('Status'),
                    'type' => 'select',
                    'choices' => 'status:property',
                    'layout' => 'col-12 col-md-4',
                ],
                [
                    'id' => 'sale_type',
                    'label' => ilangs('Type'),
                    'type' => 'select',
                    'std' => '',
                    'layout' => 'col-sm-4 col-12',
                    'choices' => 'term:name:sale-type'
                ],
                [
                    'id' => 'enquiry_form',
                    'label' => ilangs('Enquiry Form'),
                    'type' => 'select',
                    'std' => 'instant',
                    'layout' => 'col-sm-4 col-12',
                    'choices' => [
                        'enquiry' => ilangs('Enquiry'),
                    ]
                ],
			]
		],
        'location' => [
            'id' => 'location_settings',
            'label' => ilangs('Location'),
            'fields' => [
                [
                    'id' => 'location',
                    'label' => ilangs('Location'),
                    'type' => 'location',
                    'std' => '',
                    'break' => true,
                    'translation_ext' => true,
                    'column' => 'col-lg-3',
                ]
            ]
        ],
        'pricing' => [
            'id' => 'pricing_settings',
            'label' => ilangs('Pricing'),
            'fields' => [
                [
                    'id' => 'base_price',
                    'label' => ilangs('Base Price'),
                    'type' => 'text',
                    'std' => '',
                    'break' => true,
                    'validation' => 'required',
                    'layout' => 'col-lg-4 col-md-6 col-sm-6 col-12',
                ],
                [
                    'id' => 'discount',
                    'label' => ilangs('Discount'),
                    'type' => 'list_item',
                    'layout' => 'col-md-8 col-12',
                    'break' => true,
                    'translation' => true,
                    // 'condition' => 'booking_type:per_day',
                    'fields' => [
                        [
                            'id' => 'title',
                            'label' => ilangs('Title'),
                            'type' => 'text',
                            'std' => '',
                            'break' => true,
                            'translation' => true,
                        ],

                        [
                            'id' => 'price',
                            'label' => ilangs('Price'),
                            'type' => 'text',
                            'std' => '',
                            'break' => true,
                        ]
                    ]
                ],
                [
                    'id' => 'extra_services',
                    'label' => ilangs('Extra Services'),
                    'type' => 'list_item',
                    'layout' => 'col-md-8 col-12',
                    'break' => true,
                    'translation' => true,
                    'fields' => [
                        [
                            'id' => 'title',
                            'label' => ilangs('Title'),
                            'type' => 'text',
                            'std' => '',
                            'break' => true,
                            'translation' => true,
                        ],
                        [
                            'id' => 'price',
                            'label' => ilangs('Price'),
                            'type' => 'text',
                            'std' => '',
                            'break' => true,
                        ],
                        [
                            'id' => 'required',
                            'label' => ilangs('Required'),
                            'type' => 'switcher',
                            'std' => 'off',
                            'break' => true,
                        ],
                    ]
                ],
 

            ]
        ],
        'custom_price' => [
            'id' => 'custom_price_settings',
            'label' => ilangs('Custom Price'),
            'fields' => [
                [
                    'id' => 'custom_price',
                    'label' => ilangs('Custom Pricing'),
                    'type' => 'custom_price',
                    'std' => '',
                    'break' => true,
                    'column' => 'col-12',
                ]
            ]
        ],
        'amemity' => [
            'id' => 'amemity_settings',
            'label' => ilangs('Amenities'),
            'fields' => [
     
                [
                    'id' => 'size',
                    'label' => ilangs('Size (m2/ft)'),
                    'type' => 'text',
                    'std' => '',
                    'layout' => 'col-md-6 col-sm-6 col-12',
                    'validation' => 'required',
                ],
                [
                    'id' => 'property_amenity',
                    'label' => ilangs('Property Amenities'),
                    'type' => 'checkbox',
                    'std' => '',
                    'break' => true,
                    'column' => 'col-md-4 col-sm-6 col-12',
                    'translation' => true,
                    'choices' => 'term:name:property-amenity'
                ],
            ]
        ],
        'media' => [
            'id' => 'media_settings',
            'label' => ilangs('Media'),
            'fields' => [
                [
                    'id' => 'thumbnail_id',
                    'label' => ilangs('Featured Image'),
                    'type' => 'image',
                    'layout' => 'col-6',
                    'break' => true,
                ],
                [
                    'id' => 'gallery',
                    'label' => ilangs('Gallery'),
                    'type' => 'gallery',
                    'layout' => 'col-12',
                    'break' => true,
                ],
                [
                    'id' => 'video',
                    'label' => ilangs('Video'),
                    'type' => 'text',
                    'layout' => 'col-12 col-md-6',
                    'break' => true,
                ]
            ]
        ],

	]
];
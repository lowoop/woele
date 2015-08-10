<?php
return array(
	'menu'	=> array(
		'adm_default_index'=>array(
		    'name'=>'Home',
			'url'=>true,
			'icon'=>'icon-home',
			'submenu'=>array(),
		),
		'adm_orders_index'=>array(
				'name'=>'Order',
				'url'=>false,
				'icon'=>'icon-shopping-cart',
				'submenu'=>array(
                    'adm_orders_admin'=>array(
                        'name'=>'Orders',
                    ),
                    'adm_orderLog_admin'=>array(
                        'name'=>'Order Logs',
                    ),
                ),
		),
        'adm_courier_index'=>array(
            'name'=>'Courier',
            'url'=>false,
            'icon'=>'icon-user-md',
            'submenu'=>array(
                'adm_courier_admin'=>array(
                    'name'=>'Couriers',
                ),
                'adm_courierOrders_admin'=>array(
                    'name'=>'Courier Orders',
                ),
            ),
        ),
		'adm_admin_index'=>array(
			'name'=>'Settings',
			'url'=>false,
			'icon'=>'icon-th-list',
			'submenu'=>array(
				'adm_common_index'=>array(
					'name'=>'Common config',
				),
				'adm_admin_admin'=>array(
					'name'=>'Users',
				),	
				'adm_restaurant_admin'=>array(
					'name'=>'Restaurants',
				),
// 				'adm_series_admin'=>array(
// 						'name'=>'Series',
// 				),
				'adm_tag_admin'=>array(
						'name'=>'Tags',
				),
				'adm_food_admin'=>array(
						'name'=>'Foods',
				),
			),
		),
	),
); 
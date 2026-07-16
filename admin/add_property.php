<?php



require_once ABSPATH . 'wp-admin/includes/file.php';

include_once(ABSPATH . 'wp-admin/includes/admin.php');







function apimo_fetch_property()

{

	if (false === as_has_scheduled_action('apimo_import_property_recurring')) {

		as_schedule_recurring_action(strtotime('tomorrow'), DAY_IN_SECONDS, 'apimo_import_property_recurring');
	}
}


add_action('init', 'apimo_fetch_property');







/**

 * A callback to run when the 'eg_midnight_log' scheduled action is run.

 */

function apimo_fetch_property_fun()

{



	if (!get_option('apimo_initalize')) {

		apimo_add_category();

		apimo_add_subcategory();

		apimo_add_orientation();

		apimo_add_service();

		apimo_add_availability();

		apimo_add_type();

		apimo_add_subtype();

		apimo_add_construction();

		apimo_add_property_building();

		apimo_add_property_floor();

		apimo_add_heating_device();

		apimo_add_heating_access();

		apimo_add_heating_type();

		apimo_add_water_hot_device();

		apimo_add_water_hot_access();

		apimo_add_water_waste();

		apimo_add_condition();

		apimo_add_standing();

		apimo_add_areas();

		apimo_add_repository_tags();

		update_option('apimo_initalize', true);
	}

	update_option("apimo_schedule_time", time());




	$apimo_api_keys = get_option('apimo_key_data');
	$api_property_array = array();

	if (!empty($apimo_api_keys)) :
		foreach ($apimo_api_keys as $data_keys) {
			if (!$data_keys['is_valid']) {
				continue;
			}

			$company_id = $data_keys['company_id'];
			$api_key = $data_keys['key'];
			$agencies_id = $data_keys['agency_id'];
			$sector_id = !empty($data_keys['sector_id']) ? '-' . $data_keys['sector_id'] : '';
			$auth = base64_encode($company_id . ':' . $api_key);

			$result = wp_remote_get('https://api.apimo.pro/agencies/' . $agencies_id . $sector_id . '/properties', array(
				'headers' => array(
					'Content-Type' => 'application/json',
					'Authorization' => 'Basic ' . $auth
				),
			));

			if (is_wp_error($result)) {
				return;
			}

			$data = json_decode($result['body']);
			$i = 1;

			foreach ($data->properties as $property) {
				$i++;
				$api_property_array[] = $property->id;
				update_option('apimo_property_data_' . $property->id, $property);
				as_schedule_single_action(strtotime('+' . $i . ' second'), 'apimo_import_single_property', array($property->id));
				update_option("apimo_add_property_by_api", $api_property_array);
			}
		}
	endif;
}

add_action('apimo_import_property_recurring', 'apimo_fetch_property_fun');

add_action('apimo_fetch_property_manual', 'apimo_fetch_property_fun');







add_action('wp', function () {
	if (isset($_GET['test']) && $_GET['test'] == 'property_add') {


		// Sanitize the input data
		$test = sanitize_key($_GET['test']);

		// Validate the input data
		if ($test !== 'property_add') {
			// The input data is not valid, do something here (e.g. return an error message or redirect to a different page)
			exit;
		}

		echo '<pre>';

		//apimo_add_repository_tags();

		apimo_fetch_property_fun();

		exit;
	}
});




add_action('apimo_import_single_property', 'apimo_add_new_property');



function apimo_add_new_property($property_id)

{







	$property = get_option('apimo_property_data_' . $property_id);





	$property_exist = new WP_Query(array(

		'post_type' => 'property',

		'post_status'  => 'publish',

		'meta_query' => array(

			array(

				'key'   => 'apimo_id',

				'value' => $property->id

			)

		)

	));



	// echo '<pre>';

	// print_r($property_exist);

	// 		print_r(array(

	// 			'post_title'   => !empty($property->comments) ? $property->comments[0]->title : $property->id,

	// 			'post_type' => 'property',

	// 			'post_status'  => 'publish',



	// 		));

	// echo '</pre>';

	$currentLanguage = get_bloginfo('language');

	$lang = explode('-', $currentLanguage)[0];

	if (!empty($property->comments)) {

		$commentdata_lang = $property->comments[0];
	}



	foreach ($property->comments as $commentdata) {

		//  print_r($commentdata);   

		if ($commentdata->language == $lang) {

			$commentdata_lang =     $commentdata;

			//   print_r($commentdata_lang);

		}
	}



	if (empty($property_exist->posts)) {


		$title = $property->id;
		if (isset($commentdata_lang->title)) {
			$title = $commentdata_lang->title;
		}

		$id = wp_insert_post(array(

			'post_title'   => $title,

			'post_type' => 'property',

			'post_status'  => 'publish',

		));
	} else {

		$id = $property_exist->posts[0]->ID;

		wp_update_post(array(

			'ID' => $id,

			'post_title'   =>  !empty($commentdata_lang) ? $commentdata_lang->title : $property->id,

			'post_type' => 'property',

			'post_status'  => 'publish',



		));
	}



	update_post_meta($id, 'apimo_id', $property->id);

	update_post_meta($id, 'apimo_reference', $property->reference);

	update_post_meta($id, 'apimo_agency', $property->agency);

	update_post_meta($id, 'apimo_brand', $property->brand);

	update_post_meta($id, 'apimo_user_data', $property->user);

	update_post_meta($id, 'apimo_user_id', $property->user->id);

	update_post_meta($id, 'apimo_type', $property->type);

	update_post_meta($id, 'apimo_subtype', $property->subtype);

	update_post_meta($id, 'apimo_block_name', $property->block_name);

	update_post_meta($id, 'apimo_lot_reference', $property->lot_reference);

	update_post_meta($id, 'apimo_address', $property->address);

	update_post_meta($id, 'apimo_address_more', $property->address_more);

	update_post_meta($id, 'apimo_publish_address', $property->publish_address);

	update_post_meta($id, 'apimo_content', $property->comments);


	update_post_meta($id, 'apimo_property_location', array(
		'country'   => $property->country,
		'region'    => $property->region,
		'city'      => $property->city,
		'district'  => $property->district,
		'longitude' => $property->longitude,
		'latitude'  => $property->latitude,
	));

	update_post_meta($id, 'apimo_agreement', $property->agreement);
	update_post_meta($id, 'apimo_residence', $property->residence);


	update_post_meta($id, 'apimo_medias', $property->medias);




	if ($property->country) {
		$country = wp_set_object_terms($id, $property->country, 'country', true);
	}


	// $country = wp_set_object_terms($id, $property->country, 'country', true);

	if ($property->region) {
		$region = wp_set_object_terms($id, $property->region->name, 'region', true);
		add_term_meta($region[0], 'apimo_term_id', $property->region->id);
	}

	// $region = wp_set_object_terms($id, $property->region->name, 'region', true);

	// add_term_meta($region[0], 'apimo_term_id', $property->region->id);

	if ($property->city) {
		$city = wp_set_object_terms($id, $property->city->name, 'city', false);
		update_term_meta($city[0], 'apimo_term_id', $property->city->id);
		update_term_meta($city[0], 'zip_code', $property->city->zipcode);
	}
	// $city = wp_set_object_terms($id, $property->city->name, 'city', false);



	// update_term_meta($city[0], 'apimo_term_id', $property->city->id);
	// update_term_meta($city[0], 'zip_code', $property->city->zipcode);

	// $city_zipcode = wp_insert_term($property->city->zipcode, 'city', array('parent' => $city[0]));
	// if (is_wp_error($city_zipcode)) {

	// 	wp_set_object_terms($id, $city_zipcode->error_data['term_exists'], 'city', true);
	// } else {
	// 	wp_set_object_terms($id, $city_zipcode, 'city', true);
	// }


	if ($property->district) {

		$district = wp_set_object_terms($id, $property->district->name, 'district', true);
		add_term_meta($district[0], 'apimo_term_id', $property->district->id);
	}

	// $district = wp_set_object_terms($id, $property->district->name, 'district', true);

	// add_term_meta($district[0], 'apimo_term_id', $property->district->id);



	$category_args = array(

		'taxonomy' => 'apimo_category',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->category

			)

		)

	);

	$category = get_terms($category_args);
	if ($category) {
		wp_set_object_terms($id, $category[0]->term_id, 'apimo_category', true);
	}
	// wp_set_object_terms($id, $category[0]->term_id, 'apimo_category', true);



	$subcategory_args = array(

		'taxonomy' => 'apimo_sub_category',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->subcategory

			)

		)

	);

	$subcategory = get_terms($subcategory_args);
	if ($subcategory) {
		wp_set_object_terms($id, $subcategory[0]->term_id, 'apimo_category', true);
	}
	// wp_set_object_terms($id, $subcategory[0]->term_id, 'apimo_category', true);



	foreach ($property->services as $service) {

		$service_args = array(

			'taxonomy' => 'apimo_service',

			'hide_empty' => false,

			'meta_query' => array(

				array(

					'key' => 'apimo_term_id',

					'value' => $service

				)

			)

		);

		$service_term = get_terms($service_args);

		if ($service_term) {
			wp_set_object_terms($id, $service_term[0]->term_id, 'apimo_service', true);
		}

		// wp_set_object_terms($id, $service_term[0]->term_id, 'apimo_service', true);
	}



	$availability_args = array(

		'taxonomy' => 'apimo_availability',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->availability

			)

		)

	);

	$availability_term  = get_terms($availability_args);
	if ($availability_term) {
		wp_set_object_terms($id, $availability_term[0]->term_id, 'apimo_availability', true);
	}
	// wp_set_object_terms($id, $availability_term[0]->term_id, 'apimo_availability', true);



	$type_args = array(

		'taxonomy' => 'apimo_type',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->type

			)

		)

	);



	$type = get_terms($type_args);
	if ($type) {
		wp_set_object_terms($id, $type[0]->term_id, 'apimo_type', true);
	}

	// wp_set_object_terms($id, $type[0]->term_id, 'apimo_type', true);





	$subtype_args = array(

		'taxonomy' => 'apimo_subtype',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->subtype

			)

		)

	);

	$subtype = get_terms($subtype_args);
	if ($subtype) {
		wp_set_object_terms($id, $subtype[0]->term_id, 'apimo_subtype', true);
	}
	// wp_set_object_terms($id, $subtype[0]->term_id, 'apimo_subtype', true);



	$constructions_args = array(

		'taxonomy' => 'apimo_construction',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->construction->method,

				'compare' => 'IN'

			)

		)

	);



	$construction = get_terms($constructions_args);
	if ($construction) {
		wp_set_object_terms($id, array_map(function ($term) {

			return $term->term_id;
		}, $construction), 'apimo_construction', true);
	}

	// wp_set_object_terms($id, array_map(function ($term) {

	// 	return $term->term_id;
	// }, $construction), 'apimo_construction', true);





	$residence_type_args = array(

		'taxonomy' => 'apimo_property_building',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->residence->type,

			)

		)

	);



	$residence_type = get_terms($residence_type_args);

	if ($residence_type) {
		wp_set_object_terms($id, $residence_type[0]->term_id, 'apimo_property_building', true);
	}

	// wp_set_object_terms($id, $residence_type[0]->term_id, 'apimo_property_building', true);



	update_post_meta($id, 'apimo_residence_period', $property->residence->period);

	update_post_meta($id, 'apimo_residence_fees', $property->residence->fees);

	update_post_meta($id, 'apimo_residence_lots', $property->residence->lots);



	$floor_args = array(

		'taxonomy' => 'apimo_floor',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->floor->type,

			)

		)

	);



	$floor_type = get_terms($floor_args);
	if ($floor_type) {
		wp_set_object_terms($id, $floor_type[0]->term_id, 'apimo_floor', true);
	}

	// wp_set_object_terms($id, $floor_type[0]->term_id, 'apimo_floor', true);



	update_post_meta($id, 'apimo_floor_value', $property->floor->value);

	update_post_meta($id, 'apimo_floor_levels', $property->floor->levels);

	update_post_meta($id, 'apimo_floor_floors', $property->floor->floors);



	$total_bathroom = 0;

	foreach ($property->areas as $areas) {



		$areas_args = array(

			'taxonomy' => 'apimo_areas',

			'hide_empty' => false,

			'meta_query' => array(

				array(

					'key' => 'apimo_term_id',

					'value' => $areas->type,

					'compare' => 'IN'

				)

			)

		);

		if ($areas->type == 8 || $areas->type == 41 || $areas->type == 13) {

			$total_bathroom = $total_bathroom + $areas->number;
		}

		$areas = get_terms($areas_args);
		if ($areas) {
			wp_set_object_terms($id, array_map(function ($term) {

				return $term->term_id;
			}, $areas), 'apimo_areas', true);
		}

		// wp_set_object_terms($id, array_map(function ($term) {

		// 	return $term->term_id;
		// }, $areas), 'apimo_areas', true);
	}



	update_post_meta($id, 'apimo_bathrooms', $total_bathroom);



	update_post_meta($id, 'apimo_longitude', $property->longitude);

	update_post_meta($id, 'apimo_latitude', $property->latitude);

	update_post_meta($id, 'apimo_radius', $property->radius);

	update_post_meta($id, 'apimo_area', $property->area);

	update_post_meta($id, 'apimo_area_unit', $property->area->unit);

	update_post_meta($id, 'apimo_area_value', $property->area->value);

	update_post_meta($id, 'apimo_area_total', $property->area->total);

	update_post_meta($id, 'apimo_area_weighted', $property->area->weighted);

	$apimo_archive_settings = get_option('apimo_style_archive');



	$area_display_type = $apimo_archive_settings['area_display_type'];







	$apimo_area_display_filter = 0;

	if ($property->area->$area_display_type) {

		$apimo_area_display_filter = $property->area->$area_display_type;
	} else {

		if ($property->area->weighted) {

			$apimo_area_display_filter = $property->area->weighted;
		} else if ($property->area->total) {

			$apimo_area_display_filter = $property->area->total;
		} else if ($property->area->value) {

			$apimo_area_display_filter = $property->area->value;
		}
	}





	update_post_meta($id, 'apimo_area_display_filter', $apimo_area_display_filter);





	update_post_meta($id, 'apimo_plot', $property->plot);

	update_post_meta($id, 'apimo_rooms', $property->rooms);

	update_post_meta($id, 'apimo_bedrooms', $property->bedrooms);

	update_post_meta($id, 'apimo_sleeps', $property->sleeps);

	update_post_meta($id, 'apimo_price', $property->price->value + $property->price->fees);

	update_post_meta($id, 'apimo_price_commission', $property->price->commission);



	update_post_meta($id, 'apimo_price_data', $property->price);

	update_post_meta($id, 'apimo_price_hide', $property->price->hide ? $property->price->hide : 0);

	update_post_meta($id, 'apimo_price_currency', $property->price->currency);



	update_post_meta($id, 'apimo_construction_year', $property->construction->construction_year);

	update_post_meta($id, 'apimo_renovation_year', $property->construction->renovation_year);

	update_post_meta($id, 'apimo_renovation_cost', $property->construction->renovation_cost);



	update_post_meta($id, 'apimo_available_at', $property->available_at);

	update_post_meta($id, 'apimo_delivered_at', $property->delivered_at);



	update_post_meta($id, 'apimo_created_at', $property->created_at);

	update_post_meta($id, 'apimo_updated_at', $property->updated_at);



	update_post_meta($id, 'apimo_regulations', $property->regulations);

	update_post_meta($id, 'apimo_documents', $property->documents);










	$heating_type_args = array(

		'taxonomy' => 'apimo_heating_type',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->heating->types,

				'compare' => 'IN'

			)

		)

	);



	$heating_type = get_terms($heating_type_args);
	if ($heating_type) {
		wp_set_object_terms($id, array_map(function ($term) {
			return $term->term_id;
		}, $heating_type), 'apimo_heating_type', true);
	}
	// wp_set_object_terms($id, array_map(function ($term) {

	// 	return $term->term_id;
	// }, $heating_type), 'apimo_heating_type', true);



	$heating_access_args = array(

		'taxonomy' => 'apimo_heating_access',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->heating->access,

			)

		)

	);



	$heating_access = get_terms($heating_access_args);
	if ($heating_access) {
		wp_set_object_terms($id, $heating_access[0]->term_id, 'apimo_heating_access', true);
	}

	// wp_set_object_terms($id, $heating_access[0]->term_id, 'apimo_heating_access', true);



	$heating_device_args = array(

		'taxonomy' => 'apimo_heating_device',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->heating->devices,

				'compare' => 'IN'

			)

		)

	);



	$heating_device = get_terms($heating_device_args);
	if ($heating_device) {
		wp_set_object_terms($id, array_map(function ($term) {

			return $term->term_id;
		}, $heating_device), 'apimo_heating_device', true);
	}
	// wp_set_object_terms($id, array_map(function ($term) {

	// 	return $term->term_id;
	// }, $heating_device), 'apimo_heating_device', true);



	$water_hot_device_args = array(

		'taxonomy' => 'apimo_water_hot_device',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->water->hot_device,

			)

		)

	);



	$water_hot_device = get_terms($water_hot_device_args);
	if ($water_hot_device) {
		wp_set_object_terms($id, $water_hot_device[0]->term_id, 'apimo_water_hot_device', true);
	}

	// wp_set_object_terms($id, $water_hot_device[0]->term_id, 'apimo_water_hot_device', true);



	$water_hot_access_args = array(

		'taxonomy' => 'apimo_water_hot_access',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->water->hot_access,

			)

		)

	);



	$water_hot_access = get_terms($water_hot_access_args);
	if ($water_hot_access) {
		wp_set_object_terms($id, $water_hot_access[0]->term_id, 'apimo_water_hot_access', true);
	}

	// wp_set_object_terms($id, $water_hot_access[0]->term_id, 'apimo_water_hot_access', true);



	$water_waste_args = array(

		'taxonomy' => 'apimo_water_waste',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->water->waste,

			)

		)

	);



	$water_waste = get_terms($water_waste_args);
	if ($water_waste) {
		wp_set_object_terms($id, $water_waste[0]->term_id, 'apimo_water_waste', true);
	}

	// wp_set_object_terms($id, $water_waste[0]->term_id, 'apimo_water_waste', true);



	$property_condition_args = array(

		'taxonomy' => 'apimo_property_condition',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->condition,

			)

		)

	);



	$property_condition = get_terms($property_condition_args);
	if ($property_condition) {
		wp_set_object_terms($id, $property_condition[0]->term_id, 'apimo_property_condition', true);
	}

	// wp_set_object_terms($id, $property_condition[0]->term_id, 'apimo_property_condition', true);





	$property_standing_args = array(

		'taxonomy' => 'apimo_property_standing',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->standing,

			)

		)

	);



	$property_standing = get_terms($property_standing_args);
	if ($property_standing) {
		wp_set_object_terms($id, $property_standing[0]->term_id, 'apimo_property_standing', true);
	}
	// wp_set_object_terms($id, $property_standing[0]->term_id, 'apimo_property_standing', true);



	$repository_tags = array(

		'taxonomy' => 'repository_tags',

		'hide_empty' => false,

		'meta_query' => array(

			array(

				'key' => 'apimo_term_id',

				'value' => $property->tags,

				'compare' => 'IN'

			)

		)

	);



	$repository_tag = get_terms($repository_tags);
	if ($repository_tag) {
		wp_set_object_terms($id, array_map(function ($term) {

			return $term->term_id;
		}, $repository_tag), 'repository_tags', true);
	}

	// wp_set_object_terms($id, array_map(function ($term) {

	// 	return $term->term_id;
	// }, $repository_tag), 'repository_tags', true);





	wp_set_object_terms($id, array_map(function ($term) {

		return $term->id;
	}, $property->tags_customized), 'customised_tags', true);





	$timeout_seconds = 50;

	$gallery_images = array();

	foreach ($property->pictures as $image) {

		$image_exist = get_posts(array(

			'post_type' => 'attachment',

			'meta_query' => array(

				array(

					'key'   => 'apimo_image_id',

					'value' => $image->id

				)

			)

		));



		if (empty($image_exist)) {

			$temp_file = download_url($image->url, $timeout_seconds);

			if (!is_wp_error($temp_file)) {

				@list($origin_image_url, $timestamp) = explode("?", $image->url);

				$file = array(

					'name'     => basename($origin_image_url), // ex: wp-header-logo.png

					'type'     => 'image/jpg',

					'tmp_name' => $temp_file,

					'error'    => 0,

					'size'     => filesize($temp_file),

				);

				$image_id = media_handle_sideload($file, 0);

				$image_url =  wp_get_attachment_image_url($image_id, 'full');

				update_post_meta($image_id, 'apimo_image_id', $image->id);
			}
		} else {

			$image_id = $image_exist[0]->ID;

			$image_url =  wp_get_attachment_image_url($image_id, 'full');
		}



		// echo '<pre>';

		//  print_r($image_id);

		//  print_r('->>>>>>>>>>>>>>');

		//  print_r($image_url);

		//  echo '</pre>';



		if ($image->rank == 1) {

			set_post_thumbnail($id, $image_id);
		} else {

			$gallery_images[] = $image_url;
		}
	}

	update_post_meta($id, 'apimo_gallery_images', $gallery_images);



	//----------------------------------------------------------DELETE POST-----------------------------------------------------------------------//

	$property_ids = get_option("apimo_add_property_by_api");



	$args = array(

		'post_type' => 'property',  //Set your post_type

		'post_status' => 'publish',  //Set your post_status

		'posts_per_page' => -1,

		'meta_query' => array(

			array(

				'key' => 'apimo_id',

				'value' => $property_ids,

				'compare' => 'IN'

			),

		),

	);

	$import_by_api = new WP_Query($args);

	$post_ids = wp_list_pluck($import_by_api->posts, 'ID');



	$menual_upload = new WP_Query(array(

		'post_type' => 'property',

		'post_status' => 'any',

		'post__not_in' =>  $post_ids,

		'posts_per_page' => -1,

	));



	if ($menual_upload->have_posts()) {

		while ($menual_upload->have_posts()) {

			$menual_upload->the_post();

			wp_delete_post(get_the_ID());
		}
	}

	//----------------------------------------------------------DELETE POST-----------------------------------------------------------------------//

}

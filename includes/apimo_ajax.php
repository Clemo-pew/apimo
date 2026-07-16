<?php



add_action("wp_ajax_apimo_check_api_key", 'apimo_check_api_key');



add_action("wp_ajax_nopriv_apimo_check_api_key", 'apimo_check_api_key');









function apimo_check_api_key()

{

    $key_data = array();

    if (!empty($_POST['company_id'])) {

        foreach ($_POST['company_id'] as $key => $company_id) {

            if ($company_id == '' && $_POST['api_key'][$key]) {

                continue;

            }



            $company_id = filter_var($_POST['company_id'][$key], FILTER_SANITIZE_NUMBER_INT);

            $api_key = sanitize_text_field($_POST['api_key'][$key]);

            $sector_id = !empty($_POST['sector_id'][$key]) ? filter_var($_POST['sector_id'][$key], FILTER_SANITIZE_NUMBER_INT) : '';



            if ($company_id === false) {

                exit("company id is not valid");

            }



            if ($api_key === false) {

                exit("api key is not valid");

            }



            $auth = base64_encode($company_id . ':' . $api_key);

            $result = wp_remote_post(

                'https://api.apimo.pro/agencies',

                array(

                    'method' => 'GET',

                    'sslverify' => false,

                    'headers' => array(

                        'Content-Type' => 'application/json',

                        'Authorization' => 'Basic ' . $auth

                    ),

                )

            );



            if (!is_wp_error($result)) {

                $data = json_decode($result['body']);

                foreach ($data->agencies as $_agency) {

                    $key_data[] = array(

                        'key' => $api_key,

                        'company_id' => $company_id,

                        'agency_id' => $_agency->id,

                        'sector_id' => $sector_id,

                        'is_valid' => true,

                        'message' => ''

                    );

                }

            } else {

                $message = $result->get_error_message();

                $key_data[] = array(

                    'key' => $api_key,

                    'company_id' => $company_id,

                    'agency_id' => '',

                    'sector_id' => $sector_id,

                    'is_valid' => false,

                    'message' => $message

                );

            }

        }

    }

    update_option('apimo_key_data', $key_data);

    wp_send_json($key_data);

}





add_action("wp_ajax_apimo_run_menual_scheduler", 'apimo_run_menual_scheduler');



add_action("wp_ajax_nopriv_apimo_run_menual_scheduler", 'apimo_run_menual_scheduler');




function apimo_run_menual_scheduler()

{



    as_schedule_single_action(strtotime('now'), 'apimo_fetch_property_manual');



    echo 'Run scheduler successfully ...';



    die();

}











add_action("wp_ajax_apimo_shortcode_pagination", 'apimo_shortcode_pagination');



add_action("wp_ajax_nopriv_apimo_shortcode_pagination", 'apimo_shortcode_pagination');



function apimo_shortcode_pagination()

{







    global $apimo_dir, $apimo_url;



    $paged = filter_var($_POST['page'], FILTER_SANITIZE_NUMBER_INT);

    $posts_per_page = filter_var($_POST['no_of_post'], FILTER_SANITIZE_NUMBER_INT);

    $included_post = sanitize_text_field($_POST['included_post']);



    $args = array(

        'post_type' => 'property',

        'paged' => $paged,

        'posts_per_page' => $posts_per_page,

        'post__in' => explode(",", $included_post)

    );



    // $args = array(



    //     'post_type' => 'property',



    //     'paged' => $_POST['page'],



    //     'posts_per_page' => $_POST['no_of_post'],



    //     'post__in' => explode(",", $_POST['included_post'])



    // );







    $loop = new WP_Query($args);



    if ($loop->have_posts()) {



        while ($loop->have_posts()) {



            $loop->the_post();



            global $post;


            include $apimo_dir . '/templates/template_archive_block.php';

        }

    }







    die();

}











add_action("wp_ajax_apimo_archive_filter", 'apimo_archive_filter');



add_action("wp_ajax_nopriv_apimo_archive_filter", 'apimo_archive_filter');



function apimo_archive_filter()

{





    global $apimo_dir, $apimo_url;



    $args = array(



        'post_type' => 'property',



        'posts_per_page' => filter_var($_POST['size'], FILTER_SANITIZE_NUMBER_INT),



        'paged' => filter_var($_POST['page'], FILTER_SANITIZE_NUMBER_INT),



    );







    $args['meta_query']['relation'] = 'AND';







    // if ((filter_var(INPUT_POST['number_of_rooms'], FILTER_VALIDATE_INT) !== false && filter_var(INPUT_POST['number_of_rooms'], FILTER_VALIDATE_INT) != 0) || (filter_var(INPUT_POST['number_of_bedrooms'], FILTER_VALIDATE_INT) !== false && filter_var(INPUT_POST['number_of_bedrooms'], FILTER_VALIDATE_INT) != 0)) {

    // if ((isset($_POST['number_of_rooms']) && is_numeric($_POST['number_of_rooms']) && (int)$_POST['number_of_rooms'] != 0) || (isset($_POST['number_of_bedrooms']) && is_numeric($_POST['number_of_bedrooms']) && (int)$_POST['number_of_bedrooms'] != 0)) { /* Your logic here */



    if ((filter_var($_POST['number_of_rooms'], FILTER_VALIDATE_INT) !== false && (int)$_POST['number_of_rooms'] != 0) ||

        (filter_var($_POST['number_of_bedrooms'], FILTER_VALIDATE_INT) !== false && (int)$_POST['number_of_bedrooms'] != 0)

    ) {











        $temp_query['relation'] = 'AND';





        if (

            filter_var($_POST['number_of_rooms'], FILTER_VALIDATE_INT) !== false

            &&

            filter_var($_POST['number_of_rooms'], FILTER_VALIDATE_INT) != 0

        ) {



            $temp_query[] = array(



                'key' => 'apimo_rooms',



                'value' => filter_var($_POST['number_of_rooms'], FILTER_VALIDATE_INT),



                'type' => 'NUMERIC',



                'compare' => '='



            );

        }



        if (

            filter_var($_POST['number_of_bedrooms'], FILTER_VALIDATE_INT) !== false

            &&

            filter_var($_POST['number_of_bedrooms'], FILTER_VALIDATE_INT) != 0

        ) {



            $temp_query[] = array(



                'key' => 'apimo_bedrooms',



                'value' => filter_var($_POST['number_of_bedrooms'], FILTER_VALIDATE_INT),



                'type' => 'NUMERIC',



                'compare' => '='



            );

        }



        $args['meta_query'][] = $temp_query;

    }











    $is_price_query = false;



    if (

        filter_var($_POST['price_range_min'], FILTER_VALIDATE_INT) !== false

        &&

        filter_var($_POST['price_range_max'], FILTER_VALIDATE_INT) !== false

    ) {





        $is_price_query = true;



        $args['meta_query']['price_meta_query']['relation'] = 'AND';



        $args['meta_query']['price_meta_query'][] = [



            'key' => 'apimo_price',



            'value' => filter_var($_POST['price_range_min'], FILTER_VALIDATE_INT),



            'type' => 'NUMERIC',



            'compare' => '>='



        ];



        $args['meta_query']['price_meta_query'][] = [



            'key' => 'apimo_price',



            'value' => filter_var($_POST['price_range_max'], FILTER_VALIDATE_INT),



            'type' => 'NUMERIC',



            'compare' => '<='



        ];

    } else if (

        filter_var($_POST['price_range_min'], FILTER_VALIDATE_INT) !== false

        && filter_var($_POST['price_range_max'], FILTER_VALIDATE_INT) == false

    ) {









        $is_price_query = true;



        $args['meta_query']['price_meta_query'] = [



            'key' => 'apimo_price',



            'value' => filter_var($_POST['price_range_min'], FILTER_VALIDATE_INT),



            'compare' => '>='



        ];

    } else if (

        filter_var($_POST['price_range_min'], FILTER_VALIDATE_INT) == false

        && filter_var($_POST['price_range_max'], FILTER_VALIDATE_INT) !== false

    ) {



        $is_price_query = true;



        $args['meta_query']['price_meta_query'] = [



            'key' => 'apimo_price',



            'value' => filter_var($_POST['price_range_max']),



            'type' => 'NUMERIC',



            'compare' => '<='



        ];

    }







    $is_area_query = false;





    if (

        filter_var($_POST['property_areas_min'], FILTER_VALIDATE_INT) !== false

        &&

        filter_var($_POST['property_areas_max'], FILTER_VALIDATE_INT) !== false

    ) {



        $is_area_query = true;



        $args['meta_query']['area_query']['relation'] = 'AND';



        $args['meta_query']['area_query'][] = [



            'key' => 'apimo_area_display_filter',



            'value' => filter_var($_POST['property_areas_min'], FILTER_VALIDATE_INT),



            'type' => 'NUMERIC',



            'compare' => '>='



        ];



        $args['meta_query']['area_query'][] = [



            'key' => 'apimo_area_display_filter',



            'value' => filter_var($_POST['property_areas_max'], FILTER_VALIDATE_INT),



            'type' => 'NUMERIC',



            'compare' => '<='



        ];

    } else if (

        filter_var($_POST['property_areas_min'], FILTER_VALIDATE_INT) !== false

        &&

        filter_var($_POST['property_areas_max'], FILTER_VALIDATE_INT) == false

    ) {





        $is_area_query = true;



        $args['meta_query']['area_query'][] = [



            'key' => 'apimo_area_display_filter',



            'value' => filter_var($_POST['property_areas_min'], FILTER_VALIDATE_INT),



            'compare' => '>='



        ];

    } else if (

        filter_var($_POST['property_areas_min'], FILTER_VALIDATE_INT) == false

        &&

        filter_var($_POST['property_areas_max'], FILTER_VALIDATE_INT) !== false

    ) {





        $is_area_query = true;



        $args['meta_query']['area_query'][] = [



            'key' => 'apimo_area_display_filter',



            'value' => filter_var($_POST['property_areas_max'], FILTER_VALIDATE_INT),



            'type' => 'NUMERIC',



            'compare' => '<='



        ];

    }





    





    // advanced search : 

    

    if (!empty($_POST['advance_area'])) {

        $advance_area = $_POST['advance_area'];

    

        if (is_array($advance_area) && !empty($advance_area)) {

            foreach ($advance_area as $area) {

                // Sanitize each area term ID

                $sanitized_area = intval($area); // Use intval for term IDs

                $args['tax_query'][] = array(

                    'taxonomy' => 'apimo_areas',

                    'field' => 'term_id',

                    'terms' => $sanitized_area,

                );

            }

        }

    }







    if (!empty($_POST['advance_service'])) {

        // Sanitize the input

        $advance_service = $_POST['advance_service'];



        // Validate the input

        if (is_array($advance_service) && !empty($advance_service)) {

            foreach ($advance_service as $service) {

                // Validate the term ID

                $sanitized_service = intval($service); // Use intval for term IDs



                $args['tax_query'][] = array(

                    'taxonomy' => 'apimo_service',

                    'field' => 'term_id',

                    'terms' => $sanitized_service,

                    // 'compare' => 'IN'

                );

            }

        }

    }









    if (!empty($_POST['category_filter'])) {

        // Sanitize the input

        $category_filter = sanitize_text_field($_POST['category_filter']);



        // Validate the input



        $args['tax_query'][] = array(

            'taxonomy' => 'apimo_category',

            'field' => 'term_id',

            // Escape the input

            'terms' => esc_attr($category_filter)

        );

    }







    if (!empty($_POST['subtype_filter'])) {

        // Sanitize the input

        $subtype_filter = sanitize_text_field($_POST['subtype_filter']);



        $args['tax_query'][] = array(

            'taxonomy' => 'apimo_subtype',

            'field' => 'term_id',

            // Escape the input

            'terms' => esc_attr($subtype_filter)

        );

    }















    if (!empty($_POST['country'])) {

        // Sanitize and escape the input

        $country = sanitize_text_field($_POST['country']);



        $args['tax_query'][] = array(

            'taxonomy' => 'country',

            'field' => 'name__in',

            'terms' => esc_attr($country)

        );

    }









    if (!empty($_POST['region'])) {

        // Sanitize and escape the input

        $region = sanitize_text_field($_POST['region']);



        $args['tax_query'][] = array(

            'taxonomy' => 'region',

            'field' => 'name__in',

            'terms' => esc_attr($region)

        );

    }









    if (!empty($_POST['city'])) {

        // Sanitize and escape the input

        $city = sanitize_text_field($_POST['city']);



        $args['tax_query'][] = array(

            'taxonomy' => 'city',

            'field' => 'name__in',

            'terms' => esc_attr($city)

        );

    }



    if (!empty($_POST['zone'])) {

        // Sanitize and escape the input

        $zone = sanitize_text_field($_POST['zone']);

	if ($zone == '1') { //etna
		//$citta_etna = array(56,94);
		global $wpdb;
		$citta= $wpdb->get_col( 
			$wpdb->prepare("SELECT DISTINCT term_id FROM {$wpdb->terms} WHERE term_group = 1") 
		);
        	$args['tax_query'][] = array(
            		'taxonomy' => 'city',
            		'field' => 'name__in',
            		'terms' =>  $citta,
        	);
	}

	if ($zone == '2') { //messina
		//$citta_etna = array(56,94);
		global $wpdb;
		$citta= $wpdb->get_col( 
			$wpdb->prepare("SELECT DISTINCT term_id FROM {$wpdb->terms} WHERE term_group = 2") 
		);
        	$args['tax_query'][] = array(
            		'taxonomy' => 'city',
            		'field' => 'name__in',
            		'terms' =>  $citta,
        	);
	}


	if ($zone == '3') { //madonie
		//$citta_etna = array(56,94);
		global $wpdb;
		$citta= $wpdb->get_col( 
			$wpdb->prepare("SELECT DISTINCT term_id FROM {$wpdb->terms} WHERE term_group = 3") 
		);
        	$args['tax_query'][] = array(
            		'taxonomy' => 'city',
            		'field' => 'name__in',
            		'terms' =>  $citta,
        	);
	}


	if ($zone == '4') { //south
		//$citta_etna = array(56,94);
		global $wpdb;
		$citta= $wpdb->get_col( 
			$wpdb->prepare("SELECT DISTINCT term_id FROM {$wpdb->terms} WHERE term_group = 4") 
		);
        	$args['tax_query'][] = array(
            		'taxonomy' => 'city',
            		'field' => 'name__in',
            		'terms' =>  $citta,
        	);
	}


	if ($zone == '5') { //qwest
		//$citta_etna = array(56,94);
		global $wpdb;
		$citta= $wpdb->get_col( 
			$wpdb->prepare("SELECT DISTINCT term_id FROM {$wpdb->terms} WHERE term_group = 5") 
		);
        	$args['tax_query'][] = array(
            		'taxonomy' => 'city',
            		'field' => 'name__in',
            		'terms' =>  $citta,
        	);
	}



    }






    if (!empty($_POST['district'])) {

        // Sanitize and escape the input

        $district = sanitize_text_field($_POST['district']);



        $args['tax_query'][] = array(

            'taxonomy' => 'district',

            'field' => 'name__in',

            'terms' => esc_attr($district)

        );

    }













    if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {

        // Validate the input

        $start_date = sanitize_text_field($_POST['start_date']);

        $end_date = sanitize_text_field($_POST['end_date']);



        if ($_POST['date_filter_type'] == 'created_at' || $_POST['date_filter_type'] == 'published_at') {

            $args['meta_query'][] = array(

                'key' => 'apimo_created_at',

                'value' => array(

                    // Escape the input

                    esc_attr(date('Y-m-d 00:00:00', strtotime($start_date))),

                    esc_attr(date('Y-m-d 00:00:00', strtotime($end_date)))

                ),

                'compare' => 'BETWEEN',

                'type' => 'DATETIME'

            );

        }

        if ($_POST['date_filter_type'] == 'updated_at') {

            $args['meta_query'][] = array(

                'key' => 'apimo_updated_at',

                'value' => array(

                    // Escape the input

                    esc_attr($start_date),

                    esc_attr($end_date)

                ),

                'compare' => 'BETWEEN',

                'type' => 'DATETIME'

            );

        }

    }





    $args['tax_query']['relation'] = 'AND';







    if (isset($_POST['order_by'])):



        // $order_by = $_POST['order_by'];

        $order_by = sanitize_text_field($_POST['order_by']);





        if ($order_by == 'price_low_to_high') {



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'price_meta_query' => 'ASC');



            if (!$is_price_query) {



                $args['meta_query']['price_meta_query'] = array(



                    'key' => 'apimo_price',



                    'compare' => 'EXISTS',



                    'type' => 'numeric',



                );

            }

        } else if ($order_by == 'price_high_to_low') {



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'price_meta_query' => 'DESC');



            if (!$is_price_query) {



                $args['meta_query']['price_meta_query'] = array(



                    'key' => 'apimo_price',



                    'compare' => 'EXISTS',



                    'type' => 'numeric',



                );

            }

        } else if ($order_by == 'area_low_to_high') {



            // $args['meta_key'] = 'apimo_area_display_filter';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'ASC';



            if (!$is_area_query) {



                $args['meta_query']['area_query'] = array(



                    'key' => 'apimo_area_display_filter',



                    'compare' => 'EXISTS'



                );

            }



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'area_query' => 'ASC');

        } else if ($order_by == 'area_high_to_low') {



            // $args['meta_key'] = 'apimo_area_display_filter';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'DESC';



            if (!$is_area_query) {



                $args['meta_query']['area_query'] = array(



                    'key' => 'apimo_area_display_filter',



                    'compare' => 'EXISTS'



                );

            }



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'area_query' => 'DESC');

        } else if ($order_by == 'bedrooms_low_to_high') {



            // $args['meta_key'] = 'apimo_bedrooms';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'ASC';



            $args['meta_query']['bed_room_query'] = array(



                'key' => 'apimo_bedrooms',



                'compare' => 'EXISTS'



            );



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'bed_room_query' => 'ASC');

        } else if ($order_by == 'bedrooms_high_to_low') {



            // $args['meta_key'] = 'apimo_bedrooms';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'DESC';



            $args['meta_query']['apimo_bedrooms_query'] = array(



                'key' => 'apimo_bedrooms',



                'compare' => 'EXISTS'



            );



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'apimo_bedrooms_query' => 'DESC');

        } else if ($order_by == 'rooms_low_to_high') {



            // $args['meta_key'] = 'apimo_rooms';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'ASC';



            $args['meta_query']['apimo_rooms_query'] = array(



                'key' => 'apimo_rooms',



                'compare' => 'EXISTS'



            );



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'apimo_rooms_query' => 'ASC');

        } else if ($order_by == 'rooms_high_to_low') {



            // $args['meta_key'] = 'apimo_rooms';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'DESC';



            $args['meta_query']['apimo_rooms_query'] = array(



                'key' => 'apimo_rooms',



                'compare' => 'EXISTS'



            );



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'apimo_rooms_query' => 'DESC');

        } else if ($order_by == 'created_at_low_to_high') {



            // $args['meta_key'] = 'apimo_created_at';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'ASC';



            $args['meta_query']['apimo_created_at_query'] = array(



                'key' => 'apimo_created_at',



                'compare' => 'EXISTS'



            );



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'apimo_created_at_query' => 'ASC');

        } else if ($order_by == 'created_at_high_to_low') {



            // $args['meta_key'] = 'apimo_created_at';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'DESC';



            $args['meta_query']['apimo_created_at_query'] = array(



                'key' => 'apimo_created_at',



                'compare' => 'EXISTS'



            );



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'apimo_created_at_query' => 'DESC');

        } else if ($order_by == 'updated_at_low_to_high') {



            // $args['meta_key'] = 'apimo_updated_at';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'ASC';



            $args['meta_query']['apimo_updated_at_query'] = array(



                'key' => 'apimo_updated_at',



                'compare' => 'EXISTS'



            );



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'apimo_updated_at_query' => 'ASC');

        } else if ($order_by == 'updated_at_high_to_low') {



            // $args['meta_key'] = 'apimo_updated_at';



            // $args['orderby']  = 'meta_value_num';



            // $args['order']  = 'DESC';



            $args['meta_query']['apimo_updated_at_Query'] = array(



                'key' => 'apimo_updated_at',



                'compare' => 'EXISTS'



            );







            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'apimo_updated_at_Query' => 'DESC');

        } else if ($order_by == 'published_at_low_to_high') {



            // $args['orderby']  = 'date';



            // $args['order']  = 'ASC';



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'date' => 'ASC');

        } else if ($order_by == 'published_at_high_to_low') {



            // $args['orderby']  = 'date';



            // $args['order']  = 'DESC';



            $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'date' => 'DESC');

        } else {



            $args['orderby'] = array('price_hide_meta_query' => 'DESC');

        }



    endif;



    $args['meta_query']['price_hide_meta_query'] = array(



        'key' => 'apimo_price_hide',



        'compare' => 'EXISTS'



    );







    /**shortcode*/



    foreach ($_POST as $att_key => $att_value) {



        // Sanitize the input value

        $att_value = sanitize_text_field($att_value);



        if (substr($att_key, 0, 4) == 'tax_') {



            $args['tax_query'][] = array(



                'taxonomy' => str_replace('tax_', '', $att_key),



                'field' => 'term_id',



                'terms' => explode(',', $att_value)



            );

        }



        if (substr($att_key, 0, 5) == 'meta_') {



            if (count(explode(',', $att_value)) > 1) {



                $args['meta_query'][] = array(



                    'key' => str_replace('meta_', '', $att_key),



                    'value' => explode(',', $att_value),



                    'compare' => 'IN'



                );

            } else if (count(explode('-', $att_value)) > 1) {



                $args['meta_query'][] = array(



                    'key' => str_replace('meta_', '', $att_key),



                    'value' => array(explode('-', $att_value)[0], explode('-', $att_value)[1]),



                    'compare' => 'BETWEEN',



                    'type' => 'numeric',



                );

            } else {



                $args['meta_query'][] = array(



                    'key' => str_replace('meta_', '', $att_key),



                    'value' => $att_value



                );

            }

        }

    }







    if (isset($_POST['repository_tags']) && !empty($_POST['repository_tags']) && is_array($_POST['repository_tags'])) {

        $repository_tags = array_map('sanitize_text_field', $_POST['repository_tags']);

        $args['tax_query'][] = array(

            'taxonomy' => 'repository_tags',

            'terms' => $repository_tags,

            'operator' => 'IN'

        );

    }









    if (isset($_POST['customised_tags']) && !empty($_POST['customised_tags']) && is_array($_POST['customised_tags'])) {

        $customised_tags = array_map('sanitize_text_field', $_POST['customised_tags']);

        $args['tax_query'][] = array(

            'taxonomy' => 'customised_tags',

            'terms' => $customised_tags,

            'operator' => 'IN'

        );

    }





    /**shortcode*/











    $loop = new WP_Query($args);







    ob_start();



    // echo '<pre>';



    // print_r($args);



    // print_r($loop);



    // echo '</pre>';



    $apimo_archive_settings = get_option('apimo_style_archive');



    // echo '<pre>';



    // print_r($args);



    // print_r($loop->request);



    // echo '</pre>';



    $apimo_filter = $apimo_archive_settings['filter'];



    $apimo_data_id = rand();







    if (isset($_POST['desktop']) && is_numeric($_POST['desktop'])) {



        $desktop = sanitize_text_field($_POST['desktop']);

        $grid_desktop = 'column-desktop-' . $desktop;

    }

    if (isset($_POST['tablet']) && is_numeric($_POST['tablet'])) {



        $tablet = sanitize_text_field($_POST['tablet']);

        $grid_tablet = 'column-tablet-' . $tablet;

    }

    if (isset($_POST['mobile']) && is_numeric($_POST['mobile'])) {



        $mobile = sanitize_text_field($_POST['mobile']);

        $grid_mobile = 'column-mobile-' . $mobile;

    }







    if ($loop->have_posts()) {



        while ($loop->have_posts()) {



            $loop->the_post();



            global $post;







?>







            <div class="<?php



                        echo esc_html($grid_desktop) . ' ' . esc_html($grid_tablet) . ' ' . esc_html($grid_mobile);



                        ?>">



                <?php



                include $apimo_dir . '/templates/template_archive_block.php';



                ?>



            </div>



<?php



        }

    } else {



        _e('No property with all this applied filter', 'apimo');

    }



    $loop_data = ob_get_contents();



    ob_end_clean();







    echo json_encode(array('loop_data' => $loop_data, 'max_page' => $loop->max_num_pages, 'found_posts' => $loop->found_posts));



    die();

}



add_action('wp_ajax_apimo_save_shortcode', 'apimo_save_shortcode');

add_action('wp_ajax_nopriv_apimo_save_shortcode', 'apimo_save_shortcode');



function apimo_save_shortcode()

{

    // Get the existing shortcode array from the option

    $existing_shortcodes = get_option('apimo_shortcodes', array());



    // Calculate the next index

    // $next_index = count($existing_shortcodes);



    // Add the new shortcode data to the array with the calculated index



    $title = sanitize_text_field($_POST['title']);

    $description = sanitize_text_field($_POST['description']);

    $shortcode = sanitize_text_field($_POST['shortcode']);



    $new_shortcode = array(

        'Title' => $title,

        'Description' => $description,

        'Shortcode' => $shortcode,

    );



    $existing_shortcodes[uniqid()] = $new_shortcode;



    // Update the option with the updated array



    update_option('apimo_shortcodes', $existing_shortcodes);







    wp_die(); // Terminate the script

}



add_action('wp_ajax_apimo_delete_shortcode', 'apimo_delete_shortcode');

add_action('wp_ajax_nopriv_apimo_delete_shortcode', 'apimo_delete_shortcode');



function apimo_delete_shortcode()

{

    $shortcodeIndex = $_POST['shortcode_index'];

    $shortcodes = get_option('apimo_shortcodes', array());



    if (isset($shortcodes[$shortcodeIndex])) {

        unset($shortcodes[$shortcodeIndex]);

        update_option('apimo_shortcodes', $shortcodes);



        echo 'Shortcode deleted successfully.';

    } else {

        echo 'Failed to delete the shortcode.';

    }



    wp_die(); // Terminate the script

}


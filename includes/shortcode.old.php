<?php



add_shortcode('apimo', 'apimo_list_callback');







function apimo_list_callback($attrs)
{

    ob_start();





    // echo '<pre>';

    // print_r($attrs);

    // echo '</pre>';

    global $wpdb, $apimo_dir;










    $normal_filter = isset($attrs['normal_filter']) ? sanitize_text_field($attrs['normal_filter']) : '';




    if (is_string($normal_filter) && strpos($normal_filter, ',') !== false) {
        $apimo_filter = array_map('esc_attr', explode(',', $normal_filter));
    } else {
        $apimo_filter = array();
    }


    $advanced_filter = isset($attrs['advance_filter']) ? sanitize_text_field($attrs['advance_filter']) : '';

    if (is_string($advanced_filter) && strpos($advanced_filter, ',') !== false) {
        $advance_filter_data = array_map('esc_attr', explode(',', $advanced_filter));
    } else {
        $advance_filter_data = array();
    }














    if (!empty($advance_filter_data)) {

        $apimo_filter['advance'] = $advance_filter_data;
    }






    $no_of_post = isset($attrs['no_of_post']) ? $attrs['no_of_post'] : -1;

    $no_of_post = (int) $no_of_post;

    if (!is_int($no_of_post) || $no_of_post < 0) {
        $no_of_post = 10;
    }

    $post_per_page = '';

    if (isset($attrs['post_limit'])) {
        $post_per_page = $attrs['post_limit'];
    } else {
        $post_per_page = $no_of_post;
    }

    $args = array(
        'post_type' => 'property',
        'posts_per_page' => $post_per_page,
    );







    $apimo_data_id = rand();





    $grid_desktop = 'column-desktop-' . $attrs['desktop'];

    $grid_tablet = 'column-tablet-' . $attrs['tablet'];

    $grid_mobile = 'column-mobile-' . $attrs['mobile'];

    if (empty($apimo_filter)) {
        if (isset($_GET['number_of_bedrooms'])) {
            if (!empty($_GET['number_of_bedrooms'])) {
                $attrs['number_of_bedrooms'] = $_GET['number_of_bedrooms'];
            } else {
                unset($attrs['number_of_bedrooms']);
            }
        }

        if (isset($_GET['price_range_min'])) {
            if (!empty($_GET['price_range_min'])) {
                $attrs['price_range_min'] = $_GET['price_range_min'];
            } else {
                unset($attrs['price_range_min']);
            }
        }

        if (isset($_GET['price_range_max'])) {
            if (!empty($_GET['price_range_max'])) {
                $attrs['price_range_max'] = $_GET['price_range_max'];
            } else {
                unset($attrs['price_range_max']);
            }
        }

        if (isset($_GET['property_areas_min'])) {
            if (!empty($_GET['property_areas_min'])) {
                $attrs['property_areas_min'] = $_GET['property_areas_min'];
            } else {
                unset($attrs['property_areas_min']);
            }
        }

        if (isset($_GET['property_areas_max'])) {
            if (!empty($_GET['property_areas_max'])) {
                $attrs['property_areas_max'] = $_GET['property_areas_max'];
            } else {
                unset($attrs['property_areas_max']);
            }
        }

        if (isset($_GET['category_filter'])) {
            if (!empty($_GET['category_filter'])) {
                $attrs['category_filter'] = $_GET['category_filter'];
            } else {
                unset($attrs['category_filter']);
            }
        }

        if (isset($_GET['subtype_filter'])) {
            if (!empty($_GET['subtype_filter'])) {
                $attrs['subtype_filter'] = $_GET['subtype_filter'];
            } else {
                unset($attrs['subtype_filter']);
            }
        }

        if (isset($_GET['advance_area'])) {
            if (!empty($_GET['advance_area'])) {
                $attrs['advance_area'] = $_GET['advance_area'];
            } else {
                unset($attrs['advance_area']);
            }
        }

        if (isset($_GET['advance_service'])) {
            if (!empty($_GET['advance_service'])) {
                $attrs['advance_service'] = $_GET['advance_service'];
            } else {
                unset($attrs['advance_service']);
            }
        }
    }
    if (!isset($attrs['no_of_post'])) {

        $attrs['no_of_post'] = 12;
    }


    if (isset($attrs['proprty_selection_types']) && sanitize_text_field($attrs['proprty_selection_types']) == 'property') {

        if (isset($attrs['properties']) && !empty($attrs['properties']) && is_string($attrs['properties'])) {

            $properties = sanitize_text_field($attrs['properties']);
            $properties_array = explode(",", $properties);

            if (is_array($properties_array)) {

                $args['post__in'] = array_map('intval', $properties_array);
            }
        }
    }








    if (isset($attrs['proprty_selection_types']) && sanitize_text_field($attrs['proprty_selection_types']) == 'tags') {
        $args['tax_query'] = array();
        if (isset($attrs['repository_tags']) && !empty($attrs['repository_tags']) && is_string($attrs['repository_tags'])) {
            $repository_tags = sanitize_text_field($attrs['repository_tags']);
            $repository_tags_array = explode(",", $repository_tags);
            if (is_array($repository_tags_array)) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'repository_tags',
                    'terms' => array_map('intval', $repository_tags_array),
                    'operator' => 'IN'
                );
            }
        }
        if (isset($attrs['customised_tags']) && !empty($attrs['customised_tags']) && is_string($attrs['customised_tags'])) {
            $customised_tags = sanitize_text_field($attrs['customised_tags']);
            $customised_tags_array = explode(",", $customised_tags);
            if (is_array($customised_tags_array)) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'customised_tags',
                    'terms' => array_map('intval', $customised_tags_array),
                    'operator' => 'IN'
                );
            }
        }
    }


    if (isset($attrs['proprty_selection_types']) && $attrs['proprty_selection_types'] == 'filter') :

        $args['meta_query']['relation'] = 'AND';


        if ((isset($attrs['number_of_rooms']) && !empty($attrs['number_of_rooms']) && is_numeric($attrs['number_of_rooms'])) || (isset($attrs['number_of_bedrooms']) && !empty($attrs['number_of_bedrooms']) && is_numeric($attrs['number_of_bedrooms']))) {

            $temp_query['relation'] = 'AND';
            if (isset($attrs['number_of_rooms']) && !empty($attrs['number_of_rooms']) && is_numeric($attrs['number_of_rooms'])) {
                $temp_query[] = array(
                    'key' => 'apimo_rooms',
                    'value' => intval($attrs['number_of_rooms']),
                    'type' => 'NUMERIC',
                    'compare' => '='
                );
            }
            if (isset($attrs['number_of_bedrooms']) && !empty($attrs['number_of_bedrooms']) && is_numeric($attrs['number_of_bedrooms'])) {
                $temp_query[] = array(
                    'key' => 'apimo_bedrooms',
                    'value' => intval($attrs['number_of_bedrooms']),
                    'type' => 'NUMERIC',
                    'compare' => '='
                );
            }
            $args['meta_query'][] = $temp_query;
        }











        $is_price_query = false;
        if (isset($attrs['price_range_min']) && !empty($attrs['price_range_min']) && is_numeric($attrs['price_range_min']) && isset($attrs['price_range_max']) && !empty($attrs['price_range_max']) && is_numeric($attrs['price_range_max'])) {


            $is_price_query = true;
            $args['meta_query']['price_meta_query']['relation'] = 'AND';
            $args['meta_query']['price_meta_query'][] = [
                'key' => 'apimo_price',
                'value' => intval($attrs['price_range_min']),
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
            $args['meta_query']['price_meta_query'][] = [
                'key' => 'apimo_price',
                'value' => intval($attrs['price_range_max']),
                'type' => 'NUMERIC',
                'compare' => '<='
            ];
        } else if (isset($attrs['price_range_min']) && !empty($attrs['price_range_min']) && is_numeric($attrs['price_range_min']) && (isset($attrs['price_range_max']) && empty($attrs['price_range_max']))) {


            $is_price_query = true;
            $args['meta_query']['price_meta_query'] = [
                'key' => 'apimo_price',
                'value' => intval($attrs['price_range_min']),
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        } else if (isset($attrs['price_range_max']) && !empty($attrs['price_range_max']) && is_numeric($attrs['price_range_max']) && (isset($attrs['price_range_min']) && empty($attrs['price_range_min']))) {


            $is_price_query = true;
            $args['meta_query']['price_meta_query'] = [
                'key' => 'apimo_price',
                'value' => intval($attrs['price_range_max']),
                'type' => 'NUMERIC',
                'compare' => '<='
            ];
        }






        $is_area_query = false;






        if (isset($attrs['property_areas_min']) && !empty($attrs['property_areas_min']) && is_numeric($attrs['property_areas_min']) && isset($$attrs['property_areas_max']) && !empty($attrs['property_areas_max']) && is_numeric($attrs['property_areas_max'])) {

            $is_area_query = true;

            $args['meta_query']['area_query']['relation'] = 'AND';

            $args['meta_query']['area_query'][] = [

                'key' => 'apimo_area_display_filter',

                'value' => intval($attrs['property_areas_min']),

                'type' => 'NUMERIC',

                'compare' => '>='

            ];

            $args['meta_query']['area_query'][] = [

                'key' => 'apimo_area_display_filter',

                'value' => intval($attrs['property_areas_max']),

                'type' => 'NUMERIC',

                'compare' => '<='

            ];
        } elseif (isset($attrs['property_areas_min']) && !empty($attrs['property_areas_min']) && is_numeric($attrs['property_areas_min']) && isset($attrs['property_areas_max']) && empty($attrs['property_areas_max'])) {


            $is_area_query = true;

            $args['meta_query']['area_query'][] = [

                'key' => 'apimo_area_display_filter',

                'value' => intval($attrs['property_areas_min']),

                'compare' => '>='

            ];
        } elseif (isset($attrs['property_areas_max']) && !empty($attrs['property_areas_max']) && is_numeric($attrs['property_areas_max']) && isset($attrs['property_areas_min']) && empty($attrs['property_areas_min'])) {

            $is_area_query = true;

            $args['meta_query']['area_query'][] = [

                'key' => 'apimo_area_display_filter',

                'value' => intval($attrs['property_areas_max']),

                'type' => 'NUMERIC',

                'compare' => '<='

            ];
        }







        if (!empty($attrs['advance_area'])) {
            $areas = explode(',', $attrs['advance_area']);
            foreach ($areas as $area) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'apimo_areas',
                    'field' => 'term_id',
                    'terms' => $area,
                    //    'comapre' => 'IN'
                );
            }
        }






        if (!empty($attrs['advance_service'])) {
            $services = explode(',', $attrs['advance_service']);
            foreach ($services as $service) {

                $args['tax_query'][] = array(

                    'taxonomy' => 'apimo_service',

                    'field' => 'term_id',

                    'terms' => $service,

                    // 'comapre' => 'IN'

                );
            }
        }

        if (!empty($attrs['country'])) {

            $args['tax_query'][] = array(

                'taxonomy' => 'country',

                'field' => 'term_id',

                'terms' => $attrs['country']

            );
        }

        if (!empty($attrs['region'])) {

            $args['tax_query'][] = array(

                'taxonomy' => 'region',

                'field' => 'term_id',

                'terms' => $attrs['region']

            );
        }

        if (!empty($attrs['city'])) {

            $args['tax_query'][] = array(

                'taxonomy' => 'city',

                'field' => 'term_id',

                'terms' => $attrs['city'],

            );
        }

        if (!empty($attrs['district'])) {

            $args['tax_query'][] = array(

                'taxonomy' => 'district',

                'field' => 'term_id',

                'terms' => $attrs['district']

            );
        }





        if (!empty($attrs['start_date']) && !empty($attrs['end_date'])) {

            if ($attrs['date_filter_type'] == 'created_at' || $attrs['date_filter_type'] == 'published_at') {

                $args['meta_query'][] = array(

                    'key' => 'apimo_created_at',

                    'value' => array(date('Y-m-d 00:00:00', strtotime($attrs['start_date'])), date('Y-m-d 00:00:00', strtotime($attrs['end_date']))),

                    'compare' => 'BETWEEN',

                    'type' => 'DATETIME'

                );
            }

            if ($attrs['date_filter_type'] == 'updated_at') {

                $args['meta_query'][] = array(

                    'key' => 'apimo_updated_at',

                    'value' => array($attrs['start_date'], $attrs['end_date']),

                    'compare' => 'BETWEEN',

                    'type' => 'DATETIME'

                );
            }
        }





        // echo '<pre>';

        // print_r($attrs);

        // echo '</pre>';





        foreach ($attrs as $att_key => $att_value) {

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



        if (isset($attrs['category_filter'])) {

            $args['tax_query'][] = array(

                'taxonomy' => 'apimo_category',

                'field' => 'term_id',

                'terms' => $attrs['category_filter']

            );
        }

        if (isset($attrs['subtype_filter'])) {

            $args['tax_query'][] = array(

                'taxonomy' => 'apimo_subtype',

                'field' => 'term_id',

                'terms' => $attrs['subtype_filter']

            );
        }







        $args['tax_query']['relation'] = 'AND';





        if (isset($attrs['order_by']) && !empty($attrs['order_by'])) :

            $order_by = $attrs['order_by'];

            if ($order_by == 'price_low_to_high') {

                $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'price_meta_query' => 'ASC');

                if (!$is_price_query) {

                    $args['meta_query']['price_meta_query'] = array(

                        'key' => 'apimo_price',

                        'compare' => 'EXISTS'

                    );
                }
            } else if ($order_by == 'price_high_to_low') {

                $args['orderby'] = array('price_hide_meta_query' => 'DESC', 'price_meta_query' => 'DESC');

                if (!$is_price_query) {

                    $args['meta_query'][] = array(

                        'key' => 'apimo_price',

                        'compare' => 'EXISTS'

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

    endif;





    // echo '<pre>';

    // print_r($attrs);

    // print_r($args);

    // echo '</pre>'; 

    // exit;

    // $args = array('post_type'=>'property','posts_per_page'=>1);









    $apimo_query = new WP_Query($args);

    // echo '<pre>';

    // print_r($apimo_query);

    // echo '</pre>';

    $shortcode_id = 'apimo_' . rand();





    if ($apimo_query->have_posts()) :







?>





        <div class="filter-container" <?php if (empty($apimo_filter)) {
                                            echo 'style="display:none!important;"';
                                        } ?>>

            <div class="filter-mobile-toggle">

                <svg id="Modalità_Isolamento" data-name="Modalità Isolamento" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180.48 212.8">

                    <path d="M364,278.8a19,19,0,0,1,3.46-10.05l54.05-69.49c3.8-4.89,1.85-8.86-4.26-8.86H282.75c-6.16,0-8,4-4.26,8.86l54.05,69.49A19,19,0,0,1,336,278.8v76.78a14,14,0,1,0,28,0Zm16.8,76.78a30.8,30.8,0,1,1-61.6,0V278.8c0,.2-54-69.23-54-69.23-12.32-15.84-2.7-36,17.52-36h134.5c20.14,0,29.87,20.09,17.52,36l-54,69.49c.09-.14.08,76.52.08,76.52Z" transform="translate(-259.76 -173.6)"></path>

                </svg>

                <p><?php _e('Filter the properties', 'apimo'); ?></p>

            </div>
            <?php
            $filter_none = '';
            if (isset($attrs['post_limit'])) {
                $filter_none = "style='display:none!important'";
            }

            ?>
            <section <?php echo $filter_none ?> class="apimo-filters apimo-archive-filters" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>">

                <div class="apimo-filter-wrapper">

                    <?php if (in_array('category_filter', $apimo_filter)) : ?>

                        <div class="filter-item">

                            <div class="filter-item-title">

                                <span class="text">

                                    <?php echo _e('Category', 'apimo'); ?>

                                </span>

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                        <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                    </svg>

                                </span>

                            </div>

                            <div class="filter-item-dropdown">

                                <div class="apimo-archive-filter apimo_category_filter" data-id="apimo_category_filter">

                                    <div class="apimo_location_wrap">

                                        <label class="apimo-archive-filter">

                                            <?php _e('Category', 'apimo') ?>

                                        </label>

                                        <select name="apimo_category_filter" data-id="apimo_category_filter" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_select">

                                            <option value=""><?php _e('Select category(ies)', 'apimo') ?></option>

                                            <?php $terms_country = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_category',

                                                    'hide_empty' => false

                                                )
                                            );

                                            foreach ($terms_country as $term_country) :

                                            ?>
                                                <?php if (isset($_GET['category_filter']) && !empty($_GET['category_filter']) && $_GET['category_filter'] == $term_country->term_id) : ?>
                                                    <option selected="selected" value="<?php echo esc_attr($term_country->term_id); ?>">
                                                        <?php _e($term_country->name, 'apimo'); ?></option>
                                                <?php else : ?>
                                                    <option value="<?php echo esc_attr($term_country->term_id); ?>">
                                                        <?php _e($term_country->name, 'apimo'); ?></option>
                                                <?php endif; ?>

                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="apply-filter">

                                    <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply  apimo-apply-filter"><?php _e('Apply filter', 'apimo') ?></button>

                                </div>

                            </div>

                        </div>

                    <?php endif; ?>

                    <?php if (in_array('subtype_filter', $apimo_filter)) : ?>

                        <div class="filter-item">

                            <div class="filter-item-title">

                                <span class="text">

                                    <?php echo _e('Subtype', 'apimo'); ?>

                                </span>

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                        <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                    </svg>

                                </span>

                            </div>

                            <div class="filter-item-dropdown">

                                <div class="apimo-archive-filter apimo_subtype_filter" data-id="apimo_subtype_filter">

                                    <div class="apimo_location_wrap">

                                        <label class="apimo-archive-filter">

                                            <?php _e('Subtype', 'apimo') ?>

                                        </label>

                                        <select name="apimo_subtype_filter" data-id="apimo_subtype_filter" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_select">

                                            <option value=""><?php _e('Select Subtype', 'apimo') ?></option>

                                            <?php $terms_country = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_subtype',

                                                    'hide_empty' => false

                                                )
                                            );

                                            foreach ($terms_country as $term_country) :

                                            ?>
                                                <?php if (isset($_GET['subtype_filter']) && !empty($_GET['subtype_filter']) && $_GET['subtype_filter'] == $term_country->term_id) : ?>
                                                    <option selected="selected" value="<?php echo esc_attr($term_country->term_id); ?>">
                                                        <?php echo esc_html($term_country->name); ?></option>
                                                <?php else : ?>
                                                    <option value="<?php echo esc_attr($term_country->term_id); ?>">
                                                        <?php echo esc_html($term_country->name); ?></option>
                                                <?php endif; ?>

                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="apply-filter">

                                    <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply  apimo-apply-filter"><?php _e('Apply filter', 'apimo') ?></button>

                                </div>

                            </div>

                        </div>

                    <?php endif; ?>

                    <?php if (in_array('location', $apimo_filter)) : ?>

                        <div class="filter-item">

                            <div class="filter-item-title">

                                <span class="text">

                                    <?php echo _e('Place', 'apimo'); ?>

                                </span>

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                        <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                    </svg>

                                </span>

                            </div>

                            <div class="filter-item-dropdown">

                                <div class="apimo-archive-filter apimo_location" data-id="apimo_location">

                                    <div class="apimo_location_wrap">

                                        <label class="apimo-archive-filter">

                                            <?php _e('Country', 'apimo') ?>

                                        </label>

                                        <select name="apimo_country" data-id="apimo_country" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_select">

                                            <option value=""><?php _e('Select country', 'apimo') ?></option>

                                            <?php $terms_country = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'country',

                                                    'hide_empty' => false

                                                )
                                            );

                                            foreach ($terms_country as $term_country) :

                                            ?>
                                                <?php if (isset($_GET['country']) && !empty($_GET['country']) && $_GET['country'] == $term_country->term_id) : ?>
                                                    <option selected="selected" value="<?php echo esc_attr($term_country->term_id); ?>">
                                                        <?php echo esc_html($term_country->name); ?></option>
                                                <?php else : ?>
                                                    <option value="<?php echo esc_attr($term_country->term_id); ?>">
                                                        <?php echo esc_html($term_country->name); ?></option>
                                                <?php endif; ?>

                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                    <div class="apimo_location_wrap">

                                        <label class="apimo-archive-filter">

                                            <?php _e('Region', 'apimo') ?>

                                        </label>

                                        <select name="apimo_region" data-id="apimo_region" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_select">

                                            <option value=""><?php _e('Select region', 'apimo') ?></option>

                                            <?php $terms_region = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'region',

                                                    'hide_empty' => false

                                                )
                                            );

                                            foreach ($terms_region as $term_region) :

                                            ?>
                                                <?php if (isset($_GET['region']) && !empty($_GET['region']) && $_GET['region'] == $term_region->term_id) : ?>
                                                    <option selected="selected" value="<?php echo esc_attr($term_region->term_id); ?>">
                                                        <?php echo esc_html($term_region->name); ?></option>
                                                <?php else : ?>
                                                    <option value="<?php echo esc_attr($term_region->term_id); ?>">
                                                        <?php echo esc_html($term_region->name); ?></option>
                                                <?php endif; ?>

                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                    <div class="apimo_location_wrap">

                                        <label class="apimo-archive-filter">

                                            <?php _e('City', 'apimo') ?>

                                        </label>

                                        <select name="apimo_city" data-id="apimo_city" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_select">

                                            <option value=""><?php _e('Select city', 'apimo') ?></option>

                                            <?php $terms_region = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'city',

                                                    'hide_empty' => false,

                                                    'parent' => 0

                                                )
                                            );

                                            foreach ($terms_region as $term_region) :

                                            ?>
                                                <?php if (isset($_GET['city']) && !empty($_GET['city']) && $_GET['city'] == $term_region->term_id) : ?>
                                                    <option selected="selected" value="<?php echo esc_attr($term_region->term_id); ?>">
                                                        <?php echo esc_html($term_region->name); ?></option>
                                                <?php else : ?>
                                                    <option value="<?php echo esc_attr($term_region->term_id); ?>">
                                                        <?php echo esc_html($term_region->name); ?></option>
                                                <?php endif; ?>

                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                    <div class="apimo_location_wrap">

                                        <label class="apimo-archive-filter">

                                            <?php _e('District', 'apimo') ?>

                                        </label>

                                        <select name="apimo_district" data-id="apimo_district" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_select">

                                            <option value=""><?php _e('Select district', 'apimo') ?></option>

                                            <?php $terms_region = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'district',

                                                    'hide_empty' => false

                                                )
                                            );

                                            foreach ($terms_region as $term_region) :

                                            ?>
                                                <?php if (isset($_GET['district']) && !empty($_GET['district']) && $_GET['district'] == $term_region->term_id) : ?>
                                                    <option selected="selected" value="<?php echo esc_attr($term_region->term_id); ?>">
                                                        <?php echo esc_html($term_region->name); ?></option>
                                                <?php else : ?>
                                                    <option value="<?php echo esc_attr($term_region->term_id); ?>">
                                                        <?php echo esc_html($term_region->name); ?></option>
                                                <?php endif; ?>

                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="apply-filter">

                                    <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply  apimo-apply-filter"><?php _e('Apply filter', 'apimo') ?></button>

                                </div>

                            </div>

                        </div>

                    <?php endif; ?>





                    <?php if (in_array('price_range', $apimo_filter)) : // Price 

                    ?>

                        <div class="filter-item">

                            <div class="filter-item-title">

                                <span class="text">

                                    <?php echo _e('Price', 'apimo'); ?>

                                </span>

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                        <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                    </svg>

                                </span>

                            </div>

                            <div class="filter-item-dropdown">

                                <div class="apimo-archive-filter apimo_price_range" data-id="price_range">

                                    <div class="fiter-range">

                                        <div class="range-from">

                                            <input type="number" min="0" name="price_range_min" data-id="price_range_min" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('From', 'apimo') ?>" value="<?php echo (isset($_GET['price_range_min']) ? esc_attr($_GET['price_range_min']) : ''); ?>">

                                        </div>

                                        <div class="range-to">

                                            <input type="number" min="0" name="price_range_max" data-id="price_range_max" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('To', 'apimo') ?>" value="<?php echo (isset($_GET['price_range_max']) ? esc_attr($_GET['price_range_max']) : ''); ?>">

                                        </div>

                                    </div>

                                    <div class="filter-lists-value">

                                        <div class="list-filter-click">

                                            <ul>

                                                <li><span data-value="0">0 €</span></li>

                                                <li><span data-value="20000">20.000 €</span></li>

                                                <li><span data-value="50000">50.000 €</span></li>

                                                <li><span data-value="80000">80.000 €</span></li>

                                                <li><span data-value="120000">120.000 €</span></li>

                                                <li><span data-value="200000">200.000 €</span></li>

                                                <li><span data-value="350000">350.000 €</span></li>

                                                <li><span data-value="500000">500.000 €</span></li>

                                                <li><span data-value="600000">600.000 €</span></li>

                                                <li><span data-value="1000000">1.000.000 €</span></li>

                                                <li><span data-value="2000000">2.000.000 €</span></li>

                                                <li><span data-value="3000000">3.000.000 €</span></li>

                                                <li><span data-value="5000000">5.000.000 €</span></li>

                                            </ul>

                                        </div>

                                    </div>

                                    <div class="apply-filter">

                                        <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply  apimo-apply-filter"><?php _e('Apply filter', 'apimo') ?></button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endif; ?>





                    <?php if (in_array('property_areas', $apimo_filter)) : ?>

                        <div class="filter-item">

                            <div class="filter-item-title">

                                <span class="text">

                                    <?php echo _e('Area', 'apimo'); ?>

                                </span>

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                        <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                    </svg>

                                </span>

                            </div>

                            <div class="filter-item-dropdown">

                                <div class="apimo-archive-filter apimo_property_areas" data-id="property_areas">

                                    <div class="fiter-range">

                                        <div class="range-from">

                                            <input type="number" min="0" name="property_areas_min" data-id="property_areas_min" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('From', 'apimo') ?>" value="<?php echo (isset($_GET['property_areas_min']) ? esc_attr($_GET['property_areas_min']) : ''); ?>">

                                        </div>

                                        <div class="range-to">

                                            <input type="number" min="0" name="property_areas_max" data-id="property_areas_max" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('To', 'apimo') ?>" value="<?php echo (isset($_GET['property_areas_max']) ? esc_attr($_GET['property_areas_max']) : ''); ?>">

                                        </div>

                                    </div>

                                    <div class="filter-lists-value">

                                        <div class="list-filter-click">

                                            <ul>

                                                <li><span data-value="0">0 m²</span></li>

                                                <li><span data-value="50">50 m²</span></li>

                                                <li><span data-value="100">100 m²</span></li>

                                                <li><span data-value="150">150 m²</span></li>

                                                <li><span data-value="200">200 m²</span></li>

                                                <li><span data-value="250">250 m²</span></li>

                                                <li><span data-value="300">300 m²</span></li>

                                                <li><span data-value="400">400 m²</span></li>

                                                <li><span data-value="500">500 m²</span></li>

                                            </ul>

                                        </div>

                                    </div>

                                    <div class="apply-filter">

                                        <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply  apimo-apply-filter"><?php _e('Apply filter', 'apimo') ?></button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endif; ?>





                    <div class="filter-item">

                        <div class="filter-item-title">

                            <span class="text">

                                <?php echo _e('Rooms', 'apimo'); ?>

                            </span>

                            <span class="icon">

                                <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                    <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                </svg>

                            </span>

                        </div>

                        <div class="filter-item-dropdown">

                            <div class="filters-qty">





                                <?php if (in_array('number_of_rooms', $apimo_filter)) : ?>

                                    <div class="filter-item-qty apimo-archive-filter apimo_number_of_rooms" data-id="number_of_rooms">

                                        <div class="label"><?php _e('Rooms', 'apimo'); ?></div>

                                        <div class="qty-buttons">

                                            <button class="qty qty-minus apimo-qty-minus">-</button>

                                            <input type="number" min="0" name="number_of_rooms" data-id="number_of_rooms" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('0', 'apimo') ?>" value="<?php echo (isset($_GET['number_of_rooms']) ? esc_attr($_GET['number_of_rooms']) : ''); ?>">

                                            <button class="qty qty-plus apimo-qty-plus">+</button>

                                        </div>

                                    </div>

                                <?php endif; ?>

                                <?php if (in_array('number_of_bedrooms', $apimo_filter)) : ?>

                                    <div class="filter-item-qty apimo-archive-filter apimo_number_of_bedrooms" data-id="number_of_bedrooms">

                                        <div class="label"><?php _e('Bathroom', 'apimo'); ?></div>

                                        <div class="qty-buttons">

                                            <button class="qty qty-minus apimo-qty-minus">-</button>

                                            <input type="number" min="0" name="number_of_bedrooms" data-id="number_of_bedrooms" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('0', 'apimo') ?>" value="<?php echo (isset($_GET['number_of_bedrooms']) ? esc_attr($_GET['number_of_bedrooms']) : ''); ?>">

                                            <button class="qty qty-plus  apimo-qty-plus">+</button>

                                        </div>

                                    </div>

                                <?php endif; ?>

                                <div class="apply-filter">

                                    <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply  apimo-apply-filter"><?php _e('Apply filter', 'apimo') ?></button>

                                </div>

                            </div>

                        </div>

                    </div>





                    <?php if (in_array('dates', $apimo_filter)) : ?>

                        <div class="filter-item filter-dates">

                            <div class="filter-item-title">

                                <span class="text">

                                    <?php echo _e('Dates', 'apimo'); ?>

                                </span>

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                        <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                    </svg>

                                </span>

                            </div>

                            <div class="filter-item-dropdown">

                                <div class="apimo-dates-option">

                                    <div class="apimo-archive-filter apimo_dates" data-id="dates">

                                        <div class="apimo_date_filter_radios">

                                            <div class="apimo_date_filter_radio">

                                                <div class="apimo-date-block">

                                                    <input checked="checked" type="radio" id="apimo_date_created_at" value="created_at" name="apimo_date_filter_type" data-id="apimo_date_filter_type" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_filter_input apimo_filter_input_radio" />

                                                    <label for="apimo_date_created_at"><?php _e('created at', 'apimo') ?></label>

                                                </div>

                                            </div>

                                            <div class="apimo_date_filter_radio">

                                                <div class="apimo-date-block">

                                                    <input type="radio" id="apimo_date_published_at" value="published_at" name="apimo_date_filter_type" data-id="apimo_date_published_at" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_filter_input apimo_filter_input_radio" />

                                                    <label for="apimo_date_published_at"><?php _e('published at', 'apimo') ?></label>

                                                </div>

                                            </div>

                                            <div class="apimo_date_filter_radio">

                                                <div class="apimo-date-block">

                                                    <input type="radio" id="apimo_date_updated_at" value="updated_at" name="apimo_date_filter_type" data-id="apimo_date_updated_at" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_filter_input apimo_filter_input_radio" />

                                                    <label for="apimo_date_updated_at"><?php _e('updated at', 'apimo') ?></label>

                                                </div>

                                            </div>

                                        </div>

                                        <input type="hidden" name="apimo_dates_start" data-id="apimo_dates_start" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input_text">

                                        <input type="hidden" name="apimo_dates_end" data-id="apimo_dates_end" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input_text">

                                        <span type="text" name="apimo_dates" data-id="apimo_dates" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_dates_filter_input apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('Dates', 'apimo') ?>">

                                            Select Date

                                        </span>

                                    </div>

                                </div>

                                <div class="apply-filter">

                                    <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply  apimo-apply-filter"><?php _e('Apply filter', 'apimo') ?></button>

                                </div>

                            </div>

                        </div>

                    <?php endif; ?>





                    <?php if (!empty($apimo_filter['advance'])) : ?>

                        <div class="filter-item advance-search">

                            <div class="filter-item-title">

                                <span class="text">

                                    <?php _e('Advanced search', 'apimo'); ?>

                                </span>

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                        <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                    </svg>

                                </span>

                            </div>

                            <div class="filter-item-dropdown">

                                <div class="apimo-aditional-filter">

                                    <?php

                                    $advance_area_array = array();

                                    if (isset($_GET['advance_area']) && !empty($_GET['advance_area'])) {
                                        $advance_area_array = explode(',', $_GET['advance_area']);
                                    }

                                    foreach ($apimo_filter['advance'] as $advance_filter) :

                                        if ($advance_filter == 'garden') :

                                            $term = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 49,

                                                    'hide_empty' => false

                                                )
                                            );

                                    ?>

                                            <div class="apimo-archive-filter apimo_advance_garden" data-id="advance_garden">

                                                <input <?php echo (in_array($term[0]->term_id, $advance_area_array) ? ' checked="checked" ' : ''); ?> type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="advance_garden" id="apimo_garden" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

                                                <label class="apimo-archive-filter" for="apimo_garden">

                                                    <div class="checkbox-filter-image">

                                                        <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                            <path d="M31.07,29.66a7.43,7.43,0,0,0,2.56.46,7.5,7.5,0,0,0,6-12A7.5,7.5,0,0,0,34.19,5.46a7.78,7.78,0,0,0-1.73.2,7.49,7.49,0,0,0-14.55.09,7.43,7.43,0,0,0-2.06-.29,7.49,7.49,0,0,0-5.1,13A7.48,7.48,0,0,0,17,30.12a7.65,7.65,0,0,0,2.24-.34A7.47,7.47,0,0,0,24,32.56V49a1,1,0,1,0,2,0V32.58a7.57,7.57,0,0,0,5.06-2.92Zm-10.66-1.6a1,1,0,0,0-.83-.46.92.92,0,0,0-.4.08,5.41,5.41,0,0,1-2.21.46A5.51,5.51,0,0,1,12.86,19a1,1,0,0,0,.24-.77,1,1,0,0,0-.41-.7A5.52,5.52,0,0,1,18.27,8a1,1,0,0,0,1.43-.83A5.51,5.51,0,0,1,30.7,7a1,1,0,0,0,.47.77,1,1,0,0,0,.89.06A5.54,5.54,0,0,1,39.72,13a5.51,5.51,0,0,1-2.08,4.31,1,1,0,0,0-.37.71,1,1,0,0,0,.29.76,5.52,5.52,0,0,1-6.41,8.81,1,1,0,0,0-1.3.38A5.55,5.55,0,0,1,26,30.58V20.45a1,1,0,1,0-2,0v10.1a5.52,5.52,0,0,1-3.62-2.49Z" />

                                                            <path d="M21.85,46H18.11v-7h3.6a1,1,0,1,0,0-2h-3.6V35.44a1,1,0,1,0-2,0V37H10.2V35.44a1,1,0,1,0-2,0V37H2.3V35.44a1,1,0,1,0-2,0v2a.89.89,0,0,0,0,1.1v7.89a.89.89,0,0,0,0,1.1V49a1,1,0,1,0,2,0V47.93H8.23V49a1,1,0,0,0,2,0V47.93h5.92V49a1,1,0,1,0,2,0V47.93h3.74a1,1,0,1,0,0-2ZM2.3,46v-7H8.23v7Zm7.9,0v-7h5.93v7Z" />

                                                            <path d="M49.72,46.25V38.64A1,1,0,0,0,50,38a1,1,0,0,0-.28-.68V35.44a1,1,0,1,0-2,0V37H41.82V35.44a1,1,0,0,0-2,0V37H33.91V35.44a1,1,0,1,0-2,0V37H28.43a1,1,0,0,0,0,2h3.51v7H28.29a1,1,0,1,0,0,2h3.65V49a1,1,0,1,0,2,0V47.93h5.93V49a1,1,0,1,0,2,0V47.93h5.92V49a1,1,0,1,0,2,0V47.62a1,1,0,0,0,.28-.68,1,1,0,0,0-.28-.69ZM33.91,46v-7h5.93v7Zm7.91,0v-7h5.92v7Z" />

                                                        </svg>

                                                    </div>

                                                    <span class="text"><?php _e('Garden', 'apimo') ?></span>

                                                </label>

                                            </div>

                                        <?php endif;

                                        if ($advance_filter == 'terrace') :

                                            $term = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 18,

                                                    'hide_empty' => false

                                                )
                                            );

                                        ?>

                                            <div class="apimo-archive-filter apimo_advance_garden" data-id="apimo_terrace">

                                                <input <?php echo (in_array($term[0]->term_id, $advance_area_array) ? ' checked="checked" ' : ''); ?> type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_terrace" id="apimo_terrace" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

                                                <label class="apimo-archive-filter" for="apimo_terrace">

                                                    <div class="checkbox-filter-image">

                                                        <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                            <path d="M24.88,0a1.18,1.18,0,0,0-1,1.15v0a34.13,34.13,0,0,0-13.1,3.31C5.77,7,1.24,11.09,0,17.4a1.18,1.18,0,0,0,1.12,1.36H23.86v9.66H14.67a1.17,1.17,0,0,0-1,1.13v4a1.19,1.19,0,0,0,1.13,1.14h9.09V47.73H19.78A1.14,1.14,0,0,0,19.89,50H30.11a1.14,1.14,0,1,0,0-2.27h-4V34.67h9.09a1.19,1.19,0,0,0,1.13-1.14v-4a1.18,1.18,0,0,0-1.13-1.13H26.14V18.76H48.86A1.18,1.18,0,0,0,50,17.4C48.76,11.09,44.23,7,39.24,4.51a34.34,34.34,0,0,0-13.1-3.32v0A1.18,1.18,0,0,0,24.88,0ZM25,3.43A32.24,32.24,0,0,1,38.24,6.55c4.2,2.07,7.75,5.24,9.15,9.94H2.61c1.4-4.7,4.95-7.87,9.15-9.94A32.24,32.24,0,0,1,25,3.43ZM1.05,29a1.19,1.19,0,0,0-1,1.54c1.23,3.28,2.3,6.15,3.43,9.27H3.3A1.17,1.17,0,0,0,2.22,41a1.19,1.19,0,0,0,1.19,1.08H4.1l-1.77,5.3a1.19,1.19,0,0,0,.72,1.45,1.18,1.18,0,0,0,1.44-.72l2-6h3.73v6.24a1.14,1.14,0,1,0,2.27,0V42.05h.57a1.14,1.14,0,1,0,0-2.27H5.91c-.33-1-.72-2-1-2.84h6.48a1.14,1.14,0,1,0,0-2.28H4.05L2.2,29.71A1.15,1.15,0,0,0,1.05,29Zm47.76,0a1.15,1.15,0,0,0-1,.74c-.46,1.21-1.18,3.15-1.85,5H38.53a1.18,1.18,0,0,0-1.09,1.18,1.2,1.2,0,0,0,1.19,1.09h6.48c-.34,1-.71,2-1,2.84H36.93a1.14,1.14,0,1,0,0,2.27h.57V48.3a1.14,1.14,0,1,0,2.27,0V42.05H43.5l2,6a1.14,1.14,0,1,0,2.17-.73l-1.78-5.3h.7a1.14,1.14,0,1,0,0-2.27H46.5c1.11-3.07,2.24-6.09,3.43-9.27A1.2,1.2,0,0,0,48.81,29Zm-32.9,1.72H34.09v1.7H15.91Z" />

                                                        </svg>

                                                    </div>

                                                    <span class="text"><?php _e('Terrace', 'apimo') ?></span>

                                                </label>

                                            </div>

                                        <?php endif;

                                        if ($advance_filter == 'balcony') :

                                            $term = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 43,

                                                    'hide_empty' => false

                                                )
                                            );

                                        ?>

                                            <div class="apimo-archive-filter apimo_advance_balcony" data-id="apimo_balcony">

                                                <input <?php echo (in_array($term[0]->term_id, $advance_area_array) ? ' checked="checked" ' : ''); ?> type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_balcony" id="apimo_balcony" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

                                                <label class="apimo-archive-filter" for="apimo_balcony">

                                                    <div class="checkbox-filter-image">

                                                        <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                            <path d="M7.5,0A1.76,1.76,0,0,0,5.85,1.84,1.7,1.7,0,0,0,6.43,3a1.75,1.75,0,0,0,1.26.45h.58V27.91H3.62a.61.61,0,0,0-.19,0,1.73,1.73,0,0,0-1.2.57,1.78,1.78,0,0,0-.45,1.26A1.72,1.72,0,0,0,2.36,31a1.7,1.7,0,0,0,1.26.44H4.2V46.51H3.43a1.73,1.73,0,0,0-1.2.57,1.78,1.78,0,0,0-.45,1.26,1.71,1.71,0,0,0,.58,1.21A1.75,1.75,0,0,0,3.62,50h43a1.8,1.8,0,0,0,1.25-.5,1.75,1.75,0,0,0,0-2.49,1.71,1.71,0,0,0-1.25-.5H45.47V31.39h1.16a1.74,1.74,0,1,0,0-3.48H42V3.49h.59A1.71,1.71,0,0,0,43.81,3a1.72,1.72,0,0,0,.52-1.24A1.73,1.73,0,0,0,43.81.5,1.79,1.79,0,0,0,42.57,0H7.5Zm4.25,3.49H23.38V14H11.75Zm15.12,0H38.5V14H26.87ZM15.79,4.62a1.71,1.71,0,0,0-1.42.8L13.21,7.16a1.74,1.74,0,0,0,1.34,2.72,1.74,1.74,0,0,0,1.56-.78l1.17-1.74A1.75,1.75,0,0,0,17,5a1.73,1.73,0,0,0-1.19-.41Zm4.07,2.32a1.76,1.76,0,0,0-1.42.8L17.28,9.49a1.74,1.74,0,0,0,1.34,2.71,1.73,1.73,0,0,0,1.56-.77l1.17-1.74a1.79,1.79,0,0,0,.3-1.23,1.76,1.76,0,0,0-1.79-1.52Zm-8.11,10.5H23.38V27.91H11.75Zm15.12,0H38.5V27.91H26.87Zm4,1.13a1.76,1.76,0,0,0-1.42.8l-1.16,1.74a1.77,1.77,0,0,0-.11,1.75,1.74,1.74,0,0,0,1.45,1,1.76,1.76,0,0,0,1.57-.77l1.16-1.75a1.7,1.7,0,0,0,.3-1.22,1.73,1.73,0,0,0-.6-1.11,1.71,1.71,0,0,0-1.19-.41ZM35,20.89a1.79,1.79,0,0,0-1.42.8l-1.16,1.75a1.75,1.75,0,0,0,2.91,1.94l1.16-1.74a1.73,1.73,0,0,0,.3-1.23,1.71,1.71,0,0,0-.6-1.1A1.77,1.77,0,0,0,35,20.89ZM7.68,31.39h4.07V46.51H7.68Zm7.56,0h4.07V46.51H15.24Zm7.56,0h4.07V46.51H22.8Zm7.56,0h4.07V46.51H30.36Zm7.55,0H42V46.51H37.91Z" />

                                                        </svg>

                                                    </div>

                                                    <span class="text"><?php _e('Balcony', 'apimo') ?></span>

                                                </label>





                                            </div>

                                        <?php endif;

                                        if ($advance_filter == 'garage_box') :

                                            $term = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 4,

                                                    'hide_empty' => false

                                                )
                                            );

                                        ?>

                                            <div class="apimo-archive-filter apimo_advance_garage_box" data-id="apimo_garage_box">

                                                <input <?php echo (in_array($term[0]->term_id, $advance_area_array) ? ' checked="checked" ' : ''); ?> type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_garage_box" id="apimo_garage_box" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

                                                <label class="apimo-archive-filter" for="apimo_garage_box">

                                                    <div class="checkbox-filter-image">

                                                        <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                            <path d="M47.88,20.31H46.26V46.12a2.13,2.13,0,0,1-.61,1.49,2.18,2.18,0,0,1-1.49.62h-.32a2.16,2.16,0,0,1-1.48-.62,2.1,2.1,0,0,1-.62-1.49V20.31H8.27V46.12a2.13,2.13,0,0,1-.61,1.49,2.16,2.16,0,0,1-1.49.62H5.85a2.18,2.18,0,0,1-1.49-.62,2.13,2.13,0,0,1-.61-1.49V20.31H2.13A2.14,2.14,0,0,1,.5,19.55,2.12,2.12,0,0,1,0,17.82a2.08,2.08,0,0,1,1-1.47L25,2.38l24,14a2.08,2.08,0,0,1,1,1.47,2.12,2.12,0,0,1-.46,1.73,2.14,2.14,0,0,1-1.63.76ZM39.66,30.65v1.08a1.57,1.57,0,0,1-.46,1.07,1.62,1.62,0,0,1-1.07.47h-.76a3.46,3.46,0,0,1,.22.31h0a6.39,6.39,0,0,1,1.06,3.7v7.33a1.54,1.54,0,0,1-1.53,1.53h-2a1.54,1.54,0,0,1-1.53-1.53V43.45H16.39V44.6a1.52,1.52,0,0,1-1.53,1.53h-2a1.52,1.52,0,0,1-1.54-1.53V37.29a6.46,6.46,0,0,1,1.06-3.7,3.55,3.55,0,0,1,.23-.31h-.75a1.62,1.62,0,0,1-1.07-.47,1.57,1.57,0,0,1-.46-1.07V30.66h0a1.55,1.55,0,0,1,.45-1.05,1.5,1.5,0,0,1,1-.45h.57a2.65,2.65,0,0,1,1.7.73,30.28,30.28,0,0,1,2.21-4.68,5.14,5.14,0,0,1,3.54-2A29.3,29.3,0,0,1,25,22.82a29.47,29.47,0,0,1,5.14.33,5.1,5.1,0,0,1,3.53,2,32,32,0,0,1,2.22,4.7,2.59,2.59,0,0,1,1.71-.76h.57a1.54,1.54,0,0,1,1.49,1.52Zm-19.2,6.23a1.2,1.2,0,0,0-.89-1.15L16.77,35a1.22,1.22,0,0,0-1,.21,1.19,1.19,0,0,0-.46.94v.74a1.19,1.19,0,0,0,1.18,1.18h2.8a1.2,1.2,0,0,0,1.2-1.18Zm14.28-.74h0a1.18,1.18,0,0,0-.46-.94,1.21,1.21,0,0,0-1-.21l-2.8.74h0a1.19,1.19,0,0,0,.3,2.33h2.8a1.19,1.19,0,0,0,1.19-1.19Z" />

                                                        </svg>

                                                    </div>

                                                    <span class="text"><?php _e('Garage Or Box', 'apimo') ?></span>

                                                </label>





                                            </div>

                                        <?php endif;

                                        if ($advance_filter == 'parking_space') :

                                            $term = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 5,

                                                    'hide_empty' => false

                                                )
                                            );

                                        ?>

                                            <div class="apimo-archive-filter apimo_advance_parking" data-id="apimo_parking">

                                                <input <?php echo (in_array($term[0]->term_id, $advance_area_array) ? ' checked="checked" ' : ''); ?> type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_parking" id="apimo_parking" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

                                                <label class="apimo-archive-filter" for="apimo_parking">

                                                    <div class="checkbox-filter-image">

                                                        <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                            <path d="M40.43,0H9.52A9.51,9.51,0,0,0,0,9.47v31A9.52,9.52,0,0,0,9.52,50h31A9.52,9.52,0,0,0,50,40.47v-31A9.58,9.58,0,0,0,40.43,0ZM45,40.47A4.52,4.52,0,0,1,40.43,45H9.52A4.53,4.53,0,0,1,5,40.47v-31A4.48,4.48,0,0,1,9.52,5h31A4.52,4.52,0,0,1,45,9.47v31Z" />

                                                            <path d="M25.66,10.2H19a2.55,2.55,0,0,0-2.55,2.55V38.38a1,1,0,0,0,1,1h3a1,1,0,0,0,1-1V28.61h4.41a9.17,9.17,0,0,0,9.18-9.81,9.35,9.35,0,0,0-9.45-8.6ZM26,23.57h-4.4V15.24H26a4.17,4.17,0,0,1,0,8.33Z" />

                                                        </svg>

                                                    </div>

                                                    <span class="text"><?php _e('Parking space', 'apimo') ?></span>

                                                </label>





                                            </div>

                                        <?php endif;

                                        if ($advance_filter == 'cellar') :

                                            $term = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 6,

                                                    'hide_empty' => false

                                                )
                                            );

                                        ?>

                                            <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_cellar">

                                                <input <?php echo (in_array($term[0]->term_id, $advance_area_array) ? ' checked="checked" ' : ''); ?> type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_cellar" id="apimo_cellar" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

                                                <label class="apimo-archive-filter" for="apimo_cellar">

                                                    <div class="checkbox-filter-image">

                                                        <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                            <path d="M24.47,0A17.65,17.65,0,0,1,42.12,17.65V48.53A1.47,1.47,0,0,1,40.65,50H8.29a1.47,1.47,0,0,1-1.47-1.47V17.65A17.65,17.65,0,0,1,24.47,0ZM9.76,44.12v2.94H39.17V42.65H11.23a1.47,1.47,0,0,0-1.47,1.47Zm6.62-7.35v2.94h22.8V35.29H17.85a1.47,1.47,0,0,0-1.47,1.48ZM23,29.41v2.94H39.18V27.94H24.47A1.47,1.47,0,0,0,23,29.41Zm6.62-7.35V25h9.55V20.59H31.09a1.47,1.47,0,0,0-1.47,1.47Z" />

                                                        </svg>

                                                    </div>

                                                    <span class="text"><?php _e('Cellar', 'apimo') ?></span>

                                                </label>





                                            </div>

                                        <?php endif;

                                        if ($advance_filter == 'pool') :

                                            $term = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_service',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 11,

                                                    'hide_empty' => false

                                                )
                                            );

                                        ?>

                                            <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_pool">

                                                <input <?php echo (in_array($term[0]->term_id, $advance_area_array) ? ' checked="checked" ' : ''); ?> type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[service][]" data-id="apimo_pool" id="apimo_pool" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

                                                <label class="apimo-archive-filter" for="apimo_pool">

                                                    <div class="checkbox-filter-image">

                                                        <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                            <path d="M4.9,33.52a4.82,4.82,0,0,0,3.58-1.63c.63-.6.91-.85,1.61-.85s1,.25,1.6.85a4.74,4.74,0,0,0,7.15,0c.63-.6.91-.85,1.61-.85s1,.25,1.61.85a4.74,4.74,0,0,0,7.15,0c.63-.6.91-.85,1.61-.85s1,.25,1.6.85a4.75,4.75,0,0,0,7.16,0c.62-.6.91-.85,1.6-.85s1,.25,1.61.85a4.74,4.74,0,0,0,7.15,0l.06-.06V28.45a5.65,5.65,0,0,0-2,1.38c-.62.59-.91.84-1.6.84s-1-.25-1.61-.84a4.74,4.74,0,0,0-7.15,0c-.63.59-.91.84-1.61.84s-1-.25-1.61-.84a5,5,0,0,0-2.82-1.58V14.54H50v-2H38.72a7.09,7.09,0,0,0-1.54-4.69,4.53,4.53,0,0,0-3.43-1.43A4.61,4.61,0,0,0,30.3,7.88a7.3,7.3,0,0,0-1.67,4.7H24.41a7.07,7.07,0,0,0-1.53-4.69,4.55,4.55,0,0,0-3.44-1.43A4.61,4.61,0,0,0,16,7.88a7.36,7.36,0,0,0-1.67,4.7H0v2H14.33V30.4a5.54,5.54,0,0,1-.67-.57,4.74,4.74,0,0,0-7.15,0c-.63.59-.91.84-1.61.84s-1-.25-1.6-.84A4.83,4.83,0,0,0,0,28.21v2.85c.51.06.79.32,1.33.83A4.82,4.82,0,0,0,4.9,33.52ZM32.43,9.89a1.67,1.67,0,0,1,1.32-.5A1.59,1.59,0,0,1,35,9.87a4.42,4.42,0,0,1,.77,2.71H31.57a4.53,4.53,0,0,1,.86-2.69Zm-14.31,0a1.67,1.67,0,0,1,1.32-.5,1.59,1.59,0,0,1,1.27.48,4.42,4.42,0,0,1,.77,2.71H17.26a4.53,4.53,0,0,1,.86-2.69Zm-.86,4.64H28.64V16H17.26Zm0,4.38H28.64v4.45H17.26Zm0,7.38H28.64v2.44a6.63,6.63,0,0,0-1.4,1.1c-.63.59-.91.84-1.61.84s-1-.25-1.6-.84a4.81,4.81,0,0,0-3.58-1.63,4.48,4.48,0,0,0-3.19,1.27Zm-16,12.19A2.31,2.31,0,0,0,0,37.66V34.8a4.81,4.81,0,0,1,3.25,1.62c.63.6.92.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.6.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.6-.84A5.55,5.55,0,0,1,50,35v3.36l-.1.09a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.61-.84s-1,.24-1.6.84a4.75,4.75,0,0,1-7.16,0c-.62-.6-.91-.84-1.6-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.61-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.6-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0ZM47.94,43A5.54,5.54,0,0,1,50,41.62V45l-.1.09a4.74,4.74,0,0,1-7.15,0c-.63-.59-.91-.84-1.61-.84s-1,.24-1.6.84a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.61-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.61-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.62-.6-.91-.84-1.6-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.53-.49-.81-.75-1.29-.82V41.39A4.85,4.85,0,0,1,3.25,43c.63.6.92.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84A4.74,4.74,0,0,1,24,43c.63.6.91.84,1.6.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84Z" />

                                                        </svg>

                                                    </div>

                                                    <span class="text"><?php _e('Pool', 'apimo') ?></span>

                                                </label>





                                            </div>

                                        <?php endif;

                                        if ($advance_filter == 'lift') :

                                            $term = $terms = get_terms(
                                                array(

                                                    'taxonomy' => 'apimo_service',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 6,

                                                    'hide_empty' => false

                                                )
                                            );

                                        ?>

                                            <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_lift">

                                                <input <?php echo (in_array($term[0]->term_id, $advance_area_array) ? ' checked="checked" ' : ''); ?> type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[service][]" data-id="apimo_lift" id="apimo_lift" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

                                                <label class="apimo-archive-filter" for="apimo_lift">

                                                    <div class="checkbox-filter-image">

                                                        <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">

                                                            <path d="m46.08 46.44h-42.08-.37l.47.06a2.38 2.38 0 0 1 -.52-.15l.42.15a2.19 2.19 0 0 1 -.3-.16c-.29-.17.16.1.14.12l-.14-.13-.11-.12c-.14-.13.26.38.12.15a3.72 3.72 0 0 1 -.22-.36l.18.43a2.31 2.31 0 0 1 -.15-.53l.06.48a10.59 10.59 0 0 1 0-1.38v-41a2.3 2.3 0 0 1 0-.37l-.06.47a2.63 2.63 0 0 1 .15-.53l-.18.43a2.91 2.91 0 0 1 .17-.3c.16-.29-.1.16-.12.14s.12-.13.13-.14a1.14 1.14 0 0 0 .11-.11c.14-.14-.38.26-.15.11s.22-.13.34-.18l-.42.18a3.13 3.13 0 0 1 .52-.16l-.47.07a10.59 10.59 0 0 1 1.4-.06h41a2.42 2.42 0 0 1 .38 0l-.48-.07a2.49 2.49 0 0 1 .53.16l-.43-.16a2.91 2.91 0 0 1 .3.17c.29.16-.16-.1-.14-.12s.13.12.14.13l.11.11c.14.14-.25-.38-.11-.15a3.65 3.65 0 0 1 .18.34l-.18-.43a2.67 2.67 0 0 1 .16.53c0-.16 0-.31-.07-.47a10.56 10.56 0 0 1 0 1.38v41.03a2.43 2.43 0 0 1 0 .38c0-.16.05-.32.07-.48a1.91 1.91 0 0 1 -.16.53l.18-.43a1.82 1.82 0 0 1 -.16.31c-.17.28.1-.16.12-.15l-.14.15-.11.1c-.14.15.38-.25.15-.11a2.21 2.21 0 0 1 -.34.18l.43-.17a3.21 3.21 0 0 1 -.53.15l.48-.06h-.31a1.78 1.78 0 1 0 0 3.55 4 4 0 0 0 3.93-3.87v-42.08a3.94 3.94 0 0 0 -1.24-2.93 4.07 4.07 0 0 0 -2.76-1.07h-42.23a4.05 4.05 0 0 0 -3.07 1.71 3.79 3.79 0 0 0 -.7 2.21v42.08a3.94 3.94 0 0 0 1.35 3 4.21 4.21 0 0 0 2.65 1h42a1.78 1.78 0 0 0 0-3.56z" />

                                                            <path d="m39.72 27.81-5.51 5.5-.79.78h2.52l-6.31-6.28a1.78 1.78 0 1 0 -2.52 2.51l6.31 6.29a1.81 1.81 0 0 0 2.52 0l5.51-5.5.79-.79a1.78 1.78 0 1 0 -2.52-2.51z" />

                                                            <path d="m42.24 19.68-5.51-5.5-.8-.79a1.81 1.81 0 0 0 -2.52 0l-6.3 6.29a1.79 1.79 0 0 0 0 2.51 1.82 1.82 0 0 0 2.52 0l6.3-6.29h-2.52l5.52 5.5.79.79a1.81 1.81 0 0 0 2.52 0 1.79 1.79 0 0 0 0-2.51z" />

                                                            <path d="m16.6 11.72a2.74 2.74 0 0 1 0 .5c0-.16 0-.32.07-.48a4.28 4.28 0 0 1 -.23.85l.17-.43a2.89 2.89 0 0 1 -.29.55l-.09.13c-.13.21.13-.18.14-.17s-.22.24-.24.26l-.23.21c-.13.14.34-.24.18-.14l-.13.09a3.37 3.37 0 0 1 -.59.32l.43-.18a3.56 3.56 0 0 1 -.85.23l.47-.07a3.22 3.22 0 0 1 -1 0l.47.07a4.28 4.28 0 0 1 -.85-.23l.43.18a4.77 4.77 0 0 1 -.55-.29l-.15-.12c-.21-.14.18.13.17.13s-.24-.22-.26-.23l-.21-.23c-.14-.14.24.33.14.17l-.09-.13a3.28 3.28 0 0 1 -.32-.58l.18.42a3.49 3.49 0 0 1 -.23-.84l.06.47a4 4 0 0 1 0-1l-.06.47a4.28 4.28 0 0 1 .23-.85l-.18.43a4.77 4.77 0 0 1 .29-.55l.09-.13c.14-.21-.13.18-.13.17s.22-.24.23-.26l.24-.21c.13-.14-.34.24-.18.14l.13-.09a3 3 0 0 1 .59-.32l-.43.18a3.44 3.44 0 0 1 .85-.23l-.48.07a3.29 3.29 0 0 1 1 0h-.49a4.11 4.11 0 0 1 .85.23l-.42-.23a4.77 4.77 0 0 1 .55.29l.13.09c.21.14-.18-.13-.17-.13s.24.22.26.23l.21.24c.13.13-.24-.34-.14-.18l.09.13a3.23 3.23 0 0 1 .31.58l-.17-.42a3.44 3.44 0 0 1 .23.85c0-.16 0-.32-.07-.48v.49a1.78 1.78 0 0 0 3.56 0 5.19 5.19 0 0 0 -.91-3 5.55 5.55 0 0 0 -2.66-2 5.25 5.25 0 0 0 -5.67 1.51 5.53 5.53 0 0 0 -1.3 3.14 5.19 5.19 0 0 0 3 5 5.58 5.58 0 0 0 3.44.42 5.31 5.31 0 0 0 4.15-5.14 1.78 1.78 0 0 0 -3.56 0z" />

                                                            <path d="m18.35 24.24v7.87l1.78-1.78h-10.47l1.78 1.78v-7.11a12.1 12.1 0 0 1 0-1.35l-.06.47a4.39 4.39 0 0 1 .3-1.13l-.17.42a4.32 4.32 0 0 1 .36-.67c0-.06.08-.1.11-.16s-.32.38-.12.15l.26-.28.28-.25c.18-.16-.18.15-.19.13l.16-.11a4.43 4.43 0 0 1 .71-.39l-.43.18a4.5 4.5 0 0 1 1.14-.32l-.48.07a12.86 12.86 0 0 1 1.52 0 13 13 0 0 1 1.53 0l-.48-.07a4.61 4.61 0 0 1 1.14.32l-.43-.18a4.92 4.92 0 0 1 .68.37c.06 0 .1.08.16.11s-.38-.31-.15-.11l.28.25c.09.09.17.19.25.28s-.15-.18-.13-.18l.11.16a4.8 4.8 0 0 1 .39.7l-.18-.41a4.42 4.42 0 0 1 .32 1.13c0-.16 0-.31-.07-.47a2.76 2.76 0 0 1 .06.57 1.78 1.78 0 0 0 3.56 0 6.15 6.15 0 0 0 -1.59-4.09 6 6 0 0 0 -3.68-1.9 18.71 18.71 0 0 0 -2.37-.07 6.76 6.76 0 0 0 -3.3.76 6.19 6.19 0 0 0 -2.7 3.27 6.29 6.29 0 0 0 -.35 2.28v7.63a1.8 1.8 0 0 0 1.78 1.78h10.47a1.81 1.81 0 0 0 1.78-1.78v-7.87a1.78 1.78 0 0 0 -3.56 0z" />

                                                            <path d="m16.09 32.11v7.44 1.07c0-.16 0-.31.07-.47a.73.73 0 0 1 -.06.21l.18-.42c-.12.23.28-.3.13-.16s.41-.26.16-.15l.43-.17a.87.87 0 0 1 -.22 0l.48-.06c-.78 0-1.57 0-2.35 0s-1.56 0-2.34 0l.48.06h-.22l.43.17c-.24-.11.28.29.15.15s.27.41.13.16l.18.42a.73.73 0 0 1 -.06-.21c0 .16 0 .31.07.47-.06-1 0-1.93 0-2.89v-5.62l-1.78 1.78h5.94a1.78 1.78 0 1 0 0-3.55h-5.96a1.8 1.8 0 0 0 -1.79 1.77v8.34a2.53 2.53 0 0 0 1.27 2.25 6.64 6.64 0 0 0 3.08.32h2.63a2.5 2.5 0 0 0 2.53-2.46c0-.14 0-.27 0-.41v-2.55c0-1.79 0-3.58 0-5.37v-.1a1.8 1.8 0 0 0 -1.78-1.78 1.77 1.77 0 0 0 -1.78 1.76z" />

                                                        </svg>

                                                    </div>

                                                    <span class="text"><?php _e('Lift', 'apimo') ?></span>

                                                </label>





                                            </div>

                                    <?php endif;

                                    endforeach;

                                    ?>

                                </div>

                                <div class="apply-filter">

                                    <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply apimo-apply-filter"><?php _e('Apply filter', 'apimo') ?></button>

                                </div>

                            </div>

                        </div>

                    <?php endif; ?>

                    <div class="filter-item order-by">

                        <div class="filter-item-title">





                            <div class="mobile-title">

                                <span class="text">

                                    <?php _e('Order By', 'apimo'); ?>

                                </span>

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 524.57 279.79">

                                        <path d="M350,420a17.46,17.46,0,0,1-12.37-5.13l-245-245a17.5,17.5,0,0,1,24.74-24.74L350,377.75,582.63,145.13a17.5,17.5,0,0,1,24.74,24.74l-245,245A17.44,17.44,0,0,1,350,420Z" transform="translate(-87.71 -140.21)" />

                                    </svg>

                                </span>

                            </div>

                            <div class="desktop-title">

                                <div class="filter-title">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 278.75 198.8">

                                        <path d="M210,189.35a8.75,8.75,0,0,1,8.75-8.75h182a8.75,8.75,0,0,1,0,17.5H219.45a8.75,8.75,0,0,1-9.45-8.75ZM379.05,241H219.45a8.91,8.91,0,0,0-8.75,8.75,8.76,8.76,0,0,0,8.75,8.75h160.3a8.75,8.75,0,1,0,0-17.5Zm-39.38,60.55H219.44a8.75,8.75,0,0,0-8.75,8.75,8.93,8.93,0,0,0,8.75,8.75H340.37a8.75,8.75,0,1,0,0-17.5Zm-21,60.37H219.45a8.75,8.75,0,1,0,0,17.5h99.92a8.75,8.75,0,0,0,0-17.5Zm167.12-38.85a8.56,8.56,0,0,0-12.25,0l-24.32,25.37V189.35a8.75,8.75,0,0,0-17.5,0V350l-25.37-25.37a8.79,8.79,0,1,0-12.43,12.42l40.25,40.25,1.75,1.23H437a7.16,7.16,0,0,0,3.32,0,7.49,7.49,0,0,0,3.33,0,8,8,0,0,0,3-1.92L486,335.3a8.74,8.74,0,0,0,.52-12.25Z" transform="translate(-210 -180.6)" />

                                    </svg>

                                </div>

                            </div>


                        </div>





                        <div class="filter-item-dropdown">
                            <div class="apimo-archive-filter orderby-radio">
                                <div class="order-by-radio-item">
                                    <input type="radio" id="relevance" name="order-by-properties" value="relevance" <?php if ($attrs['order_by'] == 'relevance') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                    <label for="relevance"><?php _e('Relevance', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="price_low_to_high" name="order-by-properties" value="price_low_to_high" <?php if ($attrs['order_by'] == 'price_low_to_high') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                    <label for="price_low_to_high"><?php _e('Rising price', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="price_high_to_low" name="order-by-properties" value="price_high_to_low" <?php if ($attrs['order_by'] == 'price_high_to_low') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                    <label for="price_high_to_low"><?php _e('Descending price', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="area_low_to_high" name="order-by-properties" value="area_low_to_high" <?php if ($attrs['order_by'] == 'area_low_to_high') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                    <label for="area_low_to_high"><?php _e('Rising area', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="area_high_to_low" name="order-by-properties" value="area_high_to_low" <?php if ($attrs['order_by'] == 'area_high_to_low') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                    <label for="area_high_to_low"><?php _e('Descending area', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="bedrooms_low_to_high" name="order-by-properties" value="bedrooms_low_to_high" <?php if ($attrs['order_by'] == 'bedrooms_low_to_high') {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                    <label for="bedrooms_low_to_high"><?php _e('Bedrooms increasing', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="bedrooms_high_to_low" name="order-by-properties" value="bedrooms_high_to_low" <?php if ($attrs['order_by'] == 'bedrooms_high_to_low') {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                    <label for="bedrooms_high_to_low"><?php _e('Bedrooms descending', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="rooms_low_to_high" name="order-by-properties" value="rooms_low_to_high" <?php if ($attrs['order_by'] == 'rooms_low_to_high') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                    <label for="rooms_low_to_high"><?php _e('Comparment increasing', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="rooms_high_to_low" name="order-by-properties" value="rooms_high_to_low" <?php if ($attrs['order_by'] == 'rooms_high_to_low') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                    <label for="rooms_high_to_low"><?php _e('Comparment descending', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="created_at_low_to_high" name="order-by-properties" value="created_at_low_to_high" <?php if ($attrs['order_by'] == 'created_at_low_to_high') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                    <label for="created_at_low_to_high"><?php _e('Creation date: from oldest to newest', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="created_at_high_to_low" name="order-by-properties" value="created_at_high_to_low" <?php if ($attrs['order_by'] == 'created_at_high_to_low') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                    <label for="created_at_high_to_low"><?php _e('Creation date: from newest to oldest', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="updated_at_low_to_high" name="order-by-properties" value="updated_at_low_to_high" <?php if ($attrs['order_by'] == 'updated_at_low_to_high') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                    <label for="updated_at_low_to_high"><?php _e('Update date: from oldest to newest', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="updated_at_high_to_low" name="order-by-properties" value="updated_at_high_to_low" <?php if ($attrs['order_by'] == 'updated_at_high_to_low') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                    <label for="updated_at_high_to_low"><?php _e('Update date: from newest to oldest', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="published_at_low_to_high" name="order-by-properties" value="published_at_low_to_high" <?php if ($attrs['order_by'] == 'published_at_low_to_high') {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                    <label for="published_at_low_to_high"><?php _e('Publish date: from oldest to newest', 'apimo'); ?></label>
                                </div>

                                <div class="order-by-radio-item">
                                    <input type="radio" id="published_at_high_to_low" name="order-by-properties" value="published_at_high_to_low" <?php if ($attrs['order_by'] == 'published_at_high_to_low') {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                    <label for="published_at_high_to_low"><?php _e('Publish date: from newest to oldest', 'apimo'); ?></label>
                                </div>
                            </div>

                            <div class="apply-filter">
                                <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply apimo-apply-filter">
                                    <?php _e('Apply order', 'apimo') ?>
                                </button>
                            </div>
                        </div>


                    </div>

                </div>

            </section>

            <div class="apimo-active-filter" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>">

                <div class="apimo-active-filter-container">

                    <div class="apimo-active-filter-label"><?php _e('Active filter', 'apimo'); ?></div>

                    <div class="apimo-filter-row">

                        <div class="apimo-filter-remove-all" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>">

                            <?php _e('Remove all', 'apimo'); ?>

                            <div class="icon">

                                <div class="icon-inner">

                                    <svg id="Modalità_Isolamento" data-name="Modalità Isolamento" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 203 203">

                                        <path d="M448,280a98,98,0,1,1-98-98A98,98,0,0,1,448,280Zm-190.4,0A92.4,92.4,0,1,0,350,187.6,92.4,92.4,0,0,0,257.6,280Zm92.4,4-31.62,31.62a2.8,2.8,0,1,1-4-4L346,280l-31.62-31.62a2.8,2.8,0,1,1,4-4L350,276l31.62-31.62a2.8,2.8,0,1,1,4,4L354,280l31.62,31.62a2.8,2.8,0,1,1-4,4Z" transform="translate(-248.5 -178.5)" style="fill-rule:evenodd" />

                                        <path d="M350,380.5A100.5,100.5,0,1,1,450.5,280,100.61,100.61,0,0,1,350,380.5Zm0-196A95.5,95.5,0,1,0,445.5,280,95.61,95.61,0,0,0,350,184.5Zm0,190.4A94.9,94.9,0,1,1,444.9,280,95,95,0,0,1,350,374.9Zm0-184.8A89.9,89.9,0,1,0,439.9,280,90,90,0,0,0,350,190.1Zm33.6,128.8a5.26,5.26,0,0,1-3.75-1.55L350,287.5l-29.86,29.85a5.26,5.26,0,0,1-3.74,1.55h0a5.3,5.3,0,0,1-3.74-9L342.5,280l-29.85-29.85a5.3,5.3,0,0,1-1.55-3.76,5.31,5.31,0,0,1,5.29-5.29h0a5.26,5.26,0,0,1,3.74,1.55L350,272.5l29.85-29.85a5.26,5.26,0,0,1,3.75-1.55h0a5.3,5.3,0,0,1,3.74,9.05L357.49,280l29.85,29.85a5.3,5.3,0,0,1-3.74,9ZM350,280.43l33.39,33.38a.3.3,0,1,0,.42-.42L350.42,280l33.39-33.39a.3.3,0,0,0-.21-.51h0a.29.29,0,0,0-.21.09L350,279.57l-33.39-33.38a.3.3,0,0,0-.42,0,.29.29,0,0,0,0,.42L349.57,280l-33.38,33.39a.29.29,0,0,0-.09.21.32.32,0,0,0,.08.21.33.33,0,0,0,.22.09h0a.29.29,0,0,0,.21-.09Z" transform="translate(-248.5 -178.5)" />

                                        <path d="M350,379a99,99,0,1,1,99-99A99.11,99.11,0,0,1,350,379Zm0-196a97,97,0,1,0,97,97A97.1,97.1,0,0,0,350,183Zm0,190.4A93.4,93.4,0,1,1,443.4,280,93.51,93.51,0,0,1,350,373.4Zm0-184.8A91.4,91.4,0,1,0,441.4,280,91.5,91.5,0,0,0,350,188.6Zm33.6,128.8a3.81,3.81,0,0,1-2.69-1.11L350,285.38l-30.92,30.91a3.78,3.78,0,0,1-2.68,1.11h0a3.8,3.8,0,0,1-2.68-6.49L344.62,280l-30.91-30.91a3.8,3.8,0,0,1,2.68-6.49h0a3.78,3.78,0,0,1,2.68,1.11L350,274.62l30.91-30.91a3.81,3.81,0,0,1,2.69-1.11h0a3.82,3.82,0,0,1,3.8,3.8,3.79,3.79,0,0,1-1.12,2.69L355.37,280l30.91,30.91a3.8,3.8,0,0,1-2.68,6.49ZM350,282.55l32.33,32.32a1.79,1.79,0,0,0,1.27.53h0a1.8,1.8,0,0,0,1.27-3.07L352.54,280l32.33-32.33a1.8,1.8,0,0,0-1.27-3.07h0a1.79,1.79,0,0,0-1.27.53L350,277.45l-32.33-32.32a1.79,1.79,0,0,0-1.27-.53h0a1.8,1.8,0,0,0-1.27,3.07L347.45,280l-32.32,32.33a1.8,1.8,0,0,0,1.27,3.07h0a1.79,1.79,0,0,0,1.27-.53Z" transform="translate(-248.5 -178.5)" />

                                        <path d="M350,381.5A101.5,101.5,0,1,1,451.5,280,101.61,101.61,0,0,1,350,381.5Zm0-190.4A88.9,88.9,0,1,0,438.9,280,89,89,0,0,0,350,191.1Zm33.6,128.8h0a6.28,6.28,0,0,1-4.46-1.85L350,288.91l-29.15,29.14a6.29,6.29,0,1,1-8.9-8.9L341.09,280l-29.15-29.15a6.3,6.3,0,1,1,8.91-8.9L350,271.09,379.14,242a6.3,6.3,0,1,1,8.91,8.9L358.91,280l29.14,29.15a6.3,6.3,0,0,1-4.45,10.75Z" transform="translate(-248.5 -178.5)" />

                                    </svg>

                                </div>

                            </div>

                        </div>

                        <div class="apimo-active-filter-list" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>"></div>

                    </div>

                </div>

            </div>

        </div>



        <section class="Content-wrapper apimo-content-wrapper">

            <div class="loader blasting-ripple apimo-loader" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>"></div>

            <div data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="Product-wrapper Grid-wrapper apimo-property-wrapper <?php if ($attrs['grid'] == 'horizontal') {
                                                                                                                                            echo ' landscape-type';
                                                                                                                                        } ?>" data-type="shortcode" data-category_filter="<?php echo isset($attrs['category_filter']) ? esc_attr($attrs['category_filter']) : ''; ?>" data-subtype_filter="<?php echo isset($attrs['subtype_filter']) ? esc_attr($attrs['subtype_filter']) : ''; ?>" data-country="<?php echo isset($attrs['country']) ? esc_attr($attrs['country']) : ''; ?>" data-region="<?php echo isset($attrs['region']) ? esc_attr($attrs['region']) : ''; ?>" data-city="<?php echo isset($attrs['city']) ? esc_attr($attrs['city']) : ''; ?>" data-price_range_min="<?php echo isset($attrs['price_range_min']) ? esc_attr($attrs['price_range_min']) : ''; ?>" data-price_range_max="<?php echo isset($attrs['price_range_max']) ? esc_attr($attrs['price_range_max']) : ''; ?>" data-property_areas_min="<?php echo isset($attrs['property_areas_min']) ? esc_attr($attrs['property_areas_min']) : ''; ?>" data-property_areas_max="<?php echo isset($attrs['property_areas_max']) ? esc_attr($attrs['property_areas_max']) : ''; ?>" data-number_of_rooms="<?php echo isset($attrs['number_of_rooms']) ? esc_attr($attrs['number_of_rooms']) : ''; ?>" data-number_of_bedrooms="<?php echo isset($attrs['number_of_bedrooms']) ? esc_attr($attrs['number_of_bedrooms']) : ''; ?>" data-date_filter_type="<?php echo isset($attrs['date_filter_type']) ? esc_attr($attrs['date_filter_type']) : ''; ?>" data-start_date="<?php echo isset($attrs['start_date']) ? esc_attr($attrs['start_date']) : ''; ?>" data-end_date="<?php echo isset($attrs['end_date']) ? esc_attr($attrs['end_date']) : ''; ?>" data-advance_area="<?php echo isset($attrs['advance_area']) ? esc_attr($attrs['advance_area']) : ''; ?>" data-advance_service="<?php echo isset($attrs['advance_service']) ? esc_attr($attrs['advance_service']) : ''; ?>" data-tax_apimo_property_standing="<?php echo isset($attrs['tax_apimo_property_standing']) ? esc_attr($attrs['tax_apimo_property_standing']) : ''; ?>" data-tax_apimo_property_condition="<?php echo isset($attrs['tax_apimo_property_condition']) ? esc_attr($attrs['tax_apimo_property_condition']) : ''; ?>" data-tax_apimo_heating_access="<?php echo isset($attrs['tax_apimo_heating_access']) ? esc_attr($attrs['tax_apimo_heating_access']) : ''; ?>" data-meta_apimo_bedrooms="<?php echo isset($attrs['meta_apimo_bedrooms']) ? esc_attr($attrs['meta_apimo_bedrooms']) : ''; ?>" data-meta_apimo_construction_year="<?php echo isset($attrs['meta_apimo_construction_year']) ? esc_attr($attrs['meta_apimo_construction_year']) : ''; ?>" data-meta_apimo_renovation_year="<?php echo isset($attrs['meta_apimo_renovation_year']) ? esc_attr($attrs['meta_apimo_renovation_year']) : ''; ?>" data-meta_apimo_residence_fees="<?php echo isset($attrs['meta_apimo_residence_fees']) ? esc_attr($attrs['meta_apimo_residence_fees']) : ''; ?>" data-repository_tags="<?php echo isset($attrs['repository_tags']) ? esc_attr($attrs['repository_tags']) : ''; ?>" data-customised_tags="<?php echo isset($attrs['customised_tags']) ? esc_attr($attrs['customised_tags']) : ''; ?>" data-desktop="<?php echo esc_attr($attrs['desktop']) ?>" data-tablet="<?php echo esc_attr($attrs['tablet']) ?>" data-mobile="<?php echo esc_attr($attrs['mobile']) ?>">




                <?php #print_r($attrs);die();  
                ?>

                <div class="<?php if ($attrs['view'] == 'carousel') {
                                echo 'apimo_slick_slider';
                            } else {
                                echo 'apimo-row';
                            } ?>" data-slide-to-desktop="<?php echo isset($attrs['desktop']) ? esc_attr($attrs['desktop']) : ''; ?>" data-slide-to-mobile="<?php echo isset($attrs['mobile']) ? esc_attr($attrs['mobile']) : ''; ?>" data-slide-to-tablate="<?php echo isset($attrs['tablet']) ? esc_attr($attrs['tablet']) : ''; ?>" data_id="<?php echo esc_attr($shortcode_id); ?>">

                    <?php

                    while ($apimo_query->have_posts()) {

                        $apimo_query->the_post();

                        global $post;

                    ?>

                        <div class="<?php if ($attrs['view'] == 'carousel') {

                                        echo 'properties-aprimo-item';
                                    } else {

                                        echo esc_attr($grid_desktop) . ' ' . esc_attr($grid_tablet) . ' ' . esc_attr($grid_mobile);
                                    } ?>">

                            <?php

                            include $apimo_dir . 'templates/template_archive_block.php';

                            ?>

                        </div>

                    <?php

                    }

                    wp_reset_query();

                    ?>

                </div>

                <?php

                if ($attrs['view'] == 'carousel') {

                ?>

                    <div class="apimo-carousel-arrow">

                        <ul>

                            <li class="apimo-arrow apimo-carousel-prev">

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.79 45.01">

                                        <path d="M-64.65,10.36a1.27,1.27,0,0,0-.9-.38,1.23,1.23,0,0,0-.9.38L-87.66,31.57a1.26,1.26,0,0,0,0,1.79h0l21.21,21.22a1.28,1.28,0,0,0,1.8.06,1.27,1.27,0,0,0,.06-1.8l-.06-.06L-85,32.47l20.31-20.31a1.28,1.28,0,0,0,0-1.8Z" transform="translate(88.04 -9.98)" />

                                    </svg>

                                </span>

                            </li>

                            <li class="apimo-arrow apimo-carousel-next">

                                <span class="icon">

                                    <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.79 45.01">

                                        <path d="M-87.63,54.61a1.27,1.27,0,0,0,.9.38,1.23,1.23,0,0,0,.9-.38L-64.62,33.4a1.26,1.26,0,0,0,0-1.79h0L-85.83,10.38a1.28,1.28,0,0,0-1.8-.06,1.27,1.27,0,0,0-.06,1.8l.06.06L-67.32,32.5-87.63,52.81a1.28,1.28,0,0,0,0,1.8Z" transform="translate(88.04 -9.98)" />

                                    </svg>

                                </span>

                            </li>

                        </ul>

                    </div>

                <?php } ?>





            </div>
            <?php if (isset($attrs['no_of_post']) && $attrs['no_of_post'] !== '' && $attrs['no_of_post'] != -1) : ?>

                <div <?php if (isset($attrs['post_limit'])) {
                            echo 'style="display:none;"';
                        } ?> class="apimo-archive-pagination-div" data-type="shortcode" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" data-max-page="<?php echo esc_attr($apimo_query->max_num_pages); ?>" data-post-per-page="<?php echo esc_attr($attrs['no_of_post']); ?>" data-current-page="1">
                </div>
            <?php endif; ?>







        </section>



<?php





    endif;

    $data = ob_get_contents();

    ob_end_clean();

    return $data;
}

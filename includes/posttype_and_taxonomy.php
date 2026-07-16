<?php

global $UNIT_AREA;




function fetch_Catalogs($catalog, $culture = '')
{

    $items = array();
    if (empty($culture)) {
        $culture = get_locale();
    }

    if (get_option('apimo_key_data')) {

        $apimo_api_keys = get_option('apimo_key_data');
        $data_keys = $apimo_api_keys[0];
        $company_id = $data_keys['company_id'];
        $api_key = $data_keys['key'];
        $auth = base64_encode($company_id . ':' . $api_key);

        $catalog_url = 'https://api.apimo.pro/catalogs/' . $catalog . '?culture=' . $culture;

        $result = wp_remote_get($catalog_url, array(

            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ),

        ));

        if (!is_wp_error($result)) {

            $data = json_decode($result['body']);

            if ($data !== null) {

                foreach ($data as $item) {
                    $items[$item->id] = $item->name;
                }

                return $items;
            }
        }
    } else {
        return;
    }
}


if (!get_option('unit_area')) {
    $unit_area_data = fetch_Catalogs('unit_area');
    update_option('unit_area', $unit_area_data);
}


if (!get_option('property_period')) {
    $property_period_data = fetch_Catalogs('property_period');
    update_option('property_period', $property_period_data);
}


$UNIT_AREA = get_option('unit_area');

define('PROPERTY_PERIOD', get_option('property_period'));









/**register post type**/

function apimo_create_posttype()
{

    $apimo_settings = get_option('apimo_style_archive');


    register_post_type(

        APIMO_POST_TYPE,

        array(

            'labels' => array(

                'name' => __('Properties', 'apimo'),

                'singular_name' => __('Property', 'apimo')

            ),

            'public' => true,

            // 'has_archive' => true,

            // 'show_in_menu' => 'apimo',

            'show_in_rest' => true,

            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),

            'rewrite' => array('slug' => $apimo_settings['single_slug']),

            'has_archive' => $apimo_settings['archive_slug'],

            'capabilities' => array(

                //'create_posts' => 'do_not_allow'

            )

            //'_builtin' =>true



        )

    );
}

add_action('init', 'apimo_create_posttype');









add_action('init', 'apimo_create_property_hierarchical_taxonomy', 1);





function apimo_create_property_hierarchical_taxonomy()
{



    $show_in_ui = true;

    register_taxonomy(
        'apimo_areas',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Areas', 'apimo'),

                'singular_name' => __('Areas', 'apimo'),

                'search_items' => __('Search Areas', 'apimo'),

                'all_items' => __('All Areas', 'apimo'),

                'parent_item' => __('Parent Areas', 'apimo'),

                'parent_item_colon' => __('Parent Areas:', 'apimo'),

                'edit_item' => __('Edit Areas', 'apimo'),

                'update_item' => __('Update Areas', 'apimo'),

                'add_new_item' => __('Add New Areas', 'apimo'),

                'new_item_name' => __('New Areas Name', 'apimo'),

                'menu_name' => __('Areas', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => true,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_property_standing',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Standing', 'apimo'),

                'singular_name' => __('Standing', 'apimo'),

                'search_items' => __('Search Standing', 'apimo'),

                'all_items' => __('All Standing', 'apimo'),

                'parent_item' => __('Parent Standing', 'apimo'),

                'parent_item_colon' => __('Parent Standing:', 'apimo'),

                'edit_item' => __('Edit Standing', 'apimo'),

                'update_item' => __('Update Standing', 'apimo'),

                'add_new_item' => __('Add New Standing', 'apimo'),

                'new_item_name' => __('New Standing Name', 'apimo'),

                'menu_name' => __('Standing', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => true,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_property_condition',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Condition', 'apimo'),

                'singular_name' => __('Condition', 'apimo'),

                'search_items' => __('Search Condition', 'apimo'),

                'all_items' => __('All Condition', 'apimo'),

                'parent_item' => __('Parent Condition', 'apimo'),

                'parent_item_colon' => __('Parent Condition:', 'apimo'),

                'edit_item' => __('Edit Condition', 'apimo'),

                'update_item' => __('Update Condition', 'apimo'),

                'add_new_item' => __('Add New Condition', 'apimo'),

                'new_item_name' => __('New Condition Name', 'apimo'),

                'menu_name' => __('Condition', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_water_hot_device',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Water Hot Device', 'apimo'),

                'singular_name' => __('Water Hot Device', 'apimo'),

                'search_items' => __('Search Water Hot Device', 'apimo'),

                'all_items' => __('All Water Hot Device', 'apimo'),

                'parent_item' => __('Parent Water Hot Device', 'apimo'),

                'parent_item_colon' => __('Parent Water Hot Device:', 'apimo'),

                'edit_item' => __('Edit Water Hot Device', 'apimo'),

                'update_item' => __('Update Water Hot Device', 'apimo'),

                'add_new_item' => __('Add New Water Hot Device', 'apimo'),

                'new_item_name' => __('New Water Hot Device Name', 'apimo'),

                'menu_name' => __('Water Hot Device', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_water_hot_access',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Water Hot Access', 'apimo'),

                'singular_name' => __('Water Hot Access', 'apimo'),

                'search_items' => __('Search Water Hot Access', 'apimo'),

                'all_items' => __('All Water Hot Access', 'apimo'),

                'parent_item' => __('Parent Water Hot Access', 'apimo'),

                'parent_item_colon' => __('Parent Water Hot Access:', 'apimo'),

                'edit_item' => __('Edit Water Hot Access', 'apimo'),

                'update_item' => __('Update Water Hot Access', 'apimo'),

                'add_new_item' => __('Add New Water Hot Access', 'apimo'),

                'new_item_name' => __('New Water Hot Access Name', 'apimo'),

                'menu_name' => __('Water Hot Access', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_water_waste',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Water Waste', 'apimo'),

                'singular_name' => __('Water Waste', 'apimo'),

                'search_items' => __('Search Water Waste', 'apimo'),

                'all_items' => __('All Water Waste', 'apimo'),

                'parent_item' => __('Parent Water Waste', 'apimo'),

                'parent_item_colon' => __('Parent Water Waste:', 'apimo'),

                'edit_item' => __('Edit Water Waste', 'apimo'),

                'update_item' => __('Update Water Waste', 'apimo'),

                'add_new_item' => __('Add New Water Waste', 'apimo'),

                'new_item_name' => __('New Water Waste Name', 'apimo'),

                'menu_name' => __('Water Waste', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_heating_type',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Heating Type', 'apimo'),

                'singular_name' => __('Heating Type', 'apimo'),

                'search_items' => __('Search Heating Type', 'apimo'),

                'all_items' => __('All Heating Type', 'apimo'),

                'parent_item' => __('Parent Heating Type', 'apimo'),

                'parent_item_colon' => __('Parent Heating Type:', 'apimo'),

                'edit_item' => __('Edit Heating Type', 'apimo'),

                'update_item' => __('Update Heating Type', 'apimo'),

                'add_new_item' => __('Add New Heating Type', 'apimo'),

                'new_item_name' => __('New Heating Type Name', 'apimo'),

                'menu_name' => __('Heating Type', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_heating_access',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Heating Access', 'apimo'),

                'singular_name' => __('Heating Access', 'apimo'),

                'search_items' => __('Search Heating Access', 'apimo'),

                'all_items' => __('All Heating Access', 'apimo'),

                'parent_item' => __('Parent Heating Access', 'apimo'),

                'parent_item_colon' => __('Parent Heating Access:', 'apimo'),

                'edit_item' => __('Edit Heating Access', 'apimo'),

                'update_item' => __('Update Heating Access', 'apimo'),

                'add_new_item' => __('Add New Heating Access', 'apimo'),

                'new_item_name' => __('New Heating Access Name', 'apimo'),

                'menu_name' => __('Heating Access', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_heating_device',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Heating Device', 'apimo'),

                'singular_name' => __('Heating Device', 'apimo'),

                'search_items' => __('Search Heating Device', 'apimo'),

                'all_items' => __('All Heating Device', 'apimo'),

                'parent_item' => __('Parent Heating Device', 'apimo'),

                'parent_item_colon' => __('Parent Heating Device:', 'apimo'),

                'edit_item' => __('Edit Heating Device', 'apimo'),

                'update_item' => __('Update Heating Device', 'apimo'),

                'add_new_item' => __('Add New Heating Device', 'apimo'),

                'new_item_name' => __('New Heating Device Name', 'apimo'),

                'menu_name' => __('Heating Devices', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_floor',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Floor', 'apimo'),

                'singular_name' => __('Floor', 'apimo'),

                'search_items' => __('Search Floor', 'apimo'),

                'all_items' => __('All Floors', 'apimo'),

                'parent_item' => __('Parent Floor', 'apimo'),

                'parent_item_colon' => __('Parent Floor:', 'apimo'),

                'edit_item' => __('Edit Floor', 'apimo'),

                'update_item' => __('Update Floor', 'apimo'),

                'add_new_item' => __('Add New Floor', 'apimo'),

                'new_item_name' => __('New Floor Name', 'apimo'),

                'menu_name' => __('Floors', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );

    register_taxonomy(
        'apimo_property_building',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Building Type', 'apimo'),

                'singular_name' => __('Building Type', 'apimo'),

                'search_items' => __('Search Building Type', 'apimo'),

                'all_items' => __('All Building Type', 'apimo'),

                'parent_item' => __('Parent Building Type', 'apimo'),

                'parent_item_colon' => __('Parent Building Type:', 'apimo'),

                'edit_item' => __('Edit Building Type', 'apimo'),

                'update_item' => __('Update Building Type', 'apimo'),

                'add_new_item' => __('Add New Building Type', 'apimo'),

                'new_item_name' => __('New Building Type Name', 'apimo'),

                'menu_name' => __('Building Type', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_construction',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Construction', 'apimo'),

                'singular_name' => __('Construction', 'apimo'),

                'search_items' => __('Search Construction', 'apimo'),

                'all_items' => __('All Construction', 'apimo'),

                'parent_item' => __('Parent Construction', 'apimo'),

                'parent_item_colon' => __('Parent Construction:', 'apimo'),

                'edit_item' => __('Edit Construction', 'apimo'),

                'update_item' => __('Update Construction', 'apimo'),

                'add_new_item' => __('Add New Construction', 'apimo'),

                'new_item_name' => __('New Construction Name', 'apimo'),

                'menu_name' => __('Construction', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );





    register_taxonomy(
        'apimo_subtype',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Subtype', 'apimo'),

                'singular_name' => __('Subtype', 'apimo'),

                'search_items' => __('Search Subtype', 'apimo'),

                'all_items' => __('All Subtype', 'apimo'),

                'parent_item' => __('Parent Subtype', 'apimo'),

                'parent_item_colon' => __('Parent Subtype:', 'apimo'),

                'edit_item' => __('Edit Subtype', 'apimo'),

                'update_item' => __('Update Subtype', 'apimo'),

                'add_new_item' => __('Add New Subtype', 'apimo'),

                'new_item_name' => __('New Subtype Name', 'apimo'),

                'menu_name' => __('Subtype', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );

    register_taxonomy(
        'apimo_type',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Type', 'apimo'),

                'singular_name' => __('Type', 'apimo'),

                'search_items' => __('Search Type', 'apimo'),

                'all_items' => __('All Type', 'apimo'),

                'parent_item' => __('Parent Type', 'apimo'),

                'parent_item_colon' => __('Parent Type:', 'apimo'),

                'edit_item' => __('Edit Type', 'apimo'),

                'update_item' => __('Update Type', 'apimo'),

                'add_new_item' => __('Add New Type', 'apimo'),

                'new_item_name' => __('New Type Name', 'apimo'),

                'menu_name' => __('Type', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_availability',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Availability', 'apimo'),

                'singular_name' => __('Availability', 'apimo'),

                'search_items' => __('Search Availability', 'apimo'),

                'all_items' => __('All Availability', 'apimo'),

                'parent_item' => __('Parent Availability', 'apimo'),

                'parent_item_colon' => __('Parent Availability:', 'apimo'),

                'edit_item' => __('Edit Availability', 'apimo'),

                'update_item' => __('Update Availability', 'apimo'),

                'add_new_item' => __('Add New Availability', 'apimo'),

                'new_item_name' => __('New Availability Name', 'apimo'),

                'menu_name' => __('Availability', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_orientation',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Orientation', 'apimo'),

                'singular_name' => __('Orientation', 'apimo'),

                'search_items' => __('Search Orientation', 'apimo'),

                'all_items' => __('All Orientation', 'apimo'),

                'parent_item' => __('Parent Orientation', 'apimo'),

                'parent_item_colon' => __('Parent Orientation:', 'apimo'),

                'edit_item' => __('Edit Orientation', 'apimo'),

                'update_item' => __('Update Orientation', 'apimo'),

                'add_new_item' => __('Add New Orientation', 'apimo'),

                'new_item_name' => __('New Orientation Name', 'apimo'),

                'menu_name' => __('Orientation', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_service',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Service', 'apimo'),

                'singular_name' => __('Service', 'apimo'),

                'search_items' => __('Search Service', 'apimo'),

                'all_items' => __('All Service', 'apimo'),

                'parent_item' => __('Parent Service', 'apimo'),

                'parent_item_colon' => __('Parent Service:', 'apimo'),

                'edit_item' => __('Edit Service', 'apimo'),

                'update_item' => __('Update Service', 'apimo'),

                'add_new_item' => __('Add New Service', 'apimo'),

                'new_item_name' => __('New Service Name', 'apimo'),

                'menu_name' => __('Service', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_category',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Category', 'apimo'),

                'singular_name' => __('Category', 'apimo'),

                'search_items' => __('Search Category', 'apimo'),

                'all_items' => __('All Category', 'apimo'),

                'parent_item' => __('Parent Category', 'apimo'),

                'parent_item_colon' => __('Parent Category:', 'apimo'),

                'edit_item' => __('Edit Category', 'apimo'),

                'update_item' => __('Update Category', 'apimo'),

                'add_new_item' => __('Add New Category', 'apimo'),

                'new_item_name' => __('New Category Name', 'apimo'),

                'menu_name' => __('Category', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'apimo_sub_category',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Sub Category', 'apimo'),

                'singular_name' => __('Sub Category', 'apimo'),

                'search_items' => __('Search Sub Category', 'apimo'),

                'all_items' => __('All Sub Category', 'apimo'),

                'parent_item' => __('Parent Sub Category', 'apimo'),

                'parent_item_colon' => __('Parent Sub Category:', 'apimo'),

                'edit_item' => __('Edit Sub Category', 'apimo'),

                'update_item' => __('Update Sub Category', 'apimo'),

                'add_new_item' => __('Add New Sub Category', 'apimo'),

                'new_item_name' => __('New Sub Category Name', 'apimo'),

                'menu_name' => __('Sub Category', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'country',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Country', 'apimo'),

                'singular_name' => __('Country', 'apimo'),

                'search_items' => __('Search Country', 'apimo'),

                'all_items' => __('All Country', 'apimo'),

                'parent_item' => __('Parent Country', 'apimo'),

                'parent_item_colon' => __('Parent Country:', 'apimo'),

                'edit_item' => __('Edit Country', 'apimo'),

                'update_item' => __('Update Country', 'apimo'),

                'add_new_item' => __('Add New Country', 'apimo'),

                'new_item_name' => __('New Country Name', 'apimo'),

                'menu_name' => __('Country', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'region',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Region', 'apimo'),

                'singular_name' => __('Region', 'apimo'),

                'search_items' => __('Search Regions', 'apimo'),

                'all_items' => __('All Regions', 'apimo'),

                'parent_item' => __('Parent Region', 'apimo'),

                'parent_item_colon' => __('Parent Region:', 'apimo'),

                'edit_item' => __('Edit Region', 'apimo'),

                'update_item' => __('Update Region', 'apimo'),

                'add_new_item' => __('Add New Region', 'apimo'),

                'new_item_name' => __('New Region Name', 'apimo'),

                'menu_name' => __('Regions', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'city',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('City', 'apimo'),

                'singular_name' => __('City', 'apimo'),

                'search_items' => __('Search City', 'apimo'),

                'all_items' => __('All City', 'apimo'),

                'parent_item' => __('Parent City', 'apimo'),

                'parent_item_colon' => __('Parent City:', 'apimo'),

                'edit_item' => __('Edit City', 'apimo'),

                'update_item' => __('Update City', 'apimo'),

                'add_new_item' => __('Add New City', 'apimo'),

                'new_item_name' => __('New City Name', 'apimo'),

                'menu_name' => __('City', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );



    register_taxonomy(
        'district',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('District', 'apimo'),

                'singular_name' => __('District', 'apimo'),

                'search_items' => __('Search District', 'apimo'),

                'all_items' => __('All District', 'apimo'),

                'parent_item' => __('Parent District', 'apimo'),

                'parent_item_colon' => __('Parent District:', 'apimo'),

                'edit_item' => __('Edit District', 'apimo'),

                'update_item' => __('Update District', 'apimo'),

                'add_new_item' => __('Add New District', 'apimo'),

                'new_item_name' => __('New District Name', 'apimo'),

                'menu_name' => __('District', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );

    register_taxonomy(
        'repository_tags',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Repository Tags', 'apimo'),

                'singular_name' => __('Repository Tag', 'apimo'),

                'search_items' => __('Search Repository Tag', 'apimo'),

                'all_items' => __('All Repository Tag', 'apimo'),

                'parent_item' => __('Parent Repository Tag', 'apimo'),

                'parent_item_colon' => __('Parent Repository Tag:', 'apimo'),

                'edit_item' => __('Edit Repository Tag', 'apimo'),

                'update_item' => __('Update Repository Tag', 'apimo'),

                'add_new_item' => __('Add New Repository Tag', 'apimo'),

                'new_item_name' => __('New Repository Tag Name', 'apimo'),

                'menu_name' => __('Repository Tag', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );

    register_taxonomy(
        'customised_tags',
        array('property'),
        array(

            'hierarchical' => true,

            'labels' => array(

                'name' => __('Customised Tags', 'apimo'),

                'singular_name' => __('Customised Tag', 'apimo'),

                'search_items' => __('Search Customised Tag', 'apimo'),

                'all_items' => __('All Customised Tag', 'apimo'),

                'parent_item' => __('Parent Customised Tag', 'apimo'),

                'parent_item_colon' => __('Parent Customised Tag:', 'apimo'),

                'edit_item' => __('Edit Customised Tag', 'apimo'),

                'update_item' => __('Update Customised Tag', 'apimo'),

                'add_new_item' => __('Add New Customised Tag', 'apimo'),

                'new_item_name' => __('New Customised Tag Name', 'apimo'),

                'menu_name' => __('Customised Tag', 'apimo'),

            ),

            'show_ui' => $show_in_ui,

            'show_in_rest' => $show_in_ui,

            'show_admin_column' => false,

            'query_var' => true,

        )
    );
}



add_filter('template_include', 'apimo_override_single_template', 10, 1);

function apimo_override_single_template($single_template)
{

    global $post;

    global $apimo_dir, $apimo_url;

    if (is_object($post) && $post->post_type == APIMO_POST_TYPE && is_single()) {

        $file = $apimo_dir . '/templates/single-property.php';

        return $file;
    } elseif (is_object($post) && $post->post_type == APIMO_POST_TYPE && is_archive()) {



        $file = $apimo_dir . '/templates/archive-property.php';

        return $file;
    } else {

        return $single_template;
    }
}



add_filter('manage_property_posts_columns', 'apimo_set_custom_edit_property_columns');

function apimo_set_custom_edit_property_columns($columns)
{



    unset($columns['author']);

    unset($columns['comments']);

    unset($columns['date']);

    $columns['price'] = __('Price', 'apimo');

    $columns['area'] = __('Area', 'apimo');

    $columns['number_of_rooms'] = __('Number of Rooms', 'apimo');

    $columns['bathroom'] = __('Bathroom', 'apimo');

    $columns['region'] = __('Region', 'apimo');

    $columns['city'] = __('City', 'apimo');



    return $columns;
}



// Add the data to the custom columns for the book post type:

add_action('manage_property_posts_custom_column', 'custom_book_column', 10, 2);

// function custom_book_column($column, $post_id)

// {

//     switch ($column) {



//         case 'price':

//             echo apimo_currency_format(get_post_meta($post_id, 'apimo_price', true));

//             break;

//         case 'city':

//             echo  wp_get_post_terms($post_id, 'city')[0]->name;;

//             break;

//         case 'area':

//             global $UNIT_AREA;

//             echo get_post_meta($post_id, 'apimo_area_display_filter', true) . ' ' . $UNIT_AREA[get_post_meta($post_id, 'apimo_area_unit', true)];

//             break;

//         case 'number_of_rooms':

//             echo get_post_meta($post_id, 'apimo_rooms', true);

//             break;

//         case 'bathroom':

//             echo get_post_meta($post_id, 'apimo_bathrooms', true);

//             break;

//         case 'region':

//             echo  wp_get_post_terms($post_id, 'region')[0]->name;;

//             break;

//     }

// }
function custom_book_column($column, $post_id)
{
    switch ($column) {
        case 'price':
            echo esc_html(apimo_currency_format(get_post_meta($post_id, 'apimo_price', true)));
            break;
        case 'city':
            echo esc_html(wp_get_post_terms($post_id, 'city')[0]->name);
            break;
        case 'area':
            global $UNIT_AREA;
            echo esc_html(get_post_meta($post_id, 'apimo_area_display_filter', true)) . ' ' . esc_html($UNIT_AREA[get_post_meta($post_id, 'apimo_area_unit', true)]);
            break;
        case 'number_of_rooms':
            echo esc_html(get_post_meta($post_id, 'apimo_rooms', true));
            break;
        case 'bathroom':
            echo esc_html(get_post_meta($post_id, 'apimo_bathrooms', true));
            break;
        case 'region':
            $region_terms = wp_get_post_terms($post_id, 'region');
            if (!empty($region_terms) && is_array($region_terms) && isset($region_terms[0])) {
                echo esc_html($region_terms[0]->name);
            } else {
                echo 'No region specified';
            }
    }
}





function apimo_add_category()
{
    $categorys = fetch_Catalogs('property_category');




    foreach ($categorys as $key => $value) {

        $category = wp_insert_term(__($value, 'apimo'), 'apimo_category');

        if (!is_wp_error($category)) {

            update_term_meta($category['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_subcategory()
{
    $subcategorys = fetch_Catalogs('property_subcategory');




    foreach ($subcategorys as $key => $value) {

        $subcategory = wp_insert_term(__($value, 'apimo'), 'apimo_sub_category');

        if (!is_wp_error($subcategory)) {

            update_term_meta($subcategory['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_orientation()
{
    $orientation = fetch_Catalogs('property_orientation');





    foreach ($orientations as $key => $value) {

        $orientation = wp_insert_term(__($value, 'apimo'), 'apimo_orientation');

        if (!is_wp_error($orientation)) {

            update_term_meta($orientation['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_service()
{
    $service  = fetch_Catalogs('property_service');




    foreach ($service as $key => $value) {

        $servic = wp_insert_term($value, 'apimo_service');

        if (!is_wp_error($servic)) {

            update_term_meta($servic['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_availability()
{
    $all_availability = fetch_Catalogs('property_availability');




    foreach ($all_availability as $key => $value) {

        $availability = wp_insert_term($value, 'apimo_availability');

        if (!is_wp_error($availability)) {

            update_term_meta($availability['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_type()
{
    $types = fetch_Catalogs('property_type');



    foreach ($types as $key => $value) {

        $type = wp_insert_term(__($value, 'apimo'), 'apimo_type');

        if (!is_wp_error($type)) {

            update_term_meta($type['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_subtype()
{
    $subtypes = fetch_Catalogs('property_subtype');




    foreach ($subtypes as $key => $value) {

        $subtype = wp_insert_term($value, 'apimo_subtype');

        if (!is_wp_error($subtype)) {

            update_term_meta($subtype['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_construction()
{
    $constructions = fetch_Catalogs('property_construction_method');




    foreach ($constructions as $key => $value) {

        $construction = wp_insert_term(__($value, 'apimo'), 'apimo_construction');

        if (!is_wp_error($construction)) {

            update_term_meta($construction['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_property_building()
{
    $buildings = fetch_Catalogs('property_building');




    foreach ($buildings as $key => $value) {

        $building = wp_insert_term(__($value, 'apimo'), 'apimo_property_building');

        if (!is_wp_error($building)) {

            update_term_meta($building['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_property_floor()
{
    $floors = fetch_Catalogs('property_floor');



    foreach ($floors as $key => $value) {

        $floor = wp_insert_term(__($value, 'apimo'), 'apimo_floor');

        if (!is_wp_error($floor)) {

            update_term_meta($floor['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_heating_device()
{
    $all_heating_device = fetch_Catalogs('property_heating_device');




    foreach ($all_heating_device as $key => $value) {

        $heating_device = wp_insert_term($value, 'apimo_heating_device');

        if (!is_wp_error($heating_device)) {

            update_term_meta($heating_device['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_heating_access()
{
    $all_heating_access = fetch_Catalogs('property_heating_access');


    foreach ($all_heating_access as $key => $value) {

        $heating_access = wp_insert_term($value, 'apimo_heating_access');

        if (!is_wp_error($heating_access)) {

            update_term_meta($heating_access['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_heating_type()
{
    $heating_types = fetch_Catalogs('property_heating_type');



    foreach ($heating_types as $key => $value) {

        $heating_type = wp_insert_term($value, 'apimo_heating_type');

        if (!is_wp_error($heating_type)) {

            update_term_meta($heating_type['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_water_hot_device()
{
    $water_hot_devices = fetch_Catalogs('property_hot_water_device');




    foreach ($water_hot_devices as $key => $value) {

        $water_hot_device = wp_insert_term(__($value, 'apimo'), 'apimo_water_hot_device');

        if (!is_wp_error($water_hot_device)) {

            update_term_meta($water_hot_device['term_id'], 'apimo_term_id', $key);
        }
    }
}

function apimo_add_water_hot_access()
{
    $all_water_hot_access = fetch_Catalogs('property_hot_water_access');



    foreach ($all_water_hot_access as $key => $value) {

        $water_hot_access = wp_insert_term(__($value, 'apimo'), 'apimo_water_hot_access');

        if (!is_wp_error($water_hot_access)) {

            update_term_meta($water_hot_access['term_id'], 'apimo_term_id', $key);
        }
    }
}

function apimo_add_water_waste()
{
    $all_water_waste = fetch_Catalogs('property_waste_water');




    foreach ($all_water_waste as $key => $value) {

        $water_waste = wp_insert_term(__($value, 'apimo'), 'apimo_water_waste');

        if (!is_wp_error($water_waste)) {

            update_term_meta($water_waste['term_id'], 'apimo_term_id', $key);
        }
    }
}



function apimo_add_condition()
{
    $conditions = fetch_Catalogs('property_condition');



    foreach ($conditions as $key => $value) {

        $condition = wp_insert_term(__($value, 'apimo'), 'apimo_property_condition');

        if (!is_wp_error($condition)) {

            update_term_meta($condition['term_id'], 'apimo_term_id', $key);
        }
    }
}

function apimo_add_standing()
{
    $all_standing = fetch_Catalogs('property_standing');




    foreach ($all_standing as $key => $value) {

        $standing = wp_insert_term(__($value, 'apimo'), 'apimo_property_standing');

        if (!is_wp_error($standing)) {

            update_term_meta($standing['term_id'], 'apimo_term_id', $key);
        }
    }
}





function apimo_add_areas()
{
    $all_areas = fetch_Catalogs('property_areas');



    foreach ($all_areas as $key => $value) {

        $areas = wp_insert_term(__($value, 'apimo'), 'apimo_areas');

        if (!is_wp_error($areas)) {

            update_term_meta($areas['term_id'], 'apimo_term_id', $key);
        }
    }
}





function apimo_add_repository_tags()
{
    $all_tags = fetch_Catalogs('tags');


    foreach ($all_tags as $key => $value) {

        $areas = wp_insert_term(__($value, 'apimo'), 'repository_tags');

        if (!is_wp_error($areas)) {

            update_term_meta($areas['term_id'], 'apimo_term_id', $key);
        }
    }
}

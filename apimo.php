<?php

/**

 * Plugin Name: Apimo

 * Description: Manage Real Estat Bussiness

 * Version: 2.6.3.1

 * Author: ApiWork

 * Author URI:

 * Text Domain: apimo

 * Domain Path: /languages

 */


define('APIMO_POST_TYPE', 'property');

define('APIMO_VERSION', 1.0);

define('APIMO_TEXT_DOMAIN', 'apimo');

define('APIMO_FONT_ARRAY', array(

    'times_new_roman' => 'Times New Roman',

    'arial' => 'Arial',

    'verdana' => 'Verdana',

    'helvetica' => 'Helvetica',

    'tahoma' => 'Tahoma',

    'brush_script_mt' => 'Brush Script MT'

));

global $apimo_dir, $apimo_url;



$apimo_dir =  plugin_dir_path(__FILE__);

$apimo_url =  plugin_dir_url(__FILE__);



/**

 * Activate the plugin.

 */

function apimo_pluginprefix_activate()

{



    /*****apimo style****/

    $color_data['primary']['color'] = '#0B3C5D';

    $color_data['secondary']['color'] = '#5d8713';

    $color_data['container_width'] = '1280';

    $color_data['container_width_unit'] = 'px';

    update_option('apimo_style', $color_data);




    /*****apimo style****/


    /** apimo style options **/


    /*****apimo_steps****/

    $apimo_steps['step_3']['view_1'] = array(

        'desktop' => 3,

        'teblate' => 2,

        'mobile' => 1

    );

    $apimo_steps['step_3']['view_2'] = array(

        'desktop' => 3,

        'teblate' => 2,

        'mobile' => 1

    );






    update_option('apimo_steps', $apimo_steps);

    /*****apimo_steps****/

    $archive['archive_slug'] = 'properties';

    $archive['single_slug'] = 'properties';

    $archive['template'] = 'landscape';

    $archive['view_1'] = array(

        'desktop' => 3,

        'teblate' => 2,

        'mobile' => 1

    );

    $archive['filter'] = array(

        'number_of_rooms',

        'number_of_bedrooms',

        'price_range',

        'property_areas',

        'dates',

        'location',

        'advance' => array(

            'garden',

            'terrace',

            'balcony',

            'garage_box',

            'parking_space',

            'cellar',

            'pool',

            'lift'

        )



    );



    $archive['pagination_enable'] = 'on';

    $archive['num_of_post'] = '12';

    $archive['archive_display_option'] = array(

        'number_of_rooms',

        'bathroom',

        'areas',

        'external_areas'

    );

    $archive['area_display_type'] = 'weighted';

    $archive['gallery_display_slider'] = '1';
    $archive['hideicon'] = 'showicon';
    $archive['userinfo'] = 'show';

    update_option('apimo_style_archive', $archive);





    update_option('apimo_style_pagina', 'pagina_style_1');





    apimo_add_category();

    apimo_add_subcategory();



    global $table_prefix, $wpdb;



    $wp_track_table = $table_prefix . "apimo_shortcode";



    $sql = "CREATE TABLE `" . $wp_track_table . "` ( ";

    $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";

    $sql .= "  `shortcode_name`  varchar(244), ";

    $sql .= "  `shortcode_data`  varchar(244), ";

    $sql .= "  `parameters`  varchar(244), ";

    $sql .= "  PRIMARY KEY `id` (`id`) ";

    $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');

    // dbDelta($sql);

}

register_activation_hook(__FILE__, 'apimo_pluginprefix_activate');



/**

 * Deactivation hook.

 */

function apimo_pluginprefix_deactivate()

{

    delete_option('apimo_initalize');

    global $table_prefix, $wpdb;

    $wpdb->query("DROP TABLE IF EXISTS " . $table_prefix . "apimo_shortcode");
}

//register_deactivation_hook(__FILE__, 'apimo_pluginprefix_deactivate');



add_action('init', 'apimo_load_textdomain');

function apimo_load_textdomain()

{

    load_plugin_textdomain('apimo', false, dirname(plugin_basename(__FILE__)) . '/languages');
}


function apimo_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=apimo">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'apimo_settings_link');


//inclued all files

include 'includes/posttype_and_taxonomy.php';

include 'includes/shortcode.php';

include 'includes/search_shortcode.php';


include 'includes/metabox.php';

include 'includes/apimo_ajax.php';

include 'action-scheduler/action-scheduler.php';

include 'admin/add_property.php';



function apimo_property_pre_get_post_archive($query)

{

    if (is_post_type_archive(APIMO_POST_TYPE) && !is_admin() && $query->is_main_query()) {

        $apimo_archive_settings = get_option('apimo_style_archive');



        $query->set('posts_per_page', $apimo_archive_settings['num_of_post']);

        $query->set('meta_query', array('price_query' => array(

            'key' => 'apimo_price_hide',

            'compare' => 'EXISTS'

        )));

        $query->set('orderby', array('price_query' => 'DESC'));
    }
}

add_action('pre_get_posts', 'apimo_property_pre_get_post_archive');



add_action("wp_enqueue_scripts", "apimo_frontend_scripts");

function apimo_frontend_scripts()

{

    global $apimo_dir, $apimo_url;

    wp_register_style('apimo-front-css', $apimo_url . '/assets/css/frontend.css');

    wp_register_style('apimo-slick-theme-style', $apimo_url . '/assets/css/slick-theme.css');

    wp_register_style('apimo-slick-style', $apimo_url . '/assets/css/slick.css');

    wp_register_style('apimo-frontend-select2-style', $apimo_url . '/assets/css/select2.min.css');

    wp_register_style('apimo-frontend-daterange', $apimo_url . '/assets/css/daterangepicker.css');





    wp_enqueue_style('apimo-frontend-select2-style');

    wp_register_style('apimo-app-css', $apimo_url . '/assets/css/app.css');

    wp_enqueue_style('apimo-app-css');

    wp_enqueue_style('apimo-slick-theme-style');

    wp_enqueue_style('apimo-slick-style');

    wp_enqueue_style('apimo-frontend-daterange');

    wp_enqueue_style('apimo-front-css');

    wp_register_script(

        'bpopup',
        $apimo_url . '/assets/js/jquery.bpopup.min.js'

    );

    wp_register_script(

        'apimo-front-js',
        $apimo_url . '/assets/js/frontend.js'

    );

    wp_localize_script(

        'apimo-front-js',

        'admin_urls',

        array(

            'ajax' => admin_url('admin-ajax.php'),

            'from' => __('From', 'apimo'),

            'to' => __('To', 'apimo'),

        )

    );

    wp_register_script(

        'apimo-frontend-select2-script',

        $apimo_url . '/assets/js/select2.min.js'

    );



    wp_register_script(

        'apimo-slick-script',

        $apimo_url . '/assets/js/slick.min.js'

    );

    wp_register_script(

        'apimo-pagination-script',

        $apimo_url . '/assets/js/pagination.min.js'

    );

    wp_register_script(

        'apimo-moment-script',

        $apimo_url . '/assets/js/moment.min.js'

    );

    wp_register_script(

        'apimo-daterange-script',

        $apimo_url . '/assets/js/daterangepicker.js'

    );

    wp_register_script(

        'apimo-lightbox-script',

        $apimo_url . '/assets/js/fslightbox.js'

    );

    wp_enqueue_script('jquery');

    wp_enqueue_script('apimo-frontend-select2-script');

    wp_enqueue_script('apimo-slick-script');

    wp_enqueue_script('apimo-pagination-script');

    wp_enqueue_script('apimo-moment-script');

    wp_enqueue_script('apimo-daterange-script');

    wp_enqueue_script('apimo-lightbox-script');

    // wp_enqueue_script('bpopup');


    wp_enqueue_script('apimo-front-js');
}



add_action("admin_enqueue_scripts", "apimo_backend_scripts");

function apimo_backend_scripts()

{

    global $apimo_dir, $apimo_url;



    wp_register_style('apimo-admin', $apimo_url . '/assets/css/admin.css');



    wp_register_style('apimo-select2-style', $apimo_url . '/assets/css/select2.min.css');

    wp_register_style('apimo-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

    wp_register_style('apimo-admin-daterange', $apimo_url . '/assets/css/daterangepicker.css');

    wp_enqueue_style('wp-color-picker');

    wp_enqueue_style('apimo-font-awesome');

    wp_enqueue_style('apimo-select2-style');

    wp_enqueue_style('apimo-admin-daterange');

    wp_enqueue_style('apimo-admin');





    wp_register_script(

        'apimo-bpopup',

        $apimo_url . '/assets/js/jquery.bpopup.min.js'

    );

    wp_register_script(

        'apimo-select2-script',

        $apimo_url . '/assets/js/select2.min.js'

    );

    wp_register_script(

        'apimo-admin',

        $apimo_url . '/assets/js/admin.js',

        array('wp-color-picker')

    );

    wp_register_script(

        'apimo-daterange-script',

        $apimo_url . '/assets/js/daterangepicker.js'

    );

    wp_register_script(

        'apimo-moment-script',

        $apimo_url . '/assets/js/moment.min.js'

    );

    wp_enqueue_script('jquery');

    wp_enqueue_script('apimo-bpopup');

    wp_enqueue_script('apimo-select2-script');

    wp_enqueue_script('apimo-moment-script');

    wp_enqueue_script('apimo-daterange-script');

    wp_enqueue_script('apimo-admin');

    wp_localize_script(

        'apimo-admin',

        'admin_urls',

        array(

            'ajax' => admin_url('admin-ajax.php'),

            'from' => __('From', 'apimo'),

            'to' => __('To', 'apimo'),

        )

    );

    
}




add_action('admin_menu', 'apimo_register_settings_tab');



function apimo_register_settings_tab()

{

    global $apimo_dir, $apimo_url;

    add_menu_page(__('Apimo', 'apimo'), __('Apimo', 'apimo'), 'manage_options', 'apimo', 'apimo_settings_tab_callback', $apimo_url . 'assets/images/apimo_menu.svg');

    add_submenu_page('apimo', __('Settings', 'apimo'), __('Settings', 'apimo'), 'manage_options', 'apimo', 'apimo_settings_tab_callback');

    add_submenu_page('apimo', __('Logs', 'apimo'), __('Logs', 'apimo'), 'manage_options', 'apimo_logs', 'apimo_logs_callback');

    add_submenu_page('apimo', __('Integrations', 'apimo'), __('Integrations', 'apimo'), 'manage_options', 'apimo_integrations', 'apimo_integration_callback');

    add_submenu_page('apimo', __('Zones', 'apimo'), __('Zones', 'apimo'), 'manage_options', 'apimo_zones', 'apimo_zones_callback');

}

function apimo_zones_callback()

{
    global $apimo_dir;
    include $apimo_dir . 'admin/zones.php';
}



function apimo_logs_callback()

{
    global $apimo_dir;
    include $apimo_dir . 'admin/logs.php';
}



function apimo_integration_callback()

{
    global $apimo_dir;
    include $apimo_dir . 'admin/integrations.php';
}


function apimo_all_shortcode_callback()

{



    global $wpdb;

    $tablename = $wpdb->prefix . 'apimo_shortcode';



    if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'delete') {
        // Sanitize and validate the 'id' parameter
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id !== false) {
            // Escape the value to prevent SQL injection attacks
            $id = esc_sql($id);
            // Execute the DELETE query using the sanitized and escaped value
            $wpdb->delete($tablename, array('id' => $id));
        }
    }






    if (isset($_POST['update_shortcode']) && isset($_GET['id'])) {

        // Sanitize input data
        $title = sanitize_text_field($_POST['title']);
        $shortcode_data = sanitize_textarea_field($_POST['shortcode_data']);
        $template_type = sanitize_text_field($_POST['template_type']);

        // Validate input data
        if (!empty($title) && !empty($shortcode_data) && !empty($template_type)) {
            // Update the shortcode
            $updated = $wpdb->update(
                $tablename,
                array(
                    'shortcode_name' => $title,
                    'shortcode_data' => $shortcode_data,
                    'parameters' => $template_type,
                ),
                array(
                    'id' => sanitize_text_field($_GET['id'])
                )
            );
        } else {
            // Display an error message
            echo 'Error: Invalid input';
        }
    }



    if (isset($_GET['action']) && $_GET['action'] == 'edit') {

        if (isset($_GET['id'])) {

            $id = intval(sanitize_text_field($_GET['id']));

            $update =  $wpdb->get_row("SELECT * FROM `" . $tablename . "` WHERE id='" . $id . "'");

?>

            <div class="update-shortcode">

                <form name="update-form" method="post">

                    <div class="heading">

                        <h1>Edit ShortCode</h1>

                    </div>

                    <div class="content">

                        <div class="title">

                            <input type="text" name="title" placeholder="Enter Shortcode Name" value="<?php echo esc_attr($update->shortcode_name); ?>">

                        </div>

                        <hr />

                        <div class="shortcode_data">

                            <label>Shortcode Content : </label>

                            <textarea name="shortcode_data" row="15" col="50">
                                <?php echo esc_textarea($update->shortcode_data); ?>
                            </textarea>

                        </div>

                        <div class='params'>

                            <label>Select Template Type : </label>

                            <label>

                                <label>

                                    <input type="radio" name="template_type" id="template_1" value="template_1" <?php if ($update->parameters == 'template_1') {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>

                                    <label for="template_1">Template 1</label>

                                </label>

                                <label>

                                    <input id="template_2" type="radio" name="template_type" value="template_2" <?php if ($update->parameters == 'template_2') {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>

                                    <label for="template_2">Template 2</label>

                                </label>

                            </label>

                        </div>

                    </div>

                    <div class="submit-button">

                        <input type="submit" name="update_shortcode" value="Update Shortcode">

                    </div>

                </form>

            </div>

        <?php

        }
    } else {

        ?>



        <div class="list-of-sortcode">

            <div class="list-heading">

                <h2>All Shortcode</h2>

            </div>

            <div class="all-shortcode">

                <?php

                $rows =  $wpdb->get_results('SELECT * FROM ' . $tablename);



                foreach ($rows as $row) {

                ?>

                    <div class="row">

                        <div class="col id"><?php echo esc_html($row->id); ?></div>

                        <div class="col name"><?php echo esc_html($row->shortcode_name); ?></div>

                        <div class="col content"><?php echo esc_html($row->shortcode_data); ?></div>

                        <div class="col params"><?php echo esc_html($row->parameters); ?></div>

                        <div class="col shortcode"><input type="test" value="[apimo_list id='<?php echo esc_attr($row->id); ?>']" readonly></div>



                        <div class="col delete" data_id="<?php echo esc_attr($row->id); ?>"><a><i class="fa fa-trash" style="font-size:36px;color:red"></i></a></div>



                        <div class="col edit"><a href="<?php echo esc_url(get_permalink()); ?>edit.php?post_type=realestate&page=apimo_all_shortcode&action=edit&id=<?php echo esc_attr($row->id); ?>"><i class="fa fa-edit" style="font-size:36px;"></i></a></div>

                    </div>

                <?php

                }

                ?>

            </div>

        </div>

    <?php

    }
}



function apimo_settings_tab_callback()

{

    global $apimo_dir;

    include $apimo_dir . 'admin/settings.php';
}



function apimo_add_new_shortcode_callback()

{



    if (isset($_POST['add_new_shortcode'])) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'apimo_shortcode';
        $title = sanitize_text_field($_POST['title']);
        $shortcode_data = sanitize_textarea_field($_POST['shortcode_data']);
        $template_type = sanitize_text_field($_POST['template_type']);
        if (in_array($template_type, array('template_1', 'template_2'))) {
            $wpdb->insert($tablename, array(
                'shortcode_name' => $title,
                'shortcode_data' => $shortcode_data,
                'parameters' => $template_type
            ));
        }
    }


    ?>



    <div class="add-new-shortcode">

        <form name="add-new-form" method="post">

            <div class="heading">

                <h1>Add New ShortCode</h1>

            </div>

            <div class="content">

                <div class="title">

                    <input type="text" name="title" placeholder="Enter Shortcode Name">

                </div>

                <hr />

                <div class="shortcode_data">

                    <label>Shortcode Content : </label>

                    <textarea name="shortcode_data" row="15" col="50"></textarea>

                </div>

                <div class='params'>

                    <label>Select Template Type : </label>

                    <label>

                        <label>

                            <input type="radio" name="template_type" id="template_1" value="template_1">

                            <label for="template_1">Template 1</label>

                        </label>

                        <label>

                            <input id="template_2" type="radio" name="template_type" value="template_2">

                            <label for="template_2">Template 2</label>

                        </label>

                    </label>

                </div>

            </div>

            <div class="submit-button">

                <input type="submit" name="add_new_shortcode" value="Add New Shortcode">

            </div>

        </form>

    </div>



<?php

}





add_action('wp_head', 'apimo_internal_css');



function apimo_internal_css()

{

    $apimo_style = get_option('apimo_style');

    // echo '<pre>';

    // print_r($apimo_style);

    // echo '</pre>';



?>

    <style id="apimo_internal_css">
        .apimo-wrapper .apimo-wrapper__inner {

            max-width: <?php echo $apimo_style['container_width']; ?><?php echo $apimo_style['container_width_unit']; ?>;

        }

        .apimo-wrapper .apimo-content-wrapper .Pro-detail-wrapper h3 {

            color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .Pro-detail-wrapper .Pro-d-price {

            color: <?php echo $apimo_style['secondary']['color']; ?> !important;

        }

        .apimo-properties-item.Product-block .Pro-category {

            background-color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .Product-wrapper .Product-block .Pro-category.ProCategory2 {

            background-color: <?php echo $apimo_style['secondary']['color']; ?> !important;

        }

        .Product-wrapper .apimo-properties-item.Product-block .Pro-content .Pro-name h3 {

            color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .apimo-wrapper .apimo-wrapper__inner .paginationjs-page.J-paginationjs-page.active {

            border-color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .apimo-wrapper .apimo-wrapper__inner .paginationjs-page.J-paginationjs-page.active a {

            color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .apimo-filter-wrapper .filter-item-dropdown .apply-filter button {

            background-color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .apimo-filter-wrapper .filter-item-dropdown .apply-filter button:hover {

            background-color: <?php echo $apimo_style['secondary']['color']; ?> !important;

        }

        .apimo-filter-wrapper .filter-item-dropdown .apimo-aditional-filter input:checked+label.apimo-archive-filter {

            border-color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .apimo-filter-wrapper .filter-item.filter-dates .filter-item-dropdown input:checked+label {

            border-color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .apimo-content-wrapper .paginationjs-pages ul li.active {

            border-color: <?php echo $apimo_style['primary']['color']; ?> !important;

            color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }

        .apimo-content-wrapper .paginationjs-pages ul li.active a {

            color: <?php echo $apimo_style['primary']['color']; ?> !important;

        }
    </style>

<?php

}


function apimo_currency_format($amount, $currency = 'EUR')
{
    // Ensure $currency is a string
    if (is_array($currency)) {
        // Handle the case where $currency is an array
        $currency = isset($currency[0]) ? $currency[0] : 'EUR'; // Default to 'EUR' if the array is empty or invalid
    } elseif (!is_string($currency)) {
        // Handle other unexpected types by setting to default
        $currency = 'EUR';
    }

    switch ($currency) {
        case 'XOF': // Franc CFA
            return number_format((float)$amount, 0, ',', ' ') . ' CFA';

        case 'USD': // US Dollar
            return '$' . number_format((float)$amount, 2, '.', ',');

        case 'GBP': // British Pound
            return '£' . number_format((float)$amount, 2, '.', ',');

        case 'JPY': // Japanese Yen
            return '¥' . number_format((float)$amount, 0, ',', ' ');

        case 'EUR': // Euro
            return '€ ' . str_replace(',00', '', number_format((float)$amount, 2, ',', '.'));

        case 'CAD': // Canadian Dollar
            return 'C$' . number_format((float)$amount, 2, '.', ',');

        case 'AUD': // Australian Dollar
            return 'A$' . number_format((float)$amount, 2, '.', ',');

        case 'CHF': // Swiss Franc
            return number_format((float)$amount, 2, '.', '\'') . ' CHF';

        case 'CNY': // Chinese Yuan
            return '¥' . number_format((float)$amount, 2, '.', ',');

        case 'INR': // Indian Rupee
            return '₹' . number_format((float)$amount, 2, '.', ',');

        case 'MXN': // Mexican Peso
            return '$' . number_format((float)$amount, 2, '.', ',') . ' MXN';

        case 'BRL': // Brazilian Real
            return 'R$' . number_format((float)$amount, 2, '.', ',');

        case 'ZAR': // South African Rand
            return 'R' . number_format((float)$amount, 2, '.', ',');

        case 'RUB': // Russian Ruble
            return number_format((float)$amount, 2, ',', ' ') . ' ₽';

        case 'SEK': // Swedish Krona
            return number_format((float)$amount, 2, ',', ' ') . ' kr';

        case 'NOK': // Norwegian Krone
            return number_format((float)$amount, 2, ',', ' ') . ' kr';

        case 'DKK': // Danish Krone
            return number_format((float)$amount, 2, ',', ' ') . ' kr';

        case 'PLN': // Polish Zloty
            return number_format((float)$amount, 2, ',', ' ') . ' zł';

        case 'TRY': // Turkish Lira
            return number_format((float)$amount, 2, ',', ' ') . ' ₺';

        default:
            // If the currency is not recognized, return the amount with a generic symbol or empty string
            return number_format((float)$amount, 2, '.', ',') . ' ' . strtoupper($currency);
    }
}

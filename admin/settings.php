<?php



global $apimo_dir, $apimo_url;












if (isset($_POST['save_general_setting'])) {

    // foreach ($_POST['step']['step_3']['view_1'] as $key => $value) {
    //     echo "<br> ".$key . ": ===============>" . $value . "<br>";
    // }

    //update_option('apimo_steps', $_POST['step']);
    $steps = filter_var_array($_POST['step'], FILTER_SANITIZE_NUMBER_INT);
    update_option('apimo_steps', $steps);




    $style = filter_var_array($_POST['style'], FILTER_UNSAFE_RAW);




    update_option('apimo_style', $style);

















    update_option('apimo_style_pagina', sanitize_text_field($_POST['apimo_style_pagina']));



    $archive = array(
        'archive_slug' => sanitize_text_field($_POST['archive']['archive_slug']),
        'single_slug' => sanitize_text_field($_POST['archive']['single_slug']),
        'template' => sanitize_text_field($_POST['archive']['template']),
        'view_1' => filter_var_array($_POST['archive']['view_1'], FILTER_UNSAFE_RAW),
        'filter' => filter_var_array($_POST['archive']['filter'], FILTER_UNSAFE_RAW),
        'pagination_enable' => sanitize_text_field($_POST['archive']['pagination_enable']),
        'num_of_post' => filter_var($_POST['archive']['num_of_post'], FILTER_SANITIZE_NUMBER_INT),
        'archive_display_option' => filter_var_array($_POST['archive']['archive_display_option'], FILTER_UNSAFE_RAW),
        'area_display_type' => sanitize_text_field($_POST['archive']['area_display_type']),
        'gallery_display_slider' => filter_var($_POST['archive']['gallery_display_slider'], FILTER_VALIDATE_INT),
        'hideicon' => (isset($_POST['archive']['hideicuserinfoon'])) ? sanitize_text_field($_POST['archive']['hideicon']) : "showicon",
        'userinfo' => (isset($_POST['archive']['userinfo'])) ? sanitize_text_field($_POST['archive']['userinfo']) : "show",
    );






    update_option('apimo_style_archive', $archive);


    if (isset($_POST['apimo_show_unavailable_service']) && filter_var($_POST['apimo_show_unavailable_service'], FILTER_VALIDATE_INT) == 1) {

        update_option('apimo_show_unavailable_service', 1);
    } else {

        update_option('apimo_show_unavailable_service', 0);
    }

    $form_configuration = array(
        'last_name' => array(
            'label' => sanitize_text_field($_POST['apimo_last_name_label']),
            'placeholder' => sanitize_text_field($_POST['apimo_last_name_placeholder']),
            'required' => isset($_POST['apimo_last_name_required']) ? 1 : 0,
        ),
        'first_name' => array(
            'label' => sanitize_text_field($_POST['apimo_first_name_label']),
            'placeholder' => sanitize_text_field($_POST['apimo_first_name_placeholder']),
            'required' => isset($_POST['apimo_first_name_required']) ? 1 : 0,
        ),
        'phone' => array(
            'label' => sanitize_text_field($_POST['apimo_phone_label']),
            'placeholder' => sanitize_text_field($_POST['apimo_phone_placeholder']),
            'required' => isset($_POST['apimo_phone_required']) ? 1 : 0,
        ),
        'email' => array(
            'label' => sanitize_text_field($_POST['apimo_email_label']),
            'placeholder' => sanitize_text_field($_POST['apimo_email_placeholder']),
            'required' => isset($_POST['apimo_email_required']) ? 1 : 0,
        ),
        'message' => array(
            'label' => sanitize_text_field($_POST['apimo_message_label']),
            'placeholder' => sanitize_text_field($_POST['apimo_message_placeholder']),
            'required' => isset($_POST['apimo_message_required']) ? 1 : 0,
        ),
    );

    update_option('form_configuration', $form_configuration);

    global $wp_rewrite;

    $wp_rewrite->flush_rules(true);
}



if (isset($_POST['clear_all_data'])) {

    global $wpdb;


    // Query to find all attachment IDs with the 'apimo_image_id' meta key
    $sql = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'apimo_image_id'";
    $images = $wpdb->get_col($sql);

    // Delete each image found
    foreach ($images as $image_id) {
        wp_delete_attachment($image_id, true);
    }

    // Define the post type and any additional conditions if needed
    $post_type = 'property';


    // Construct the SQL query to delete posts and their post metadata
    $sql = $wpdb->prepare(
        "DELETE posts, postmeta
        FROM {$wpdb->posts} AS posts
        LEFT JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
        WHERE posts.post_type = %s",
        $post_type
    );

    // Execute the SQL query
    $wpdb->query($sql);



    $terms = get_terms(
        array(
            'taxonomy' => array(
                'apimo_areas',
                'apimo_property_standing',
                'apimo_property_condition',
                'apimo_water_hot_device',
                'apimo_water_hot_access',
                'apimo_water_waste',
                'apimo_heating_type',
                'apimo_heating_access',
                'apimo_heating_device',
                'apimo_floor',
                'apimo_property_building',
                'apimo_construction',
                'apimo_subtype',
                'apimo_type',
                'apimo_availability',
                'apimo_orientation',
                'apimo_service',
                'apimo_category',
                'apimo_sub_category',
                'country',
                'region',
                'city',
                'district',
                'repository_tags',
                'customised_tags',
            ),
            'hide_empty' => false
        )
    );

    foreach ($terms as $term) {
        wp_delete_term($term->term_id, $term->taxonomy);
    }

    delete_option('apimo_initalize');
}



$apimo_api_keys = get_option('apimo_key_data');
$uniqueProviderIDs = [];
$uniqueAgencyIDs = [];

if (is_array($apimo_api_keys)) {
    foreach ($apimo_api_keys as $keyData) {
        if (isset($keyData['company_id'])) {
            $uniqueProviderIDs[] = $keyData['company_id'];
        }
        if (isset($keyData['agency_id'])) {
            $uniqueAgencyIDs[] = $keyData['agency_id'];
        }
    }

    $uniqueProviderIDs = array_unique($uniqueProviderIDs);
    $uniqueAgencyIDs = array_unique($uniqueAgencyIDs);

    // Count the unique IDs
    $providerIDCount = count($uniqueProviderIDs);
    $agencyIDCount = count($uniqueAgencyIDs);

    update_option('providerIDCounts', $providerIDCount);
    update_option('agencyIDCounts', $agencyIDCount);
}


$apimo_api_key = get_option('apimo_api_key');



$apimo_steps = get_option('apimo_steps');



$apimo_style = get_option('apimo_style');




$apimo_style_pagina = get_option('apimo_style_pagina');



$archive = get_option('apimo_style_archive');



$apimo_company_id = get_option('apimo_company_id');



$apimo_show_unavailable_service = get_option('apimo_show_unavailable_service', 0);



$apimo_api_key_validate = get_option('apimo_api_key_validate');



$archive['filter'] = $archive['filter'] ? $archive['filter'] : array();



// echo '<pre>';



// print_r($archive);



// echo '</pre>';



?>

<?php



if (isset($_POST['clear_all_data'])) {

?>

    <p>All data reset</p>

<?php

}

?>



<style>
    .dropdown {

        float: left;

        overflow: hidden;

    }



    .dropdown .dropbtn {

        cursor: pointer;

        font-size: 16px;

        border: none;

        outline: none;

        color: #2271b1;

        background-color: inherit;

        margin: 0;

        font-size: 13px;

        line-height: 1.4em;

        text-decoration: underline;

    }



    .dropdown-content {

        display: none;

        position: absolute;

        background-color: #f9f9f9;

        min-width: 160px;

        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);

        z-index: 1;

    }



    .dropdown-content a {

        float: none;

        color: black;

        padding: 12px 16px;

        text-decoration: none;

        display: block;

        text-align: left;

    }



    .dropdown-content a:hover {

        background-color: #ddd;

    }



    .show {

        display: block;

    }
</style>



<button class="scheduled_icon wt_iew_export_action_btn run_menual_scheduler scheduled_icon icon" name="run_scheduler">
    <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/gear-setting-icon-png.webp' ?>" title="Run scheduler for featching data">
</button>
<button class="shortcode_icon wt_iew_export_action_btn icon" id="apimo_create_shortcode" title="Generate a shortcode">
    <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/images/shortcodeicon.png'; ?>" alt="shortcode">
</button>

<form method="post">

    <div class="apimo-dashboard">

        <div class="apimo-header">
            <div class="apimo-logo">
                <img src="<?php echo esc_url($apimo_url . '/assets/images/small-logo.svg'); ?>">
            </div>

            <div class="apimo-nav">

                <nav>

                    <ul>

                        <li> <a href="/wp-admin/admin.php?page=apimo"><?php echo _e('Settings', 'Apimo'); ?></a> </li>

                        <li> <a href="/wp-admin/admin.php?page=apimo_logs"><?php echo _e('Logs', 'Apimo'); ?></a> </li>

                        <li>

                            <div class="dropdown">

                                <button type="button" class="dropbtn" onclick="openDropMenu()"><?php echo _e('Documentation', 'Apimo'); ?>

                                    <i class="fa fa-caret-down"></i>

                                </button>

                                <div class="dropdown-content" id="myDropdown">

                                    <a href="<?php echo esc_url($apimo_url . '/doc/guida_installazione.pdf'); ?>" target="_blank">Italiano</a>

                                    <a href="<?php echo esc_url($apimo_url . '/doc/guide_installation.pdf'); ?>" target="_blank">Français</a>

                                    <a href="<?php echo esc_url($apimo_url . '/doc/installation_guide.pdf'); ?>" target="_blank">English</a>


                                </div>

                            </div>

                        </li>

                        <li> <input type="submit" class="button button-primary wt_iew_export_action_btn" name="save_general_setting" value="<?php _e('Save', 'apimo'); ?>"> </li>

                        <li> <input type="submit" class="button button-primary wt_iew_export_action_btn" name="clear_all_data" value="<?php _e('Clear all data', 'apimo'); ?>"> </li>

                    </ul>

                </nav>

            </div>

        </div>

        <div class="apimo_settings_tab">

            <!-- General setting -->
            <!--Welcome Section -->
            <div class="apimo-block">
                <div class="apimo_welcome_block">
                    <div class="apimo_state">
                        <span class="apimo_date">
                            <?php echo date('d/m/Y'); ?>
                        </span>
                        <h4><?php _e('Welcome', 'apimo') ?>, <span class="apimo_user">
                                <?php
                                $current_user = wp_get_current_user();
                                if ($current_user->exists()) {
                                    echo $current_user->user_login . "!";
                                } else {
                                    echo "User";
                                }

                                ?>
                            </span></h4>
                        <span class="apimo_message"><?php _e('See What’s happening with Apimo Plugin.', 'apimo') ?></span>
                        <div class="apimo_data">
                            <div class="apimo_card provider">
                                <h5><?php _e('Providers', 'apimo') ?></h5>

                                <span>
                                    <?php
                                    if (get_option('providerIDCounts')) {
                                        echo get_option('providerIDCounts');
                                    } else {
                                        echo "0";
                                    }

                                    ?>
                                </span>
                            </div>
                            <div class="apimo_card agencies">
                                <h5><?php _e('Agencies', 'apimo') ?></h5>
                                <span>
                                    <?php
                                    if (get_option('agencyIDCounts')) {
                                        echo get_option('agencyIDCounts');
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="apimo_card properties">
                                <h5><?php _e('Properties', 'apimo') ?></h5>
                                <span>
                                    <?php
                                    $args = array(
                                        'post_type' => 'property',
                                        'posts_per_page' => -1,
                                    );

                                    $query = new WP_Query($args);

                                    $count = $query->found_posts;
                                    echo $count;
                                    ?>
                                </span>
                            </div>
                            <div class="apimo_card provider">
                                <h5><?php _e('BookMark', 'apimo') ?></h5>

                                <span>
                                    <?php
                                    if (get_option('apimo_shortcodes')) {
                                        echo count(get_option('apimo_shortcodes'));
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="apimo_image">
                        <img src="<?php echo  plugin_dir_url(dirname(__FILE__)) . 'assets/images/welcome.png'; ?>" alt="">
                    </div>
                </div>
            </div>

            <div class="apimo-block apimo_setting_section general-setting">
                <div class="apimo-block-header">
                    <h3><?php _e('General settings', 'apimo'); ?></h3>
                </div>
                <div class="apimo-block-body apimo-section-description">
                    <div class="apimo-api-key-information">
                        <div class="apimo-api-key-information-row-wrap">
                            <?php
                            if (!empty($apimo_api_keys)) :
                                foreach ($apimo_api_keys as $data) :
                                    if ($data['key'] == '' && $data['company_id'] == '') {
                                        continue;
                                    }
                                    $provider_id = $data['company_id'];
                                    if (!isset($providers[$provider_id])) {
                                        $providers[$provider_id] = array();
                                    }
                                    $providers[$provider_id][] = $data;
                                endforeach;
                                $i = 0;
                                foreach ($providers as $provider_id => $agencies) :
                            ?>
                                    <div class="apimo-api-key-information-row">
                                        <div class="apimo-row apimo-row-v-center">
                                            <div class="apimo-col-3 col-btn">
                                                <button type="button" class="apimo-remove-data">
                                                    <svg id="Modalità_Isolamento" data-name="Modalità Isolamento" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.61 408.8">
                                                        <path d="M294.54,239A204.44,204.44,0,0,0,5.46,239c-79.68,79.7-79.68,209.37,0,289.07a204.41,204.41,0,0,0,289.07,0c79.68-79.7,79.68-209.38,0-289.07ZM253,403.1H47.06V363.9H253Z" transform="translate(54.3 -179.1)" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="apimo-col-3">
                                                <label class="apimo-compnay-id-box">
                                                    <span class="apimo-general-setting-label">
                                                        <?php _e('Provider ID', 'apimo'); ?>
                                                    </span>
                                                    <input type="text" name="apimo_company_id[]" class="apimo-input_text" value="<?php echo esc_html($provider_id); ?>" />
                                                </label>
                                            </div>
                                            <div class="apimo-col-3">
                                                <label class="apimo-api-key-box">
                                                    <span><?php _e('Add your API key', 'apimo'); ?></span>
                                                    <input type="text" name="inserisci_api_key[]" class="apimo-input_text" value="<?php echo esc_html($agencies[$i]['key']); ?>" />
                                                </label>
                                            </div>
                                            <div class="apimo-col-3">
                                                <label class="apimo-sector-id-box">
                                                    <span><?php _e('Sector ID (optional)', 'apimo'); ?></span>
                                                    <input type="text" name="sector_id[]" class="apimo-input_text" value="<?php echo esc_html($agencies[$i]['sector_id']); ?>" />
                                                </label>
                                            </div>
                                            <div class="apimo-col-2">
                                                <div class="apimo-valid-invalid">
                                                    <div class="apimo-valid apimo-api_key_validation" <?php if ($data['is_valid']) {
                                                                                                            echo 'style="display:flex"';
                                                                                                        } ?>>
                                                        <div class="apimo-circle_green"></div>
                                                        <div class="apimo-validation_text"><?php _e('Your keys are valid'); ?></div>
                                                    </div>
                                                    <div class="apimo-invalid apimo-api_key_validation" <?php if (!$data['is_valid']) {
                                                                                                            echo 'style="display:flex"';
                                                                                                        } ?>>
                                                        <div class="apimo-circle_red"></div>
                                                        <div class="apimo-validation_text"><?php _e('Your keys are not valid'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="apimo-col-4">
                                                <?php
                                                foreach ($agencies as $agency) :
                                                ?>
                                                    <div class="apimo-agency">
                                                        <div class="apimo-agency-info">
                                                            <strong><?php _e('Agence ID', 'apimo'); ?>:</strong> <?php echo esc_html($agency['agency_id']); ?>
                                                        </div>
                                                        <div class="apimo-agency-info">
                                                            <strong><?php _e('Sector ID', 'apimo'); ?>:</strong> <?php echo esc_html($agency['sector_id']); ?>
                                                        </div>
                                                    </div>
                                                <?php
                                                endforeach;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="apimo-footer align-right apimo-api-information-save">
                    <div class="">
                        <button type="button" class="button button-outline apimo-input_button" id="add_new_agency"><?php _e("Add new agency", 'apimo'); ?></button>
                        <input type="button" name="check_api_key" value="<?php _e('Validate Key/Save', 'apimo'); ?>" class="button button-primary wt_iew_export_action_btn apimo-input_button" />
                    </div>
                </div>
                <div class="apimo-api-key-information-row" id="apimo-api-key-information-row-clone" style="display:none">
                    <div class="apimo-row apimo-row-v-center">
                        <div class="apimo-col-3 col-btn">
                            <button type="button" class="apimo-remove-data">
                                <svg id="Modalità_Isolamento" data-name="Modalità Isolamento" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.61 408.8">
                                    <path d="M294.54,239A204.44,204.44,0,0,0,5.46,239c-79.68,79.7-79.68,209.37,0,289.07a204.41,204.41,0,0,0,289.07,0c79.68-79.7,79.68-209.38,0-289.07ZM253,403.1H47.06V363.9H253Z" transform="translate(54.3 -179.1)" />
                                </svg>
                            </button>
                        </div>
                        <div class="apimo-col-3">
                            <label class="apimo-compnay-id-box">
                                <span class="apimo-general-setting-label"><?php _e('Provider ID', 'apimo'); ?></span>
                                <input type="text" name="apimo_company_id[]" class="apimo-input_text" value="" />
                            </label>
                        </div>
                        <div class="apimo-col-3">
                            <label class="apimo-api-key-box">
                                <span><?php _e('Add your API key', 'apimo'); ?></span>
                                <input type="text" name="inserisci_api_key[]" class="apimo-input_text" value="" />
                            </label>
                        </div>
                        <div class="apimo-col-3">
                            <label class="apimo-sector-id-box">
                                <span><?php _e('Sector ID (optional)', 'apimo'); ?></span>
                                <input type="text" name="sector_id[]" class="apimo-input_text" value="" />
                            </label>
                        </div>
                        <div class="apimo-col-3">
                            <div class="apimo-valid-invalid">
                                <div class="apimo-valid apimo-api_key_validation">
                                    <div class="apimo-circle_green"></div>
                                    <div class="apimo-validation_text"><?php _e('Your keys are valid'); ?></div>
                                </div>
                                <div class="apimo-invalid apimo-api_key_validation">
                                    <div class="apimo-circle_red"></div>
                                    <div class="apimo-validation_text"><?php _e('Your keys are not valid'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!--Scheduled -->
            <div style="padding: 30px;" class="apimo-block">
                <?php
                global $wpdb;

                $tablename = $wpdb->prefix . 'actionscheduler_actions';

                $rows =  $wpdb->get_results(
                    'SELECT * FROM ' . $tablename . ' 
    WHERE hook="apimo_import_property_recurring" 
    OR hook="apimo_fetch_property_manual" 
    ORDER BY ' . $tablename . '.action_id DESC 
    LIMIT 5'
                );
                ?>
                <div class="apimo-row">
                    <div class="apimo-col-8">

                        <div class="apimo-block">

                            <div class="apimo-block-header">

                                <h3><?php _e('Scheduled Logs', 'apimo'); ?></h3>

                            </div>

                            <div class="apimo-block-body">

                                <div class="apimo-block-info">

                                    <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p> -->

                                </div>

                                <table class="wp-list-table widefat fixed striped feeds">

                                    <thead>

                                        <tr>

                                            <th scope="col"><?php echo _e('Action ID', 'Apimo'); ?></th>

                                            <th scope="col"><?php echo _e('Hook', 'Apimo'); ?></th>

                                            <th scope="col"><?php echo _e('Status', 'Apimo'); ?></th>

                                            <th scope="col"><?php echo _e('Args', 'Apimo'); ?></th>

                                            <th scope="col"><?php echo _e('Time', 'Apimo'); ?></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        foreach ($rows as $row) {

                                            // if($row->hook == 'apimo_fetch_property_recurring' || $row->hook == 'apimo_fetch_property_manual'){

                                        ?>

                                            <tr>

                                                <td><?php echo esc_html($row->action_id); ?></td>

                                                <td><?php echo esc_html($row->hook); ?></td>

                                                <td><?php echo esc_html($row->status); ?></td>

                                                <td><?php echo esc_html($row->args); ?></td>

                                                <td><?php echo esc_html($row->scheduled_date_local); ?></td>

                                            </tr>

                                        <?php

                                            //  }

                                        }

                                        ?>

                                    </tbody>

                                    <tfoot>

                                        <tr>

                                            <th scope="col"><?php echo _e('Action ID', 'Apimo'); ?></th>

                                            <th scope="col"><?php echo _e('Hook', 'Apimo'); ?></th>

                                            <th scope="col"><?php echo _e('Status', 'Apimo'); ?></th>

                                            <th scope="col"><?php echo _e('Args', 'Apimo'); ?></th>

                                            <th scope="col"><?php echo _e('Time', 'Apimo'); ?></th>

                                        </tr>

                                    </tfoot>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="apimo-col-4">

                        <div class="apimo-block">

                            <div class="apimo-block-header">

                                <h3><?php _e('Manually Run', 'apimo') ?></h3>

                            </div>

                            <div class="apimo-block-body">

                                <div class="apimo-block-info apimo-api-result">

                                    <p><?php _e('You can manually run the properties import from APIMO webservices.', 'apimo') ?></p>

                                </div>

                            </div>

                            <div class="apimo-footer align-right">

                                <input type="button" class="button button-primary wt_iew_export_action_btn run_menual_scheduler" name="run_scheduler" value="<?php _e('Run Scheduler', 'apimo') ?>">

                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!-- Shortcodes setting -->
            <div class="apimo-block apimo-crea-shortcode">

                <div class="apimo-block-header">

                    <h3><?php _e('Generate shortcode', 'apimo'); ?></h3>

                </div>

                <div class="apimo-block-body">

                    <div class="apimo-block-info">

                        <p><?php _e('Create a shortcode and place anywhere on your website.', 'apimo'); ?></p>
                        <?php
                        $shortcodes = get_option('apimo_shortcodes');
                        // Assuming your option name is 'shortcode'
                        // echo "<pre>";
                        // print_r($shortcodes);
                        // echo "</pre>";
                        if (is_array($shortcodes) && !empty($shortcodes)) {
                            // Display the table only if there are shortcodes
                        ?>
                            <table id="shortcodes">
                                <tr>
                                    <th><?php _e('Title', 'apimo') ?></th>
                                    <th><?php _e('Description', 'apimo') ?></th>
                                    <th><?php _e('Shortcode', 'apimo') ?></th>
                                    <th><?php _e('Action', 'apimo') ?></th>
                                </tr>
                                <?php
                                foreach ($shortcodes as $index => $shortcode) {
                                    echo '<tr>';
                                    echo '<td>' . $shortcode['Title'] . '</td>';
                                    echo '<td>' . $shortcode['Description'] . '</td>';
                                    // Use stripslashes to remove backslashes from the displayed shortcode
                                    echo '<td class="shortcode-cell" id="shortcode_' . $index . '">' . stripslashes($shortcode['Shortcode']) . '</td>';
                                    echo '<td><button class="btn button button-danger" id="delete_shortcode" data-id="' . $index . '">' . __("Delete", "apimo") . '</button><button class="btn button apimo-step-button" id="apimo_copy_shortcode" data-id="' . $index . '">' . __("Copy", "apimo") . '</button></td>';
                                    echo '</tr>';
                                }
                                ?>
                            </table>

                        <?php
                        }
                        ?>



                    </div>
                    <!-- New one -->
                    <div class="apimo-create-shortcode-popup" id="apimo-create-shortcode-popup" style="display:none">

                        <div class="apimo-shortcode-header">

                            <h3><?php _e('Generate shortcode', 'apimo'); ?></h3>

                        </div> <button type="button" id="apimo-close-shortcode-popup"> <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 381.49 381.49">

                                <path d="M380.58,285.83,541.45,446.7a17.5,17.5,0,0,1-24.75,24.75L355.83,310.58,195,471.45a17.5,17.5,0,0,1-24.75-24.75L331.08,285.83,170.21,125A17.5,17.5,0,0,1,195,100.21L355.83,261.08,516.7,100.21A17.5,17.5,0,0,1,541.45,125Z" transform="translate(-165.09 -95.09)" />

                            </svg> </button>

                        <div class="apimo-steps-titles">
                            <button type="button" class="apimo-step-title active" data-id="1">1</button>
                            <button type="button" class="apimo-step-title" data-id="2">2</button>
                            <button type="button" class="apimo-step-title" data-id="3">3</button>
                            <button type="button" class="apimo-step-title" data-id="4">4</button>
                            <button type="button" class="apimo-step-title" data-id="5">5</button>
                            <button type="button" class="apimo-step-title" data-id="6">6</button>
                            <button type="button" class="apimo-step-title" data-id="7">7</button>
                        </div>


                        <div class="apimo-step step-1 active" data-id="1">

                            <div class="apimo-step-title-inner">

                                <h5><?php _e('Select the properties', 'apimo'); ?></h5>

                                <p><?php _e('Choose the properties to show. Remember that you can generate as many shortcodes as you like.'); ?>

                            </div>

                            <div class="apimo-step-description">

                                <div class="apimo-radiogroup"> <label class="apimo-type-radio">

                                        <div class="apimo-radio-container"> <input type="radio" class="apimo-portrait_radio" name="apimo_proprty_types" value="selected" id="apimo-type-1" checked> <label for="apimo-type-1"><?php _e('Choose by filters', 'apimo'); ?> <div class="apimo-radio-image"> <img src="<?php echo esc_url($apimo_url . 'assets/images/Featured_Home.png'); ?>"> </div> </label> </div>

                                    </label> <label class="apimo-type-radio">

                                        <div class="apimo-radio-container"> <input type="radio" class="apimo-portrait_radio" name="apimo_proprty_types" value="all" id="apimo-type-2"> <label for="apimo-type-2"><?php _e('All properties', 'apimo'); ?> <div class="apimo-radio-image"> <img src="<?php echo esc_url($apimo_url . 'assets/images/Home.png'); ?>"> </div> </label> </div>

                                    </label> </div>

                            </div>

                            <div class="apimo-step-buttons"> <button type="button" class="button button-primary apimo-step-button apimo-step-next" data-id="2"><?php _e('Next', 'apimo') ?></button> </div>

                        </div>

                        <div class="apimo-step apimo-filter-step step-2" data-id="2">

                            <div class="apimo-step-title-inner">

                                <h5><?php _e('Enable filters', 'apimo'); ?></h5>

                                <p> <?php _e('You can enable filters and pagination in the shortcode. Pay attention to the next step.', 'apimo'); ?> </p>

                            </div>

                            <div class="apimo-step-description">

                                <div class="apimo-row center">

                                    <div class="apimo-col-4">
                                        <label class="apimo-field checkbox-toggle">
                                            <label class="apimo-title">
                                                <strong><?php _e('Enable filter', 'apimo'); ?></strong>

                                                <span class="info-icon" title="Details of the option">
                                                    ℹ️
                                                    <!-- Information details displayed on hover -->
                                                    <span class="info-details">
                                                        <?php _e('Allows you to apply standard filters like category, subcategory, or price, and advanced filters like garden or terrace', 'apimo'); ?>
                                                    </span>
                                                </span>
                                            </label>

                                            <div class="checkbox-toggle-container switch"> <input type="checkbox" name="" id="shortcode_enable_filter" /> <span class="slider round"></span> </div>

                                        </label>

                                        <div class="apimo-row center" data-id="shortcode_enable_filter" style="display: none;">

                                            <div class="apimo-col-4">

                                                <div class="apimo-container">

                                                    <div class="apimo-block-label">

                                                        <h5><?php _e('Standard filter', 'apimo') ?></h5>


                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_normal[]" value="category_filter" id="apimo-archive-shortcode-category_filter" /> <span class="check"></span> <label for="apimo-archive-shortcode-category_filter"><?php _e('Category Filter', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_normal[]" value="subtype_filter" id="apimo-archive-shortcode-subtype_filter" /> <span class="check"></span> <label for="apimo-archive-shortcode-subtype_filter"><?php _e('Subtype Filter', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_normal[]" value="number_of_rooms" id="apimo-archive-shortcode-number_of_rooms"> <span class="check"></span> <label for="apimo-archive-shortcode-number_of_rooms"><?php _e('Number of rooms', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_normal[]" value="number_of_bedrooms" id="apimo-archive-shortcode-number_of_bedrooms"> <span class="check"></span> <label for="apimo-archive-shortcode-number_of_bedrooms"><?php _e('Number of bedrooms', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_normal[]" value="price_range" id="apimo-archive-shortcode-price_range"> <span class="check"></span> <label for="apimo-archive-shortcode-price_range"><?php _e('Price range', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_normal[]" value="property_areas" id="apimo-archive-shortcode-property_areas"> <span class="check"></span> <label for="apimo-archive-shortcode-property_areas"><?php _e('Areas range', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_normal[]" value="dates" id="apimo-archive-shortcode-dates"> <span class="check"></span> <label for="apimo-archive-shortcode-dates"><?php _e('Dates', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_normal[]" value="location" id="apimo-archive-shortcode-location"> <span class="check"></span> <label for="apimo-archive-shortcode-location"><?php _e('Location (Region, City, District)', 'apimo'); ?></label> </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="apimo-col-4">

                                                <div class="apimo-container">

                                                    <div class="apimo-block-label">

                                                        <h5><?php _e('Advance filter', 'apimo') ?></h5>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_advance[]" value="garden" id="apimo-archive-shortcode-garden"> <span class="check"></span> <label for="apimo-archive-shortcode-garden"><?php _e('Garden', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_advance[]" value="terrace" id="apimo-archive-shortcode-terrace"> <span class="check"></span> <label for="apimo-archive-shortcode-terrace"><?php _e('Terrace', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_advance[]" value="balcony" id="apimo-archive-shortcode-balcony"> <span class="check"></span> <label for="apimo-archive-shortcode-balcony"><?php _e('Balcony', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_advance[]" value="garage_box" id="apimo-archive-shortcode-garage_box"> <span class="check"></span> <label for="apimo-archive-shortcode-garage_box"><?php _e('Garage or Box', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_advance[]" value="parking_space" id="apimo-archive-shortcode-parking_space"> <span class="check"></span> <label for="apimo-archive-shortcode-parking_space"><?php _e('Parking space (internal or external)', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_advance[]" value="cellar" id="apimo-archive-shortcode-cellar"> <span class="check"></span> <label for="apimo-archive-shortcode-cellar"><?php _e('Cellar', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_advance[]" value="pool" id="apimo-archive-shortcode-pool"> <span class="check"></span> <label for="apimo-archive-shortcode-pool"><?php _e('Pool', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive_filter_advance[]" value="lift" id="apimo-archive-shortcode-lift"> <span class="check"></span> <label for="apimo-archive-shortcode-lift"><?php _e('Lift', 'apimo'); ?></label> </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="apimo-col-4">
                                        <label class="apimo-field checkbox-toggle">
                                            <label class="apimo-title">
                                                <strong><?php _e('Enable pagination', 'apimo'); ?>
                                                    <span class="info-icon" title="Details of the option">
                                                        ℹ️
                                                        <!-- Information details displayed on hover -->
                                                        <span class="info-details"><?php _e('Allows you to paginate through the properties.', 'apimo'); ?></span>
                                                    </span>
                                                </strong>
                                            </label>

                                            <div class="checkbox-toggle-container switch"> <input type="checkbox" name="" id="shortcode_enable_pagination" /> <span class="slider round"></span> </div>

                                        </label>



                                        <div class="apimo-row center" data-id="shortcode_enable_pagination" style="display: none;">

                                            <div class="apimo-col" style="margin-top: 10px">

                                                <div class="apimo-shortcode-input-label">

                                                    <p><?php _e('Number of post per page', 'apimo') ?></p>

                                                </div> <input class="" id="filter_page_size" value="12" />

                                            </div>

                                        </div>

                                    </div>

                                    <div style="margin-top: 20px;" class="apimo-col-4">

                                        <label class="apimo-field checkbox-toggle">
                                            <label class="apimo-title">
                                                <strong><?php _e('Limit post number', 'apimo'); ?>
                                                    <span class="info-icon" title="Details of the option">
                                                        ℹ️
                                                        <!-- Information details displayed on hover -->
                                                        <span class="info-details"><?php _e('Limits the number of properties displayed to a specified number.', 'apimo') ?></span>
                                                    </span>
                                                </strong>
                                            </label>

                                            <div class="checkbox-toggle-container switch"> <input type="checkbox" name="" id="shortcode_enable_post_limit" /> <span class="slider round"></span> </div>

                                        </label>
                                        <div class="apimo-row center" data-id="shortcode_enable_post_limit" style="display: none;">

                                            <div class="apimo-col" style="margin-top: 10px">

                                                <div class="apimo-shortcode-input-label">

                                                    <p><?php _e('Limit Posts', 'apimo') ?></p>

                                                </div> <input class="" id="filter_post_limit" value="12" />

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="apimo-step-buttons"> <button type="button" class="button apimo-step-button apimo-step-previous" data-id="1"><?php _e('Previous', 'apimo') ?></button> <button type="button" class="button button-primary apimo-step-button apimo-step-next" data-id="3"><?php _e('Next', 'apimo') ?></button> </div>

                        </div>

                        <div class="apimo-step step-3" data-id="3">

                            <div class="apimo-step-title-inner"> <?php /* <h5><?php _e('Properties', 'apimo'); ?></h5> */ ?> <p style="margin-top: 0"><?php _e('Select a filter method to show your properties in the shortcode', 'apimo'); ?> </div>

                            <div class="apimo-step-description">

                                <div class="property-selection" data-id="all"> <?php _e('All property selected', 'apimo'); ?> </div>

                                <div style="display: block;" class="property-selection" data-id="specific">

                                    <div class="apimo-section-description" id="select_specific_property">

                                        <div class="apimo-radiogroup without-image">

                                            <div class="apimo-type-radio">
                                                <span class="info-icon" title="Make Shortcode display the property with this filter">
                                                    ℹ️
                                                    <!-- Information details displayed on hover -->
                                                    <span class="info-details"><?php _e('Make Shortcode display the property with this filter', 'apimo') ?></span>
                                                </span>
                                                <input type="radio" class="apimo-product-selection-type" name="apimo_proprty_selection_types" value="filter" id="apimo-product-by-filter" checked> <label for="apimo-product-by-filter">

                                                    <div class="apimo-radio-image"></div>
                                                    <span><?php _e('By filter', 'apimo'); ?>

                                                    </span>


                                                </label>

                                            </div>

                                            <div class="apimo-type-radio">
                                                <input type="radio" class="apimo-product-selection-type" name="apimo_proprty_selection_types" value="tags" id="apimo-product-by-tags">
                                                <span class="info-icon" title="Make Shortcode display the property with this tags">
                                                    ℹ️
                                                    <!-- Information details displayed on hover -->
                                                    <span class="info-details"><?php _e('Make Shortcode display the property with this tags', 'apimo') ?></span>
                                                </span>
                                                <label for="apimo-product-by-tags">

                                                    <div class="apimo-radio-image"></div> <span><?php _e('By tags', 'apimo'); ?></span>

                                                </label>
                                            </div>

                                            <div class="apimo-type-radio">
                                                <input type="radio" class="apimo-product-selection-type" name="apimo_proprty_selection_types" value="property" id="apimo-product-by-manual-selection">
                                                <span class="info-icon" title="Manual select of properties">
                                                    ℹ️
                                                    <!-- Information details displayed on hover -->
                                                    <span class="info-details"><?php _e('Manual select of properties', 'apimo') ?></span>
                                                </span>
                                                <label for="apimo-product-by-manual-selection">

                                                    <div class="apimo-radio-image"></div> <span><?php _e('Manual', 'apimo'); ?></span>

                                                </label>
                                            </div>

                                        </div>

                                        <div class="apimo-proprty-selection-types" data-id="apimo-product-by-filter" style="display: block;">

                                            <div class="apimo-filter-product-shortcode">

                                                <div class="apimo-filter-product-shortcode__inner-scroll">

                                                    <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_category"><?php _e('Category', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_shortcode_filter" value="category" id="apimo_shortcode_filter_category"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_filter_category" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="apimo_category_wrap"> <label class="apimo-archive-filter"> <?php _e('Category', 'apimo') ?> </label> <select name="apimo_category" data-id="apimo_category" class="apimo_input apimo_filter_input apimo_input_select">

                                                                    <option value=""><?php _e('Select Category', 'apimo') ?></option>

                                                                    <?php $terms_country = $terms = get_terms(array('taxonomy' => 'apimo_category', 'hide_empty' => false));

                                                                    foreach ($terms_country as $term_country) :

                                                                    ?> <option value="<?php echo esc_attr($term_country->term_id); ?>">

                                                                            <?php echo esc_attr($term_country->name); ?></option>

                                                                    <?php endforeach; ?>

                                                                </select> </div>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_category"><?php _e('Subtype', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_shortcode_filter" value="subtype" id="apimo_shortcode_filter_subtype"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_filter_subtype" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="apimo_subtype_wrap"> <label class="apimo-archive-filter"> <?php _e('subtype', 'apimo') ?> </label> <select name="apimo_subtype" data-id="apimo_subtype" class="apimo_input apimo_filter_input apimo_input_select">

                                                                    <option value=""><?php _e('Select subtype', 'apimo') ?></option>

                                                                    <?php $terms_country = $terms = get_terms(array('taxonomy' => 'apimo_subtype', 'hide_empty' => false));
                                                                    foreach ($terms_country as $term_country) :

                                                                    ?> <option value="<?php echo esc_attr($term_country->term_id); ?>">

                                                                            <?php echo esc_attr($term_country->name); ?></option>

                                                                    <?php endforeach; ?>

                                                                </select> </div>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_area"><?php _e('Location', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_shortcode_filter" value="area" id="apimo_shortcode_filter_area"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_filter_area" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="apimo_location_wrap"> <label class="apimo-archive-filter"> <?php _e('Country', 'apimo') ?> </label> <select name="apimo_country" data-id="apimo_country" class="apimo_input apimo_filter_input apimo_input_select">

                                                                    <option value=""><?php _e('Select Country', 'apimo') ?></option> <?php $terms_country = $terms = get_terms(array('taxonomy' => 'country', 'hide_empty' => false));
                                                                                                                                        foreach ($terms_country as $term_country) : ?> <option value="<?php echo esc_attr($term_country->term_id); ?>"><?php echo esc_attr($term_country->name); ?></option> <?php endforeach; ?>

                                                                </select> </div>

                                                            <div class="apimo_location_wrap"> <label class="apimo-archive-filter"> <?php _e('Region', 'apimo') ?> </label> <select name="apimo_region" data-id="apimo_region" class="apimo_input apimo_filter_input apimo_input_select">

                                                                    <option value=""><?php _e('Select Region', 'apimo') ?></option> <?php $terms_region = $terms = get_terms(array('taxonomy' => 'region', 'hide_empty' => false));
                                                                                                                                    foreach ($terms_region as $term_region) : ?> <option value="<?php echo esc_attr($term_region->term_id); ?>"><?php echo esc_attr($term_region->name); ?></option> <?php endforeach; ?>

                                                                </select> </div>

                                                            <div class="apimo_location_wrap"> <label class="apimo-archive-filter"> <?php _e('City', 'apimo') ?> </label> <select name="apimo_city" data-id="apimo_city" class="apimo_input apimo_filter_input apimo_input_select">

                                                                    <option value=""><?php _e('Select City', 'apimo') ?></option> <?php $terms_region = $terms = get_terms(array('taxonomy' => 'city', 'hide_empty' => false, 'parent' => 0));
                                                                                                                                    foreach ($terms_region as $term_region) : ?> <option value="<?php echo esc_attr($term_region->term_id); ?>"><?php echo esc_attr($term_region->name); ?></option> <?php endforeach; ?>

                                                                </select> </div>

                                                            <div class="apimo_location_wrap"> <label class="apimo-archive-filter"> <?php _e('District', 'apimo') ?> </label> <select name="apimo_district" data-id="apimo_district" class="apimo_input apimo_filter_input apimo_input_select">

                                                                    <option value=""><?php _e('Select District', 'apimo') ?></option> <?php $terms_region = get_terms(array('taxonomy' => 'district', 'hide_empty' => false));
                                                                                                                                        foreach ($terms_region as $term_region) : ?> <option value="<?php echo esc_attr($term_region->term_id); ?>"><?php echo esc_attr($term_region->name); ?></option> <?php endforeach; ?>

                                                                </select> </div>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_price"><?php _e('Price', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_shortcode_filter" value="price" id="apimo_shortcode_filter_price"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_filter_price" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="fiter-range">

                                                                <div class="apimo-row">

                                                                    <div class="apimo-col-6">

                                                                        <div class="range-from"> <input type="number" min="0" name="price_range_min" data-id="price_range_min" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('From', 'apimo') ?>"> </div>

                                                                    </div>

                                                                    <div class="apimo-col-6">

                                                                        <div class="range-to"> <input type="number" min="0" name="price_range_max" data-id="price_range_max" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('To', 'apimo') ?>"> </div>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_area_size"><?php _e('Area', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_shortcode_filter" value="area_size" id="apimo_shortcode_filter_area_size"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_filter_area_size" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="fiter-range">

                                                                <div class="range-from"> <input type="number" min="0" name="property_areas_min" data-id="property_areas_min" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('From', 'apimo') ?>"> </div>

                                                                <div class="range-to"> <input type="number" min="0" name="property_areas_max" data-id="property_areas_max" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('To', 'apimo') ?>"> </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_rooms"><?php _e('Rooms', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_shortcode_filter" value="rooms" id="apimo_shortcode_filter_rooms"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_filter_rooms" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="filter-item-qty apimo-archive-filter apimo_number_of_rooms" data-id="number_of_rooms">

                                                                <div class="label">Locali</div>

                                                                <div class="qty-buttons"> <input type="number" min="0" name="number_of_rooms" data-id="number_of_rooms" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('0', 'apimo') ?>"> </div>

                                                            </div>

                                                            <div class="filter-item-qty apimo-archive-filter apimo_number_of_bedrooms" data-id="number_of_bedrooms">

                                                                <div class="label">Bagni</div>

                                                                <div class="qty-buttons"> <input type="number" min="0" name="number_of_bedrooms" data-id="number_of_bedrooms" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('0', 'apimo') ?>"> </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_dates"><?php _e('Dates', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_shortcode_filter" value="dates" id="apimo_shortcode_filter_dates"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_filter_dates" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="apimo_date_filter_radios">

                                                                <div class="apimo_date_filter_radio">

                                                                    <div class="apimo-date-block"> <input checked="checked" type="radio" id="apimo_date_created_at" value="created_at" name="apimo_date_filter_type" data-id="apimo_date_filter_type" class="apimo_filter_input apimo_filter_input_radio" /> <label for="apimo_date_created_at"><?php _e('created at', 'apimo') ?></label> </div>

                                                                </div>

                                                                <div class="apimo_date_filter_radio">

                                                                    <div class="apimo-date-block"> <input type="radio" id="apimo_date_published_at" value="published_at" name="apimo_date_filter_type" data-id="apimo_date_published_at" class="apimo_filter_input apimo_filter_input_radio" /> <label for="apimo_date_published_at"><?php _e('published at', 'apimo') ?></label> </div>

                                                                </div>

                                                                <div class="apimo_date_filter_radio">

                                                                    <div class="apimo-date-block"> <input type="radio" id="apimo_date_updated_at" value="updated_at" name="apimo_date_filter_type" data-id="apimo_date_updated_at" class="apimo_filter_input apimo_filter_input_radio" /> <label for="apimo_date_updated_at"><?php _e('updated at', 'apimo') ?></label> </div>

                                                                </div>

                                                            </div> <input type="hidden" name="apimo_dates_start" data-id="apimo_dates_start" class="apimo_input_text"> <input type="hidden" name="apimo_dates_end" data-id="apimo_dates_end" class="apimo_input_text"> <span type="text" name="apimo_dates" data-id="apimo_dates" class="apimo_dates_filter_input apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('Dates', 'apimo') ?>"> Select Date </span>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_advacne_search"><?php _e('Advance Search', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_shortcode_filter" value="advacne_search" id="apimo_shortcode_filter_advacne_search"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_filter_advacne_search" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="apimo-aditional-filter"> <?php foreach ($archive['filter']['advance'] as $advance_filter) :
                                                                                                        if ($advance_filter == 'garden') :
                                                                                                            $term = $terms = get_terms(array('taxonomy' => 'apimo_areas', 'meta_key' => 'apimo_term_id', 'meta_value' => 49, 'hide_empty' => false)); ?> <div class="apimo-archive-filter apimo_advance_garden" data-id="advance_garden"> <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="advance_garden" id="apimo_garden" class="apimo_input apimo_filter_input apimo_input_checkbox"> <label class="apimo-archive-filter" for="apimo_garden">

                                                                                <div class="checkbox-filter-image"> <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                                                        <path d="M31.07,29.66a7.43,7.43,0,0,0,2.56.46,7.5,7.5,0,0,0,6-12A7.5,7.5,0,0,0,34.19,5.46a7.78,7.78,0,0,0-1.73.2,7.49,7.49,0,0,0-14.55.09,7.43,7.43,0,0,0-2.06-.29,7.49,7.49,0,0,0-5.1,13A7.48,7.48,0,0,0,17,30.12a7.65,7.65,0,0,0,2.24-.34A7.47,7.47,0,0,0,24,32.56V49a1,1,0,1,0,2,0V32.58a7.57,7.57,0,0,0,5.06-2.92Zm-10.66-1.6a1,1,0,0,0-.83-.46.92.92,0,0,0-.4.08,5.41,5.41,0,0,1-2.21.46A5.51,5.51,0,0,1,12.86,19a1,1,0,0,0,.24-.77,1,1,0,0,0-.41-.7A5.52,5.52,0,0,1,18.27,8a1,1,0,0,0,1.43-.83A5.51,5.51,0,0,1,30.7,7a1,1,0,0,0,.47.77,1,1,0,0,0,.89.06A5.54,5.54,0,0,1,39.72,13a5.51,5.51,0,0,1-2.08,4.31,1,1,0,0,0-.37.71,1,1,0,0,0,.29.76,5.52,5.52,0,0,1-6.41,8.81,1,1,0,0,0-1.3.38A5.55,5.55,0,0,1,26,30.58V20.45a1,1,0,1,0-2,0v10.1a5.52,5.52,0,0,1-3.62-2.49Z" />

                                                                                        <path d="M21.85,46H18.11v-7h3.6a1,1,0,1,0,0-2h-3.6V35.44a1,1,0,1,0-2,0V37H10.2V35.44a1,1,0,1,0-2,0V37H2.3V35.44a1,1,0,1,0-2,0v2a.89.89,0,0,0,0,1.1v7.89a.89.89,0,0,0,0,1.1V49a1,1,0,1,0,2,0V47.93H8.23V49a1,1,0,0,0,2,0V47.93h5.92V49a1,1,0,1,0,2,0V47.93h3.74a1,1,0,1,0,0-2ZM2.3,46v-7H8.23v7Zm7.9,0v-7h5.93v7Z" />

                                                                                        <path d="M49.72,46.25V38.64A1,1,0,0,0,50,38a1,1,0,0,0-.28-.68V35.44a1,1,0,1,0-2,0V37H41.82V35.44a1,1,0,0,0-2,0V37H33.91V35.44a1,1,0,1,0-2,0V37H28.43a1,1,0,0,0,0,2h3.51v7H28.29a1,1,0,1,0,0,2h3.65V49a1,1,0,1,0,2,0V47.93h5.93V49a1,1,0,1,0,2,0V47.93h5.92V49a1,1,0,1,0,2,0V47.62a1,1,0,0,0,.28-.68,1,1,0,0,0-.28-.69ZM33.91,46v-7h5.93v7Zm7.91,0v-7h5.92v7Z" />

                                                                                    </svg> </div> <span class="text"><?php _e('Garden', 'apimo') ?></span>

                                                                            </label> </div> <?php endif;

                                                                                                        if ($advance_filter == 'terrace') :
                                                                                                            $term = $terms = get_terms(array('taxonomy' => 'apimo_areas', 'meta_key' => 'apimo_term_id', 'meta_value' => 18, 'hide_empty' => false)); ?> <div class="apimo-archive-filter apimo_advance_garden" data-id="apimo_terrace"> <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_terrace" id="apimo_terrace" class="apimo_input apimo_filter_input apimo_input_checkbox"> <label class="apimo-archive-filter" for="apimo_terrace">

                                                                                <div class="checkbox-filter-image"> <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                                                        <path d="M24.88,0a1.18,1.18,0,0,0-1,1.15v0a34.13,34.13,0,0,0-13.1,3.31C5.77,7,1.24,11.09,0,17.4a1.18,1.18,0,0,0,1.12,1.36H23.86v9.66H14.67a1.17,1.17,0,0,0-1,1.13v4a1.19,1.19,0,0,0,1.13,1.14h9.09V47.73H19.78A1.14,1.14,0,0,0,19.89,50H30.11a1.14,1.14,0,1,0,0-2.27h-4V34.67h9.09a1.19,1.19,0,0,0,1.13-1.14v-4a1.18,1.18,0,0,0-1.13-1.13H26.14V18.76H48.86A1.18,1.18,0,0,0,50,17.4C48.76,11.09,44.23,7,39.24,4.51a34.34,34.34,0,0,0-13.1-3.32v0A1.18,1.18,0,0,0,24.88,0ZM25,3.43A32.24,32.24,0,0,1,38.24,6.55c4.2,2.07,7.75,5.24,9.15,9.94H2.61c1.4-4.7,4.95-7.87,9.15-9.94A32.24,32.24,0,0,1,25,3.43ZM1.05,29a1.19,1.19,0,0,0-1,1.54c1.23,3.28,2.3,6.15,3.43,9.27H3.3A1.17,1.17,0,0,0,2.22,41a1.19,1.19,0,0,0,1.19,1.08H4.1l-1.77,5.3a1.19,1.19,0,0,0,.72,1.45,1.18,1.18,0,0,0,1.44-.72l2-6h3.73v6.24a1.14,1.14,0,1,0,2.27,0V42.05h.57a1.14,1.14,0,1,0,0-2.27H5.91c-.33-1-.72-2-1-2.84h6.48a1.14,1.14,0,1,0,0-2.28H4.05L2.2,29.71A1.15,1.15,0,0,0,1.05,29Zm47.76,0a1.15,1.15,0,0,0-1,.74c-.46,1.21-1.18,3.15-1.85,5H38.53a1.18,1.18,0,0,0-1.09,1.18,1.2,1.2,0,0,0,1.19,1.09h6.48c-.34,1-.71,2-1,2.84H36.93a1.14,1.14,0,1,0,0,2.27h.57V48.3a1.14,1.14,0,1,0,2.27,0V42.05H43.5l2,6a1.14,1.14,0,1,0,2.17-.73l-1.78-5.3h.7a1.14,1.14,0,1,0,0-2.27H46.5c1.11-3.07,2.24-6.09,3.43-9.27A1.2,1.2,0,0,0,48.81,29Zm-32.9,1.72H34.09v1.7H15.91Z" />

                                                                                    </svg> </div> <span class="text"><?php _e('Terrace', 'apimo') ?></span>

                                                                            </label> </div> <?php endif;

                                                                                                        if ($advance_filter == 'balcony') :
                                                                                                            $term = $terms = get_terms(array('taxonomy' => 'apimo_areas', 'meta_key' => 'apimo_term_id', 'meta_value' => 43, 'hide_empty' => false)); ?> <div class="apimo-archive-filter apimo_advance_balcony" data-id="apimo_balcony"> <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_balcony" id="apimo_balcony" class="apimo_input apimo_filter_input apimo_input_checkbox"> <label class="apimo-archive-filter" for="apimo_balcony">

                                                                                <div class="checkbox-filter-image"> <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                                                        <path d="M7.5,0A1.76,1.76,0,0,0,5.85,1.84,1.7,1.7,0,0,0,6.43,3a1.75,1.75,0,0,0,1.26.45h.58V27.91H3.62a.61.61,0,0,0-.19,0,1.73,1.73,0,0,0-1.2.57,1.78,1.78,0,0,0-.45,1.26A1.72,1.72,0,0,0,2.36,31a1.7,1.7,0,0,0,1.26.44H4.2V46.51H3.43a1.73,1.73,0,0,0-1.2.57,1.78,1.78,0,0,0-.45,1.26,1.71,1.71,0,0,0,.58,1.21A1.75,1.75,0,0,0,3.62,50h43a1.8,1.8,0,0,0,1.25-.5,1.75,1.75,0,0,0,0-2.49,1.71,1.71,0,0,0-1.25-.5H45.47V31.39h1.16a1.74,1.74,0,1,0,0-3.48H42V3.49h.59A1.71,1.71,0,0,0,43.81,3a1.72,1.72,0,0,0,.52-1.24A1.73,1.73,0,0,0,43.81.5,1.79,1.79,0,0,0,42.57,0H7.5Zm4.25,3.49H23.38V14H11.75Zm15.12,0H38.5V14H26.87ZM15.79,4.62a1.71,1.71,0,0,0-1.42.8L13.21,7.16a1.74,1.74,0,0,0,1.34,2.72,1.74,1.74,0,0,0,1.56-.78l1.17-1.74A1.75,1.75,0,0,0,17,5a1.73,1.73,0,0,0-1.19-.41Zm4.07,2.32a1.76,1.76,0,0,0-1.42.8L17.28,9.49a1.74,1.74,0,0,0,1.34,2.71,1.73,1.73,0,0,0,1.56-.77l1.17-1.74a1.79,1.79,0,0,0,.3-1.23,1.76,1.76,0,0,0-1.79-1.52Zm-8.11,10.5H23.38V27.91H11.75Zm15.12,0H38.5V27.91H26.87Zm4,1.13a1.76,1.76,0,0,0-1.42.8l-1.16,1.74a1.77,1.77,0,0,0-.11,1.75,1.74,1.74,0,0,0,1.45,1,1.76,1.76,0,0,0,1.57-.77l1.16-1.75a1.7,1.7,0,0,0,.3-1.22,1.73,1.73,0,0,0-.6-1.11,1.71,1.71,0,0,0-1.19-.41ZM35,20.89a1.79,1.79,0,0,0-1.42.8l-1.16,1.75a1.75,1.75,0,0,0,2.91,1.94l1.16-1.74a1.73,1.73,0,0,0,.3-1.23,1.71,1.71,0,0,0-.6-1.1A1.77,1.77,0,0,0,35,20.89ZM7.68,31.39h4.07V46.51H7.68Zm7.56,0h4.07V46.51H15.24Zm7.56,0h4.07V46.51H22.8Zm7.56,0h4.07V46.51H30.36Zm7.55,0H42V46.51H37.91Z" />

                                                                                    </svg> </div> <span class="text"><?php _e('Balcony', 'apimo') ?></span>

                                                                            </label> </div> <?php endif;

                                                                                                        if ($advance_filter == 'garage_box') :
                                                                                                            $term = $terms = get_terms(array('taxonomy' => 'apimo_areas', 'meta_key' => 'apimo_term_id', 'meta_value' => 4, 'hide_empty' => false)); ?> <div class="apimo-archive-filter apimo_advance_garage_box" data-id="apimo_garage_box"> <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_garage_box" id="apimo_garage_box" class="apimo_input apimo_filter_input apimo_input_checkbox"> <label class="apimo-archive-filter" for="apimo_garage_box">

                                                                                <div class="checkbox-filter-image"> <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                                                        <path d="M47.88,20.31H46.26V46.12a2.13,2.13,0,0,1-.61,1.49,2.18,2.18,0,0,1-1.49.62h-.32a2.16,2.16,0,0,1-1.48-.62,2.1,2.1,0,0,1-.62-1.49V20.31H8.27V46.12a2.13,2.13,0,0,1-.61,1.49,2.16,2.16,0,0,1-1.49.62H5.85a2.18,2.18,0,0,1-1.49-.62,2.13,2.13,0,0,1-.61-1.49V20.31H2.13A2.14,2.14,0,0,1,.5,19.55,2.12,2.12,0,0,1,0,17.82a2.08,2.08,0,0,1,1-1.47L25,2.38l24,14a2.08,2.08,0,0,1,1,1.47,2.12,2.12,0,0,1-.46,1.73,2.14,2.14,0,0,1-1.63.76ZM39.66,30.65v1.08a1.57,1.57,0,0,1-.46,1.07,1.62,1.62,0,0,1-1.07.47h-.76a3.46,3.46,0,0,1,.22.31h0a6.39,6.39,0,0,1,1.06,3.7v7.33a1.54,1.54,0,0,1-1.53,1.53h-2a1.54,1.54,0,0,1-1.53-1.53V43.45H16.39V44.6a1.52,1.52,0,0,1-1.53,1.53h-2a1.52,1.52,0,0,1-1.54-1.53V37.29a6.46,6.46,0,0,1,1.06-3.7,3.55,3.55,0,0,1,.23-.31h-.75a1.62,1.62,0,0,1-1.07-.47,1.57,1.57,0,0,1-.46-1.07V30.66h0a1.55,1.55,0,0,1,.45-1.05,1.5,1.5,0,0,1,1-.45h.57a2.65,2.65,0,0,1,1.7.73,30.28,30.28,0,0,1,2.21-4.68,5.14,5.14,0,0,1,3.54-2A29.3,29.3,0,0,1,25,22.82a29.47,29.47,0,0,1,5.14.33,5.1,5.1,0,0,1,3.53,2,32,32,0,0,1,2.22,4.7,2.59,2.59,0,0,1,1.71-.76h.57a1.54,1.54,0,0,1,1.49,1.52Zm-19.2,6.23a1.2,1.2,0,0,0-.89-1.15L16.77,35a1.22,1.22,0,0,0-1,.21,1.19,1.19,0,0,0-.46.94v.74a1.19,1.19,0,0,0,1.18,1.18h2.8a1.2,1.2,0,0,0,1.2-1.18Zm14.28-.74h0a1.18,1.18,0,0,0-.46-.94,1.21,1.21,0,0,0-1-.21l-2.8.74h0a1.19,1.19,0,0,0,.3,2.33h2.8a1.19,1.19,0,0,0,1.19-1.19Z" />

                                                                                    </svg> </div> <span class="text"><?php _e('Garage Or Box', 'apimo') ?></span>

                                                                            </label> </div> <?php endif;

                                                                                                        if ($advance_filter == 'parking_space') :
                                                                                                            $term = $terms = get_terms(array('taxonomy' => 'apimo_areas', 'meta_key' => 'apimo_term_id', 'meta_value' => 5, 'hide_empty' => false)); ?> <div class="apimo-archive-filter apimo_advance_parking" data-id="apimo_parking"> <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_parking" id="apimo_parking" class="apimo_input apimo_filter_input apimo_input_checkbox"> <label class="apimo-archive-filter" for="apimo_parking">

                                                                                <div class="checkbox-filter-image"> <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                                                        <path d="M40.43,0H9.52A9.51,9.51,0,0,0,0,9.47v31A9.52,9.52,0,0,0,9.52,50h31A9.52,9.52,0,0,0,50,40.47v-31A9.58,9.58,0,0,0,40.43,0ZM45,40.47A4.52,4.52,0,0,1,40.43,45H9.52A4.53,4.53,0,0,1,5,40.47v-31A4.48,4.48,0,0,1,9.52,5h31A4.52,4.52,0,0,1,45,9.47v31Z" />

                                                                                        <path d="M25.66,10.2H19a2.55,2.55,0,0,0-2.55,2.55V38.38a1,1,0,0,0,1,1h3a1,1,0,0,0,1-1V28.61h4.41a9.17,9.17,0,0,0,9.18-9.81,9.35,9.35,0,0,0-9.45-8.6ZM26,23.57h-4.4V15.24H26a4.17,4.17,0,0,1,0,8.33Z" />

                                                                                    </svg> </div> <span class="text"><?php _e('Parking space', 'apimo') ?></span>

                                                                            </label> </div> <?php endif;

                                                                                                        if ($advance_filter == 'cellar') :
                                                                                                            $term = $terms = get_terms(array('taxonomy' => 'apimo_areas', 'meta_key' => 'apimo_term_id', 'meta_value' => 6, 'hide_empty' => false)); ?> <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_cellar"> <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_cellar" id="apimo_cellar" class="apimo_input apimo_filter_input apimo_input_checkbox"> <label class="apimo-archive-filter" for="apimo_cellar">

                                                                                <div class="checkbox-filter-image"> <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                                                        <path d="M24.47,0A17.65,17.65,0,0,1,42.12,17.65V48.53A1.47,1.47,0,0,1,40.65,50H8.29a1.47,1.47,0,0,1-1.47-1.47V17.65A17.65,17.65,0,0,1,24.47,0ZM9.76,44.12v2.94H39.17V42.65H11.23a1.47,1.47,0,0,0-1.47,1.47Zm6.62-7.35v2.94h22.8V35.29H17.85a1.47,1.47,0,0,0-1.47,1.48ZM23,29.41v2.94H39.18V27.94H24.47A1.47,1.47,0,0,0,23,29.41Zm6.62-7.35V25h9.55V20.59H31.09a1.47,1.47,0,0,0-1.47,1.47Z" />

                                                                                    </svg> </div> <span class="text"><?php _e('Cellar', 'apimo') ?></span>

                                                                            </label> </div> <?php endif;

                                                                                                        if ($advance_filter == 'pool') :
                                                                                                            $term = $terms = get_terms(array('taxonomy' => 'apimo_service', 'meta_key' => 'apimo_term_id', 'meta_value' => 11, 'hide_empty' => false)); ?> <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_pool"> <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[service][]" data-id="apimo_pool" id="apimo_pool" class="apimo_input apimo_filter_input apimo_input_checkbox"> <label class="apimo-archive-filter" for="apimo_pool">

                                                                                <div class="checkbox-filter-image"> <svg id="Livello_1" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">

                                                                                        <path d="M4.9,33.52a4.82,4.82,0,0,0,3.58-1.63c.63-.6.91-.85,1.61-.85s1,.25,1.6.85a4.74,4.74,0,0,0,7.15,0c.63-.6.91-.85,1.61-.85s1,.25,1.61.85a4.74,4.74,0,0,0,7.15,0c.63-.6.91-.85,1.61-.85s1,.25,1.6.85a4.75,4.75,0,0,0,7.16,0c.62-.6.91-.85,1.6-.85s1,.25,1.61.85a4.74,4.74,0,0,0,7.15,0l.06-.06V28.45a5.65,5.65,0,0,0-2,1.38c-.62.59-.91.84-1.6.84s-1-.25-1.61-.84a4.74,4.74,0,0,0-7.15,0c-.63.59-.91.84-1.61.84s-1-.25-1.61-.84a5,5,0,0,0-2.82-1.58V14.54H50v-2H38.72a7.09,7.09,0,0,0-1.54-4.69,4.53,4.53,0,0,0-3.43-1.43A4.61,4.61,0,0,0,30.3,7.88a7.3,7.3,0,0,0-1.67,4.7H24.41a7.07,7.07,0,0,0-1.53-4.69,4.55,4.55,0,0,0-3.44-1.43A4.61,4.61,0,0,0,16,7.88a7.36,7.36,0,0,0-1.67,4.7H0v2H14.33V30.4a5.54,5.54,0,0,1-.67-.57,4.74,4.74,0,0,0-7.15,0c-.63.59-.91.84-1.61.84s-1-.25-1.6-.84A4.83,4.83,0,0,0,0,28.21v2.85c.51.06.79.32,1.33.83A4.82,4.82,0,0,0,4.9,33.52ZM32.43,9.89a1.67,1.67,0,0,1,1.32-.5A1.59,1.59,0,0,1,35,9.87a4.42,4.42,0,0,1,.77,2.71H31.57a4.53,4.53,0,0,1,.86-2.69Zm-14.31,0a1.67,1.67,0,0,1,1.32-.5,1.59,1.59,0,0,1,1.27.48,4.42,4.42,0,0,1,.77,2.71H17.26a4.53,4.53,0,0,1,.86-2.69Zm-.86,4.64H28.64V16H17.26Zm0,4.38H28.64v4.45H17.26Zm0,7.38H28.64v2.44a6.63,6.63,0,0,0-1.4,1.1c-.63.59-.91.84-1.61.84s-1-.25-1.6-.84a4.81,4.81,0,0,0-3.58-1.63,4.48,4.48,0,0,0-3.19,1.27Zm-16,12.19A2.31,2.31,0,0,0,0,37.66V34.8a4.81,4.81,0,0,1,3.25,1.62c.63.6.92.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.6.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.6-.84A5.55,5.55,0,0,1,50,35v3.36l-.1.09a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.61-.84s-1,.24-1.6.84a4.75,4.75,0,0,1-7.16,0c-.62-.6-.91-.84-1.6-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.61-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.6-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0ZM47.94,43A5.54,5.54,0,0,1,50,41.62V45l-.1.09a4.74,4.74,0,0,1-7.15,0c-.63-.59-.91-.84-1.61-.84s-1,.24-1.6.84a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.61-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.63-.6-.91-.84-1.61-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.62-.6-.91-.84-1.6-.84s-1,.24-1.61.84a4.74,4.74,0,0,1-7.15,0c-.53-.49-.81-.75-1.29-.82V41.39A4.85,4.85,0,0,1,3.25,43c.63.6.92.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84A4.74,4.74,0,0,1,24,43c.63.6.91.84,1.6.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84a4.74,4.74,0,0,1,7.15,0c.63.6.91.84,1.61.84s1-.24,1.61-.84Z" />

                                                                                    </svg> </div> <span class="text"><?php _e('Pool', 'apimo') ?></span>

                                                                            </label> </div> <?php endif;

                                                                                                        if ($advance_filter == 'lift') :
                                                                                                            $term = $terms = get_terms(array('taxonomy' => 'apimo_service', 'meta_key' => 'apimo_term_id', 'meta_value' => 6, 'hide_empty' => false)); ?> <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_lift"> <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[service][]" data-id="apimo_lift" id="apimo_lift" class="apimo_input apimo_filter_input apimo_input_checkbox"> <label class="apimo-archive-filter" for="apimo_lift">

                                                                                <div class="checkbox-filter-image"> <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">

                                                                                        <path d="m46.08 46.44h-42.08-.37l.47.06a2.38 2.38 0 0 1 -.52-.15l.42.15a2.19 2.19 0 0 1 -.3-.16c-.29-.17.16.1.14.12l-.14-.13-.11-.12c-.14-.13.26.38.12.15a3.72 3.72 0 0 1 -.22-.36l.18.43a2.31 2.31 0 0 1 -.15-.53l.06.48a10.59 10.59 0 0 1 0-1.38v-41a2.3 2.3 0 0 1 0-.37l-.06.47a2.63 2.63 0 0 1 .15-.53l-.18.43a2.91 2.91 0 0 1 .17-.3c.16-.29-.1.16-.12.14s.12-.13.13-.14a1.14 1.14 0 0 0 .11-.11c.14-.14-.38.26-.15.11s.22-.13.34-.18l-.42.18a3.13 3.13 0 0 1 .52-.16l-.47.07a10.59 10.59 0 0 1 1.4-.06h41a2.42 2.42 0 0 1 .38 0l-.48-.07a2.49 2.49 0 0 1 .53.16l-.43-.16a2.91 2.91 0 0 1 .3.17c.29.16-.16-.1-.14-.12s.13.12.14.13l.11.11c.14.14-.25-.38-.11-.15a3.65 3.65 0 0 1 .18.34l-.18-.43a2.67 2.67 0 0 1 .16.53c0-.16 0-.31-.07-.47a10.56 10.56 0 0 1 0 1.38v41.03a2.43 2.43 0 0 1 0 .38c0-.16.05-.32.07-.48a1.91 1.91 0 0 1 -.16.53l.18-.43a1.82 1.82 0 0 1 -.16.31c-.17.28.1-.16.12-.15l-.14.15-.11.1c-.14.15.38-.25.15-.11a2.21 2.21 0 0 1 -.34.18l.43-.17a3.21 3.21 0 0 1 -.53.15l.48-.06h-.31a1.78 1.78 0 1 0 0 3.55 4 4 0 0 0 3.93-3.87v-42.08a3.94 3.94 0 0 0 -1.24-2.93 4.07 4.07 0 0 0 -2.76-1.07h-42.23a4.05 4.05 0 0 0 -3.07 1.71 3.79 3.79 0 0 0 -.7 2.21v42.08a3.94 3.94 0 0 0 1.35 3 4.21 4.21 0 0 0 2.65 1h42a1.78 1.78 0 0 0 0-3.56z" />

                                                                                        <path d="m39.72 27.81-5.51 5.5-.79.78h2.52l-6.31-6.28a1.78 1.78 0 1 0 -2.52 2.51l6.31 6.29a1.81 1.81 0 0 0 2.52 0l5.51-5.5.79-.79a1.78 1.78 0 1 0 -2.52-2.51z" />

                                                                                        <path d="m42.24 19.68-5.51-5.5-.8-.79a1.81 1.81 0 0 0 -2.52 0l-6.3 6.29a1.79 1.79 0 0 0 0 2.51 1.82 1.82 0 0 0 2.52 0l6.3-6.29h-2.52l5.52 5.5.79.79a1.81 1.81 0 0 0 2.52 0 1.79 1.79 0 0 0 0-2.51z" />

                                                                                        <path d="m16.6 11.72a2.74 2.74 0 0 1 0 .5c0-.16 0-.32.07-.48a4.28 4.28 0 0 1 -.23.85l.17-.43a2.89 2.89 0 0 1 -.29.55l-.09.13c-.13.21.13-.18.14-.17s-.22.24-.24.26l-.23.21c-.13.14.34-.24.18-.14l-.13.09a3.37 3.37 0 0 1 -.59.32l.43-.18a3.56 3.56 0 0 1 -.85.23l.47-.07a3.22 3.22 0 0 1 -1 0l.47.07a4.28 4.28 0 0 1 -.85-.23l.43.18a4.77 4.77 0 0 1 -.55-.29l-.15-.12c-.21-.14.18.13.17.13s-.24-.22-.26-.23l-.21-.23c-.14-.14.24.33.14.17l-.09-.13a3.28 3.28 0 0 1 -.32-.58l.18.42a3.49 3.49 0 0 1 -.23-.84l.06.47a4 4 0 0 1 0-1l-.06.47a4.28 4.28 0 0 1 .23-.85l-.18.43a4.77 4.77 0 0 1 .29-.55l.09-.13c.14-.21-.13.18-.13.17s.22-.24.23-.26l.24-.21c.13-.14-.34.24-.18.14l.13-.09a3 3 0 0 1 .59-.32l-.43.18a3.44 3.44 0 0 1 .85-.23l-.48.07a3.29 3.29 0 0 1 1 0h-.49a4.11 4.11 0 0 1 .85.23l-.42-.23a4.77 4.77 0 0 1 .55.29l.13.09c.21.14-.18-.13-.17-.13s.24.22.26.23l.21.24c.13.13-.24-.34-.14-.18l.09.13a3.23 3.23 0 0 1 .31.58l-.17-.42a3.44 3.44 0 0 1 .23.85c0-.16 0-.32-.07-.48v.49a1.78 1.78 0 0 0 3.56 0 5.19 5.19 0 0 0 -.91-3 5.55 5.55 0 0 0 -2.66-2 5.25 5.25 0 0 0 -5.67 1.51 5.53 5.53 0 0 0 -1.3 3.14 5.19 5.19 0 0 0 3 5 5.58 5.58 0 0 0 3.44.42 5.31 5.31 0 0 0 4.15-5.14 1.78 1.78 0 0 0 -3.56 0z" />

                                                                                        <path d="m18.35 24.24v7.87l1.78-1.78h-10.47l1.78 1.78v-7.11a12.1 12.1 0 0 1 0-1.35l-.06.47a4.39 4.39 0 0 1 .3-1.13l-.17.42a4.32 4.32 0 0 1 .36-.67c0-.06.08-.1.11-.16s-.32.38-.12.15l.26-.28.28-.25c.18-.16-.18.15-.19.13l.16-.11a4.43 4.43 0 0 1 .71-.39l-.43.18a4.5 4.5 0 0 1 1.14-.32l-.48.07a12.86 12.86 0 0 1 1.52 0 13 13 0 0 1 1.53 0l-.48-.07a4.61 4.61 0 0 1 1.14.32l-.43-.18a4.92 4.92 0 0 1 .68.37c.06 0 .1.08.16.11s-.38-.31-.15-.11l.28.25c.09.09.17.19.25.28s-.15-.18-.13-.18l.11.16a4.8 4.8 0 0 1 .39.7l-.18-.41a4.42 4.42 0 0 1 .32 1.13c0-.16 0-.31-.07-.47a2.76 2.76 0 0 1 .06.57 1.78 1.78 0 0 0 3.56 0 6.15 6.15 0 0 0 -1.59-4.09 6 6 0 0 0 -3.68-1.9 18.71 18.71 0 0 0 -2.37-.07 6.76 6.76 0 0 0 -3.3.76 6.19 6.19 0 0 0 -2.7 3.27 6.29 6.29 0 0 0 -.35 2.28v7.63a1.8 1.8 0 0 0 1.78 1.78h10.47a1.81 1.81 0 0 0 1.78-1.78v-7.87a1.78 1.78 0 0 0 -3.56 0z" />

                                                                                        <path d="m16.09 32.11v7.44 1.07c0-.16 0-.31.07-.47a.73.73 0 0 1 -.06.21l.18-.42c-.12.23.28-.3.13-.16s.41-.26.16-.15l.43-.17a.87.87 0 0 1 -.22 0l.48-.06c-.78 0-1.57 0-2.35 0s-1.56 0-2.34 0l.48.06h-.22l.43.17c-.24-.11.28.29.15.15s.27.41.13.16l.18.42a.73.73 0 0 1 -.06-.21c0 .16 0 .31.07.47-.06-1 0-1.93 0-2.89v-5.62l-1.78 1.78h5.94a1.78 1.78 0 1 0 0-3.55h-5.96a1.8 1.8 0 0 0 -1.79 1.77v8.34a2.53 2.53 0 0 0 1.27 2.25 6.64 6.64 0 0 0 3.08.32h2.63a2.5 2.5 0 0 0 2.53-2.46c0-.14 0-.27 0-.41v-2.55c0-1.79 0-3.58 0-5.37v-.1a1.8 1.8 0 0 0 -1.78-1.78 1.77 1.77 0 0 0 -1.78 1.76z" />

                                                                                    </svg> </div> <span class="text"><?php _e('Lift', 'apimo') ?></span>

                                                                            </label> </div> <?php endif;

                                                                                                    endforeach; ?> </div>

                                                        </div>

                                                    </div> <?php /***taxonomy***/ $array_of_taxonomy = array('apimo_property_standing' => __('Standing', 'apimo'), 'apimo_property_condition' => __('Condition', 'apimo'), 'apimo_heating_access' => __('Heating Access', 'apimo'));
                                                            foreach ($array_of_taxonomy as $tax => $label) : ?> <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                            <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_filter_<?php echo esc_attr($tax) ?>"><?php echo esc_attr($label); ?></label>

                                                                    <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_tax_filter" data-id="<?php echo esc_attr($tax) ?>" value="<?php echo esc_attr($tax) ?>" id="apimo_shortcode_filter_<?php echo esc_attr($tax) ?>"> <span class="slider round"></span> </div>

                                                                </label> </div>

                                                            <div data-id="apimo_shortcode_filter_<?php echo esc_attr($tax) ?>" class="apimo-filter-product-shortcode-filter-data-wrap" data-tax-id="<?php echo esc_attr($tax) ?>"> <select name="tax_filter_option" data-id="<?php echo esc_attr($tax) ?>" class="apimo_input apimo_filter_input apimo_input_select" multiple>

                                                                    <option value=""><?php _e('Select', 'apimo');

                                                                                        echo ' ';

                                                                                        echo esc_attr($label); ?></option> <?php $terms_region = get_terms(array('taxonomy' => $tax, 'hide_empty' => false));
                                                                                                                            foreach ($terms_region as $term_region) : ?> <option value="<?php echo esc_attr($term_region->term_id); ?>"><?php echo esc_attr($term_region->name); ?></option> <?php endforeach; ?>

                                                                </select> </div>

                                                        </div> <?php endforeach; ?> <?php /***taxonomy***/ /**metabox**/ $array_of_metaboxes = array('apimo_bedrooms' => array('label' => __('Bedrooms', 'apimo'), 'type' => 'number'), 'apimo_construction_year' => array('label' => __('Construction Year', 'apimo'), 'type' => 'multiselectyear'), 'apimo_renovation_year' => array('label' => __('Renovation Year', 'apimo'), 'type' => 'multiselectyear'), 'apimo_price_hide' => array('label' => __('Price Hide', 'apimo'), 'type' => 'toggle'), 'apimo_residence_fees' => array('label' => __('Price Residence Range', 'apimo'), 'type' => 'range'));
                                                                                    foreach ($array_of_metaboxes as $meta_key => $meta_data) : ?> <div class="apimo-filter-product-shortcode-filter-input-container-accordion">

                                                            <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_meta_<?php echo esc_attr($meta_key); ?>"><?php echo esc_attr($meta_data['label']); ?></label>

                                                                    <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_meta_filter" value="<?php echo esc_attr($meta_key); ?>" id="apimo_shortcode_meta_<?php echo esc_attr($meta_key); ?>" data-type="<?php echo esc_attr($meta_data['type']); ?>"> <span class="slider round"></span> </div>

                                                                </label> </div>

                                                            <div data-id="apimo_shortcode_meta_<?php echo esc_attr($meta_key); ?>" class="apimo-filter-product-shortcode-filter-data-wrap"> <?php if ($meta_data['type'] == 'number') : ?> <div class="filter-item-qty apimo-archive-filter " data-id="<?php echo esc_attr($meta_key); ?>">

                                                                        <div class="label"><?php echo esc_attr($meta_data['label']); ?></div>

                                                                        <div class="qty-buttons"> <input type="number" min="0" name="apimo_meta_filter_input" data-type="<?php echo esc_attr($meta_data['type']); ?>" data-id="<?php echo esc_attr($meta_key); ?>" class="apimo_input apimo_filter_input apimo_input_text apimo_meta_filter_input" placeholder="<?php _e('0', 'apimo') ?>"> </div>

                                                                    </div> <?php elseif ($meta_data['type'] == 'multiselectyear') : ?> <select name="apimo_meta_filter_input" data-id="<?php echo esc_attr($meta_key); ?>" class="apimo_input apimo_filter_input apimo_input_select apimo_meta_filter_input" multiple>

                                                                        <option value=""><?php _e('Select', 'apimo');

                                                                                                                                                                                                echo ' ';

                                                                                                                                                                                                echo esc_attr($meta_data['label']); ?></option> <?php for ($i = 1950; $i <= date('Y'); $i++) : ?> <option value="<?php echo $i; ?>"><?php echo $i; ?></option> <?php endfor; ?>

                                                                    </select> <?php elseif ($meta_data['type'] == 'range') : ?> <div class="fiter-range">

                                                                        <div class="range-from"> <input type="number" min="0" name="apimo_meta_filter_input" data-id="<?php echo esc_attr($meta_key); ?>" data-type="min" class="apimo_input apimo_filter_input apimo_input_text apimo_meta_filter_input" placeholder="<?php _e('From', 'apimo') ?>"> </div>

                                                                        <div class="range-to"> <input type="number" min="0" name="apimo_meta_filter_input" data-id="<?php echo esc_attr($meta_key); ?>" data-type="max" class="apimo_input apimo_filter_input apimo_input_text apimo_meta_filter_input" placeholder="<?php _e('To', 'apimo') ?>"> </div>

                                                                    </div> <?php endif; ?> </div>

                                                        </div> <?php endforeach;

                                                                                    /**metabox**/ ?> <div class="apimo-filter-product-shortcode-filter-input-container-accordion filter-item-dropdown">

                                                        <div class="apimo-filter-product-shortcode-filter-input-wrap"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title" for="apimo_shortcode_apimo_order"><?php _e('Enable ordering', 'apimo'); ?></label>

                                                                <div class="checkbox-toggle-container switch"> <input type="checkbox" name="apimo_order" value="apimo_order" id="apimo_shortcode_apimo_order"> <span class="slider round"></span> </div>

                                                            </label> </div>

                                                        <div data-id="apimo_shortcode_apimo_order" class="apimo-filter-product-shortcode-filter-data-wrap">

                                                            <div class="apimo-archive-filter orderby-radio">

                                                                <div class="order-by-radio-item"> <input type="radio" id="relevance" name="order-by-properties" value="relevance" checked> <label for="relevance"><?php _e('Relevance', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="price_low_to_hig" name="order-by-properties" value="price_low_to_high"> <label for="price_low_to_hig"><?php _e('price low to high', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="price_high_to_low" name="order-by-properties" value="price_high_to_low"> <label for="price_high_to_low"><?php _e('price high to low', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="area_low_to_high" name="order-by-properties" value="area_low_to_high"> <label for="area_low_to_high"><?php _e('area low to high', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="price_low_to_hig" name="order-by-properties" value="area_high_to_low"> <label for="area_high_to_low"><?php _e('area high to low', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="bedrooms_low_to_high" name="order-by-properties" value="bedrooms_low_to_high"> <label for="bedrooms_low_to_high"><?php _e('bedrooms low to high', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="bedrooms_high_to_low" name="order-by-properties" value="bedrooms_high_to_low"> <label for="bedrooms_high_to_low"><?php _e('bedrooms high to low', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="rooms_low_to_high" name="order-by-properties" value="rooms_low_to_high"> <label for="rooms_low_to_high"><?php _e('rooms low to high', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="rooms_high_to_low" name="order-by-properties" value="rooms_high_to_low"> <label for="rooms_high_to_low"><?php _e('rooms high to low', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="created_at_low_to_high" name="order-by-properties" value="created_at_low_to_high"> <label for="created_at_low_to_high"><?php _e('created_at low to high', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="created_at_high_to_low" name="order-by-properties" value="created_at_high_to_low"> <label for="created_at_high_to_low"><?php _e('created_at high to low', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="updated_at_low_to_high" name="order-by-properties" value="updated_at_low_to_high"> <label for="updated_at_low_to_high"><?php _e('updated_at low to high', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="updated_at_high_to_low" name="order-by-properties" value="updated_at_high_to_low"> <label for="updated_at_high_to_low"><?php _e('updated_at high to low', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="published_at_low_to_high" name="order-by-properties" value="published_at_low_to_high"> <label for="published_at_low_to_high"><?php _e('published_at low to high', 'apimo'); ?></label> </div>

                                                                <div class="order-by-radio-item"> <input type="radio" id="published_at_high_to_low" name="order-by-properties" value="published_at_high_to_low"> <label for="published_at_high_to_low"><?php _e('published_at high to low', 'apimo'); ?></label> </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div> <!-- </div> -->



                                        <!-- </div> -->

                                        <div data-id="apimo-product-by-tags" class=" apimo-proprty-selection-types">

                                            <div class="filter-section-selects-container"> <select name="step[step_1][repository_tags]" class="apimo-portrait-select-box" multiple data-placeholder="<?php _e("Select Apimo tags", 'apimo'); ?>"> <?php $repository_tags_args = array('taxonomy' => 'repository_tags', 'hide_empty' => false,);

                                                                                                                                                                                                                                                    $repository_tags = get_terms($repository_tags_args);
                                                                                                                                                                                                                                                    foreach ($repository_tags as $repository_tag) { ?> <option value="<?php echo esc_attr($repository_tag->term_id); ?>"><?php echo esc_attr($repository_tag->name); ?></option> <?php } ?> </select> <select name="step[step_1][customised_tags]" class="apimo-portrait-select-box" multiple data-placeholder="<?php _e("Select your customised tags", 'apimo'); ?>"> <?php $customised_tags_args = array('taxonomy' => 'customised_tags', 'hide_empty' => false,);

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $customised_tags = get_terms($customised_tags_args);

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        foreach ($customised_tags as $customised_tag) { ?> <option value="<?php echo esc_attr($customised_tag->term_id); ?>"><?php echo esc_attr($customised_tag->name); ?></option> <?php } ?> </select> </div>

                                        </div>

                                        <div data-id="apimo-product-by-manual-selection" class=" apimo-proprty-selection-types">

                                            <div class="filter-section-selects-container"> <select name="step[step_1][font]" class="apimo-portrait-select-box" multiple data-placeholder="<?php _e("Select properties", 'apimo'); ?>"> <?php $properties_args = array('numberposts' => -1, 'post_type' => 'property');

                                                                                                                                                                                                                                        $properties = get_posts($properties_args);

                                                                                                                                                                                                                                        foreach ($properties as $property) { ?> <option value="<?php echo esc_attr($property->ID); ?>"><?php _e($property->post_title, 'apimo'); ?></option> <?php } ?> </select> </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="apimo-step-buttons">
                                <button type="button" class="button apimo-step-button apimo-step-previous" data-id="2"><?php _e('Previous', 'apimo') ?></button> <button type="button" class="button button-primary apimo-step-button apimo-step-next" data-id="4"><?php _e('Next', 'apimo') ?></button>
                            </div>

                        </div>

                        <div class="apimo-step step-4" data-id="4">

                            <div class="apimo-step-title-inner">

                                <h5><?php _e('Choose your template', 'apimo'); ?></h5>

                                <p><?php _e('Select a template for displaying properties:'); ?>

                            </div>

                            <div class="apimo-step-description">

                                <div class="apimo-radiogroup"> <label class="apimo-type-radio">

                                        <div class="apimo-radio-container">
                                            <input type="radio" name="step[step_2][template]" value="template_1" id="apimo-template-1">
                                            <label for="apimo-template-1"><?php _e('Horizontal', 'apimo'); ?>
                                                <span class="info-icon" title="Display the Propeties Horizontaly">
                                                    ℹ️
                                                    <!-- Information details displayed on hover -->
                                                    <span class="info-details"><?php _e('Display the Propeties Horizontaly', 'apimo') ?></span>
                                                </span>
                                                <div class="apimo-radio-image">
                                                    <img src="<?php echo esc_url($apimo_url . 'assets/images/Horizzontal.png'); ?>">
                                                </div>
                                            </label>
                                        </div>

                                    </label> <label class="apimo-type-radio">

                                        <div class="apimo-radio-container">
                                            <input type="radio" name="step[step_2][template]" value="template_2" id="apimo-template-2">
                                            <label for="apimo-template-2"><?php _e('Vertical', 'apimo'); ?>
                                                <span class="info-icon" title="Display the Propeties Vertical">
                                                    ℹ️
                                                    <!-- Information details displayed on hover -->
                                                    <span class="info-details"><?php _e('Display the Propeties Vertical', 'apimo') ?></span>
                                                </span>
                                                <div class="apimo-radio-image">
                                                    <img src="<?php echo esc_url($apimo_url . 'assets/images/Vertical.png'); ?>">
                                                </div>
                                            </label>
                                        </div>

                                    </label> </div>

                            </div>

                            <div class="apimo-step-buttons"> <button type="button" class="button apimo-step-button apimo-step-previous" data-id="3"><?php _e('Previous', 'apimo') ?></button> <button type="button" class="button button-primary apimo-step-button apimo-step-next" data-id="5"><?php _e('Next', 'apimo') ?></button> </div>

                        </div>

                        <div class="apimo-step step-5" data-id="5">

                            <div class="apimo-step-title-inner">

                                <h5><?php _e('Display option', 'apimo'); ?></h5>

                                <p><?php _e('Choose how your properties are displayed', 'apimo'); ?>

                            </div>

                            <div class="apimo-step-description">

                                <div class="apimo-radiogroup"> <label class="apimo-type-radio radio-flex">

                                        <div class="radio-container"> <input type="radio" name="apimo_shortcode_view_type" value="grid" id="apimo-view-1" checked> <label for="apimo-view-1"><?php _e('Grid view', 'apimo'); ?> <div class="apimo-radio-image"> <img src="<?php echo esc_url($apimo_url . 'assets/images/Grid.png'); ?>"> </div> </label> </div>

                                        <div class="apimo-radio-settings">

                                            <div class="apimo-radio-setting-description">

                                                <div class="apimo-block-label">

                                                    <h5><?php _e('Number of elements', 'apimo'); ?></h5>
                                                    <span class="info-icon" title="Select the number of properties to display on grid view">
                                                        ℹ️
                                                        <!-- Information details displayed on hover -->
                                                        <span class="info-details">
                                                            <?php _e('Select the number of properties to display on grid view', 'apimo') ?>
                                                        </span>
                                                    </span>

                                                </div>

                                                <div class="apimo-row">

                                                    <div class="apimo-col-4">

                                                        <div class="apimo-view-type">

                                                            <p><?php _e('Desktop', 'apimo'); ?>:</p> <label> <input type="number" name="step[step_3][view_1][desktop]" min="1" value="3"> </label>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-col-4">

                                                        <div class="apimo-view-type">

                                                            <p><?php _e('Tablet', 'apimo'); ?>:</p> <label> <input type="number" name="step[step_3][view_1][tablate]" min="1" value="2"> </label>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-col-4">

                                                        <div class="apimo-view-type">

                                                            <p><?php _e('Mobile', 'apimo'); ?>:</p> <label> <input type="number" name="step[step_3][view_1][mobile]" min="1" value="1"> </label>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </label> <label class="apimo-type-radio radio-flex apimo-carosal">

                                        <div class="apimo-radio-container">
                                            <input type="radio" name="apimo_shortcode_view_type" value="carousel" id="apimo-view-2">
                                            <label for="apimo-view-2"><?php _e('Carousel', 'apimo'); ?>
                                                <div class="apimo-radio-image">
                                                    <img src="<?php echo esc_url($apimo_url . 'assets/images/Carousel.png'); ?>">
                                                </div>
                                            </label>
                                        </div>

                                        <div class="apimo-radio-settings">

                                            <div class="apimo-radio-setting-description">

                                                <div class="apimo-block-label">

                                                    <h5><?php _e('Number of elements', 'apimo'); ?></h5>
                                                    <span class="info-icon" title="Select the number of properties to display on Carousel view">
                                                        ℹ️
                                                        <!-- Information details displayed on hover -->
                                                        <span class="info-details">
                                                            <?php _e('Select the number of properties to display on Carousel view', 'apimo') ?>
                                                        </span>
                                                    </span>

                                                </div>

                                                <div class="apimo-row">

                                                    <div class="apimo-col-4">

                                                        <div class="apimo-view-type">

                                                            <p><?php _e('Desktop', 'apimo'); ?>:</p> <label> <input type="number" name="step[step_3][view_2][desktop]" min="1" value="3"> </label>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-col-4">

                                                        <div class="apimo-view-type">

                                                            <p><?php _e('Tablet', 'apimo'); ?>:</p> <label> <input type="number" name="step[step_3][view_2][tablate]" min="1" value="2"> </label>

                                                        </div>

                                                    </div>

                                                    <div class="apimo-col-4">

                                                        <div class="apimo-view-type">

                                                            <p><?php _e('Mobile', 'apimo'); ?>:</p> <label> <input type="number" name="step[step_3][view_2][mobile]" min="1" value="1"> </label>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </label> </div>

                            </div>

                            <div class="apimo-step-buttons"> <button type="button" class="button apimo-step-button apimo-step-previous" data-id="4"><?php _e('Previous', 'apimo') ?></button> <button type="button" class="button button-primary apimo-step-button apimo-step-next" data-id="6"><?php _e('Next', 'apimo') ?></button> </div>

                        </div>
                        <div class="apimo-step step-6" data-id="6">

                            <div class="apimo-step-title-inner">

                                <h5><?php _e('Select type of shortcode', 'apimo'); ?></h5>

                                <p><?php _e('Select type of shortcode', 'apimo'); ?>

                            </div>

                            <div class="apimo-step-description">

                                <div class="apimo-radiogroup">
                                    <label class="apimo-type-radio">

                                        <div class="apimo-radio-container">
                                            <input type="radio" class="apimo-portrait_radio" name="apimo_shortcode_type" value="apimo_shortcode" id="apimo-type-1_" checked>

                                            <label for="apimo-type-1_"><?php _e('Apimo Shortcode', 'apimo'); ?>
                                                <span class="info-icon" title="Create Shortcode that display The properties [apimo ...]">
                                                    ℹ️
                                                    <!-- Information details displayed on hover -->
                                                    <span class="info-details"><?php _e('Create Shortcode that display The properties [apimo ...]', 'apimo') ?></span>
                                                </span>
                                                <div class="apimo-radio-image">
                                                    <img src="<?php echo esc_url($apimo_url . 'assets/images/shortcode.svg'); ?>">
                                                </div>
                                            </label>

                                        </div>

                                    </label> <label class="apimo-type-radio">

                                        <div class="apimo-radio-container">
                                            <input type="radio" class="apimo-portrait_radio" name="apimo_shortcode_type" value="apimo_search_shortcode" id="apimo-type-2_">
                                            <label for="apimo-type-2_"><?php _e('Search Shortcode', 'apimo'); ?>
                                                <span class="info-icon" title="Create Shortcode that display filter Search for Properties [search_property ...]">
                                                    ℹ️
                                                    <!-- Information details displayed on hover -->
                                                    <span class="info-details"><?php _e('Create Shortcode that display filter Search for Properties [search_property ...]', 'apimo') ?></span>
                                                </span>
                                                <div class="apimo-radio-image">
                                                    <img src="<?php echo esc_url($apimo_url . 'assets/images/search_shortcode.png'); ?>">
                                                </div>

                                            </label>
                                        </div>

                                    </label>
                                </div>


                            </div>
                            <div class="apimo-block apimo_setting_section" id="search_shortcode_page" style="display: none;">
                                <div class="apimo-block-header">
                                    <h3><?php _e("Shortcode Page Redirect", 'apimo'); ?></h3>
                                </div>
                                <div class="apimo-step-line">
                                    <div class="apimo-inner-header">
                                        <p>
                                            <span class="point-circle">1</span> <?php _e('Search Shortcode', 'apimo'); ?>
                                        </p>
                                    </div>
                                    <div class="apimo-body-inner">
                                        <div class="apimo-row">
                                            <div class="apimo-col-6">
                                                <div class="apimo-block-info">
                                                    <p><?php _e('Choose the Shortcode page that you want to redirect to when clicked on Search', 'apimo'); ?></p>
                                                </div>
                                                <select id="shortcode_page">
                                                    <?php
                                                    $pages = get_pages();

                                                    foreach ($pages as $page) {
                                                        $page_id = $page->ID;
                                                        $page_title = $page->post_title;

                                                    ?>
                                                        <option value="<?php echo get_page_link($page_id); ?>"><?php echo $page_title; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="apimo-step-buttons"> <button type="button" class="button button-primary apimo-step-button apimo-step-next" data-id="7"><?php _e('Next', 'apimo') ?></button> </div>

                        </div>

                        <div class="apimo-step step-7" data-id="7">

                            <div class="apimo-step-title-inner">

                                <h5><?php _e('Copy the shortcode', 'apimo'); ?></h5>


                                <p><?php _e("Click on the 'Generate now' button and copy the shortcode to a page on your website.", 'apimo'); ?></p>

                            </div>

                            <div class="apimo-step-desctiption-content step-shortcode-end">

                                <div class="apimo-shortcode-generate"> <input type="button" class="button button-primary" name="generate-shortcode" value="<?php _e('Generate now', 'apimo'); ?>" /> </div>

                                <div class="apimo-shortcode">
                                    <input style="margin:15px 0" type="text" placeholder="<?php _e('Shortcode title', 'apimo') ?>" name="shortcode_title" id="shortcode_title">
                                    <textarea placeholder="<?php _e('Shortcode description', 'apimo') ?>" style="width: 60%;border: 1px solid #dedede!important;" name="shortcode_description" id="shortcode_description" cols="30" rows="10"></textarea>
                                </div>
                                <div class="apimo-shortcode">
                                    <input type="text" name="shortcode" id="shortcode" value="[apimo]" />
                                    <input type="button" class="button" name="copy_shortcode" value="<?php _e('Copy', 'apimo'); ?>" />

                                </div>

                            </div>

                            <div class="apimo-step-buttons">
                                <button type="button" class="button apimo-step-button apimo-step-previous" data-id="6"><?php _e('Previous', 'apimo') ?></button>
                                <input id="save_shortcode" type="submit" class="button button-primary" name="save_shortcode" value="<?php _e('Add to Bookmark', 'apimo') ?>">
                            </div>





                        </div>

                    </div>

                    <!--old one -->




                </div>

                <div class="apimo-footer align-right"> <button type="button" class="button button-primary wt_iew_export_action_btn" id="apimo_create_shortcode"><?php _e('Generate shortcode', 'apimo'); ?></button> </div>

            </div>
            <!-- Style setting -->
            <section class="apimo-block apimo_setting_section style-settings">

                <div class="apimo-block-header">

                    <h3><?php _e('General settings', 'apimo'); ?></h3>

                </div>

                <div class="apimo-block-body apimo-section-description">

                    <div class="apimo-row">

                        <div class="apimo-col-4">

                            <div class="apimo-block-label">

                                <h5><?php _e('Slug', 'apimo'); ?></h5>

                            </div>

                            <div class="apimo-block-info">

                                <p>
                                    <?php _e("Manage the slug of your custom post type 'properties'. You can add your custom URL for the Properties List and Detail Page.", "apimo") ?>

                            </div>

                            <div class="apimo-step-desctiption-content">

                                <div class="apimo-radio-settings">

                                    <div class="apimo-row">

                                        <div class="apimo-col-auto">

                                            <div class="apimo-view-type">

                                                <p><?php _e('Properties List', 'apimo'); ?>:</p> <label> <input type="text" name="archive[archive_slug]" min="1" value="<?php echo esc_html($archive['archive_slug']); ?>"> </label>

                                            </div>

                                        </div>

                                        <div class="apimo-col-auto">

                                            <div class="apimo-view-type">

                                                <p><?php _e('Detail Page', 'apimo'); ?>:</p> <label> <input type="text" name="archive[single_slug]" min="1" value="<?php echo esc_html($archive['single_slug']); ?>"> </label>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="apimo-col-4">

                            <div class="apimo-block-label">

                                <h5><?php _e('Color settings', 'apimo'); ?></h5>

                            </div>

                            <div class="apimo-block-info">

                                <p><?php _e('This style is general for all the pages regarding the APIMO plugin.', 'apimo'); ?></p>

                            </div>

                            <div class="apimo-style">

                                <div class="apimo-row">

                                    <div class="apimo-col-auto">

                                        <div class="apimo-block-label">

                                            <h5><?php _e('Primary', 'apimo'); ?></h5>

                                        </div>

                                        <div class="aprimo-block-style-option">

                                            <p><?php _e('Choose a color', 'apimo') ?>:</p> <label> <input type="text" class="apimo-color-picker-field" name="style[primary][color]" placeholder="<?php _e('Select Color', 'apimo'); ?>" value="<?php echo esc_html($apimo_style['primary']['color']); ?>"> </label>

                                        </div>

                                    </div>

                                    <div class="apimo-col-auto">

                                        <div class="apimo-block-label">

                                            <h5><?php _e('Secondary', 'apimo'); ?></h5>

                                        </div>

                                        <div class="aprimo-block-style-option">

                                            <p><?php _e('Choose a color', 'apimo') ?>:</p> <label> <input type="text" class="apimo-color-picker-field" name="style[secondary][color]" placeholder="<?php _e('Select Color', 'apimo'); ?>" value="<?php echo esc_html($apimo_style['secondary']['color']); ?>"> </label>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="apimo-col-3">

                            <div class="apimo-block-label">

                                <h5><?php _e('Container Settings', 'apimo'); ?></h5>

                            </div>

                            <div class="apimo-block-info">

                                <p><?php _e("Set up the width of the container for APIMO archive.", "apimo"); ?></p>

                            </div>

                            <div class="apimo-style">

                                <div class="apimo-row">

                                    <div class="apimo-col-auto">

                                        <div class="aprimo-block-style-option"> <label> <input type="text" name="style[container_width]" placeholder="<?php _e('Container Width', 'apimo'); ?>" value="<?php echo esc_html($apimo_style['container_width']); ?>"> <span> <select name="style[container_width_unit]">

                                                        <option value="px" <?php echo ($apimo_style['container_width_unit'] == 'px') ? "selected" : "" ?>>px</option>

                                                        <option value="%" <?php echo ($apimo_style['container_width_unit'] == '%') ? "selected" : "" ?>>%</option>

                                                    </select> </span> </label> </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>




                <div class="apimo-footer align-right"> <?php /* <button type="button" class="button button-primary wt_iew_export_action_btn" id=""><?php _e('save','apimo'); ?></button> */ ?>



                </div>

            </section>



            <!-- Archive Properties -->

            <div class="apimo-block style_archive">

                <div class="apimo-block-header">

                    <h3><?php _e('Setting - Properties List', 'apimo'); ?></h3>

                </div>

                <div class="apimo-block-body p-0">

                    <div class="apimo-step-line">

                        <div class="apimo-inner-header">

                            <p><span class="point-circle">1</span><?php _e('Layout', 'apimo'); ?></p>

                        </div>

                        <div class="apimo-body-inner">

                            <div class="apimo-block-info">

                                <p><?php _e("Choose the card type for the properties in the archive page:", "apimo") ?></p>

                            </div>

                            <div class="apimo-step-desctiption-content">

                                <div class="apimo-radiogroup"> <label class="apimo-type-radio">

                                        <div class="apimo-radio-container"> <input type="radio" name="archive[template]" value="landscape" id="apimo-landscape" <?php if ($archive['template'] == 'landscape') {

                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>> <label for="apimo-landscape">

                                                <p><?php _e('Landscape', 'apimo'); ?></p>

                                                <div class="apimo-radio-image"> <img src="<?php echo esc_url($apimo_url . '/assets/images/Horizzontal.png'); ?>"> </div>

                                            </label> </div>

                                    </label> <label class="apimo-type-radio">

                                        <div class="apimo-radio-container"> <input type="radio" name="archive[template]" value="portrait" id="apimo-portrait" <?php if ($archive['template'] == 'portrait') {

                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>> <label for="apimo-portrait">

                                                <p><?php _e('Portrait', 'apimo'); ?></p>

                                                <div class="apimo-radio-image"> <img src="<?php echo esc_url($apimo_url . '/assets/images/Vertical.png'); ?>"> </div>

                                            </label> </div>

                                    </label> </div>

                            </div>

                        </div>

                        <div class="apimo-body-inner">

                            <div class="apimo-block-info">

                                <p><?php _e('Choose the number of columns for each view of the website:', 'apimo'); ?></p>

                            </div>

                            <div class="apimo-step-desctiption-content"> <label class="apimo-type-radio">

                                    <div class="apimo-radio-settings">

                                        <div class="apimo-row">

                                            <div class="apimo-col-3">

                                                <div class="apimo-block-label">

                                                    <h5><?php _e('Desktop', 'apimo'); ?></h5>

                                                </div>

                                                <div class="apimo-view-type">

                                                    <p><?php _e('Number of elements', 'apimo'); ?>:</p> <label> <input type="number" name="archive[view_1][desktop]" min="1" value="<?php echo esc_html($archive['view_1']['desktop']); ?>"> </label>

                                                </div>

                                            </div>

                                            <div class="apimo-col-3">

                                                <div class="apimo-block-label">

                                                    <h5><?php _e('Tablet', 'apimo'); ?></h5>

                                                </div>

                                                <div class="apimo-view-type">

                                                    <p><?php _e('Number of elements', 'apimo'); ?>:</p> <label> <input type="number" name="archive[view_1][teblate]" min="1" value="<?php echo esc_html($archive['view_1']['teblate']); ?>"> </label>

                                                </div>

                                            </div>

                                            <div class="apimo-col-3">

                                                <div class="apimo-block-label">

                                                    <h5><?php _e('Mobile', 'apimo'); ?></h5>

                                                </div>

                                                <div class="apimo-view-type">

                                                    <p><?php _e('Number of elements', 'apimo'); ?>:</p> <label> <input type="number" name="archive[view_1][mobile]" min="1" value="<?php echo esc_html($archive['view_1']['mobile']); ?>"> </label>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </label> </div>

                        </div>

                    </div>

                </div>

                <div class="apimo-step-line">

                    <div class="apimo-inner-header">

                        <p><span class="point-circle">2</span><?php _e('Filter and pagination', 'apimo'); ?></p>

                    </div>

                    <div class="apimo-body-inner">

                        <div class="apimo-step-desctiption-content">

                            <div class="apimo-row">

                                <div class="apimo-col-8">

                                    <div class="apimo-block-info">

                                        <p><?php _e('Choose the filter to show in your archive page:', 'apimo'); ?></p>

                                    </div>

                                    <div class="apimo-step-description mt-15">

                                        <div class="apimo-row">

                                            <div class="apimo-col-6">

                                                <div class="apimo-container">

                                                    <div class="apimo-block-label">

                                                        <h5><?php _e('Standard filter', 'apimo') ?></h5>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][]" value="category_filter" id="apimo-archive-category_filter" <?php if (in_array("category_filter", $archive['filter'])) {

                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>> <span class="check"></span> <label for="apimo-archive-category_filter"><?php _e('Category Filter', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][]" value="subtype_filter" id="apimo-archive-subtype_filter" <?php if (in_array("subtype_filter", $archive['filter'])) {

                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>> <span class="check"></span> <label for="apimo-archive-subtype_filter"><?php _e('Subtype Filter', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][]" value="number_of_rooms" id="apimo-archive-number_of_rooms" <?php if (in_array("number_of_rooms", $archive['filter'])) {

                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>> <span class="check"></span> <label for="apimo-archive-number_of_rooms"><?php _e('Number of rooms', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][]" value="number_of_bedrooms" id="apimo-archive-number_of_bedrooms" <?php if (in_array("number_of_bedrooms", $archive['filter'])) {

                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>> <span class="check"></span> <label for="apimo-archive-number_of_bedrooms"><?php _e('Number of bedrooms', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][]" value="price_range" id="apimo-archive-price_range" <?php if (in_array("price_range", $archive['filter'])) {

                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>> <span class="check"></span> <label for="apimo-archive-price_range"><?php _e('Price range', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][]" value="property_areas" id="apimo-archive-property_areas" <?php if (in_array("property_areas", $archive['filter'])) {

                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>> <span class="check"></span> <label for="apimo-archive-property_areas"><?php _e('Areas range', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][]" value="dates" id="apimo-archive-dates" <?php if (in_array("dates", $archive['filter'])) {

                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>> <span class="check"></span> <label for="apimo-archive-dates"><?php _e('Dates', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][]" value="location" id="apimo-archive-location" <?php if (in_array("location", $archive['filter'])) {

                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>> <span class="check"></span> <label for="apimo-archive-location"><?php _e('Location (Region, City, District)', 'apimo'); ?></label> </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="apimo-col-6">

                                                <div class="apimo-container">

                                                    <div class="apimo-block-label">

                                                        <h5><?php _e('Advance filter', 'apimo') ?></h5>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][advance][]" value="garden" id="apimo-archive-garden" <?php if (in_array("garden", $archive['filter']['advance'])) {

                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>> <span class="check"></span> <label for="apimo-archive-garden"><?php _e('Garden', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][advance][]" value="terrace" id="apimo-archive-terrace" <?php if (in_array("terrace", $archive['filter']['advance'])) {

                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>> <span class="check"></span> <label for="apimo-archive-terrace"><?php _e('Terrace', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][advance][]" value="balcony" id="apimo-archive-balcony" <?php if (in_array("balcony", $archive['filter']['advance'])) {

                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>> <span class="check"></span> <label for="apimo-archive-balcony"><?php _e('Balcony', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][advance][]" value="garage_box" id="apimo-archive-garage_box" <?php if (in_array("garage_box", $archive['filter']['advance'])) {

                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>> <span class="check"></span> <label for="apimo-archive-garage_box"><?php _e('Garage or Box', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][advance][]" value="parking_space" id="apimo-archive-parking_space" <?php if (in_array("parking_space", $archive['filter']['advance'])) {

                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>> <span class="check"></span> <label for="apimo-archive-parking_space"><?php _e('Parking space (internal or external)', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][advance][]" value="cellar" id="apimo-archive-cellar" <?php if (in_array("cellar", $archive['filter']['advance'])) {

                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>> <span class="check"></span> <label for="apimo-archive-cellar"><?php _e('Cellar', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][advance][]" value="pool" id="apimo-archive-pool" <?php if (in_array("pool", $archive['filter']['advance'])) {

                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>> <span class="check"></span> <label for="apimo-archive-pool"><?php _e('Pool', 'apimo'); ?></label> </div>

                                                    </div>

                                                    <div class="apimo-checkbox-container">

                                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[filter][advance][]" value="lift" id="apimo-archive-lift" <?php if (in_array("lift", $archive['filter']['advance'])) {

                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>> <span class="check"></span> <label for="apimo-archive-lift"><?php _e('Lift', 'apimo'); ?></label> </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="apimo-col-3">

                                    <div class="apimo-block-info">

                                        <p><?php _e('Enable pagination and choose the number of elements:', 'apimo'); ?></p>

                                    </div>

                                    <div class="apimo-step-description mt-15"> <label class="apimo-field checkbox-toggle"> <label class="apimo-title"><strong><?php _e('Enable pagination', 'apimo'); ?></strong></label>

                                            <div class="checkbox-toggle-container switch"> <input type="checkbox" name="archive[pagination_enable]" <?php if ($archive['pagination_enable']) {

                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?> /> <span class="slider round"></span> </div>

                                        </label> </div>

                                    <div class="apimo-step-description mt-15"> <label class="apimo-field"> <label class="apimo-title"><?php _e('Number of post per page', 'apimo'); ?></label> <input type="number" name="archive[num_of_post]" value="<?php echo esc_html($archive['num_of_post']); ?>" /> </label> </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="apimo-step-line">

                    <div class="apimo-inner-header">

                        <p><span class="point-circle">3</span><?php _e('Display options', 'apimo'); ?></p>

                    </div>

                    <div class="apimo-body-inner">

                        <div class="apimo-row">

                            <div class="apimo-col-6">

                                <div class="apimo-block-label">

                                    <h5><?php _e('Meta fields - Apimo Cards', 'apimo'); ?></h5>

                                </div>

                                <div class="apimo-block-info">

                                    <p><?php _e('Choose the meta field to show in the properties cards', 'apimo'); ?></p>

                                </div>

                                <div class="apimo-step-description checkbox-inline"> <label class="apimo-field">

                                        <div class="box-apimo-checkbox"> <input id="card_number_of_rooms" type="checkbox" name="archive[archive_display_option][]" value="number_of_rooms" <?php if (in_array('number_of_rooms', $archive['archive_display_option'])) {

                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> /> <span class="check"></span> <label for="card_number_of_rooms" class="apimo-title"><?php _e('Rooms', 'apimo'); ?></label> </div>

                                    </label> <label class="apimo-field">

                                        <div class="box-apimo-checkbox"> <input id="card_bathroom" type="checkbox" name="archive[archive_display_option][]" value="bathroom" <?php if (in_array('bathroom', $archive['archive_display_option'])) {

                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?> /> <span class="check"></span> <label for="card_bathroom" class="apimo-title"><?php _e('Bath', 'apimo'); ?></label> </div>

                                    </label> <label class="apimo-field">

                                        <div class="box-apimo-checkbox"> <input id="card_areas" type="checkbox" name="archive[archive_display_option][]" value="areas" <?php if (in_array('areas', $archive['archive_display_option'])) {

                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?> /> <span class="check"></span> <label for="card_areas" class="apimo-title"><?php _e('MQ Areas', 'apimo'); ?></label> </div>

                                    </label> <label class="apimo-field">

                                        <div class="box-apimo-checkbox"> <input id="card_external_areas" type="checkbox" name="archive[archive_display_option][]" value="external_areas" <?php if (in_array('external_areas', $archive['archive_display_option'])) {

                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> /> <span class="check"></span> <label for="card_external_areas" class="apimo-title"><?php _e('External Areas', 'apimo'); ?></label> </div>

                                    </label> </div>

                            </div>

                            <div class="apimo-col-6">

                                <div class="apimo-block-label">

                                    <h5><?php _e('Meta fields "Area"'); ?></h5>

                                </div>

                                <div class="apimo-block-info">

                                    <p><?php _e('Choose the area type value to show on your website', 'apimo'); ?></p>

                                </div>

                                <div class="apimo-step-description checkbox-inline"> <label class="apimo-field">

                                        <div class="box-apimo-checkbox"> <input type="radio" name="archive[area_display_type]" value="weighted" id="area_type_weighted" <?php if ($archive['area_display_type'] == 'weighted' || $archive['area_display_type'] == '') {

                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?> /> <span class="check"></span> <label for="area_type_weighted" class="apimo-title"><?php _e('Commercial area', 'apimo'); ?></label> </div>

                                    </label> <label class="apimo-field">

                                        <div class="box-apimo-checkbox"> <input type="radio" name="archive[area_display_type]" value="total" id="area_type_total" <?php if ($archive['area_display_type'] == 'total') {

                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?> /> <span class="check"></span> <label for="area_type_total" class="apimo-title"><?php _e('Total area', 'apimo'); ?></label> </div>

                                    </label> <label class="apimo-field">

                                        <div class="box-apimo-checkbox"> <input type="radio" name="archive[area_display_type]" value="value" id="area_type_value" <?php if ($archive['area_display_type'] == 'value') {

                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?> /> <span class="check"></span> <label for="area_type_value" class="apimo-title"><?php _e('Net area', 'apimo'); ?></label> </div>

                                    </label> </div>

                            </div>

                            <div class="apimo-col-6">

                                <div class="apimo-block-label">

                                    <h5><?php _e('Hide Icon', 'apimo'); ?></h5>

                                </div>

                                <div class="apimo-block-info">
                                    <p><?php _e("Select this option to remove all icons from the metadata. This option will affect the archive page and all shortcodes.", "apimo"); ?></p>
                                </div>

                                <div class="apimo-step-description checkbox-inline"> <label class="apimo-field">

                                        <div class="box-apimo-checkbox"> <input type="checkbox" name="archive[hideicon]" value="hideicon" id="hideicon" <?php if ($archive['hideicon'] == 'hideicon') {

                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?> /> <span class="check"></span> <label for="hideicon" class="apimo-title"><?php _e('Yes, I want remove all the icon', 'apimo'); ?></label> </div>

                                    </label> </div>

                            </div>
                            <div class="apimo-col-6">

                                <div class="apimo-block-label">

                                    <h5><?php _e('Hide User info', 'apimo'); ?></h5>

                                </div>


                                <div class="apimo-step-description checkbox-inline">

                                    <label class="apimo-field">

                                        <div class="box-apimo-checkbox">

                                            <input type="checkbox" name="archive[userinfo]" value="hide" id="userinfo" <?php if ($archive['userinfo'] == 'hide') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?> />
                                            <span class="check"></span> <label for="userinfo" class="apimo-title">
                                                <?php _e('Yes, I want to hide the user info', 'apimo'); ?></label>
                                        </div>

                                    </label>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="apimo-step-line">

                    <div class="apimo-inner-header">

                        <p><span class="point-circle">7</span><?php _e('Gallery Display Type', 'apimo'); ?></p>

                    </div>

                    <div class="apimo-body-inner">

                        <div class="apimo-step-description"> <label class="apimo-field"> <label class="apimo-title"><?php _e('Lightbox', 'apimo'); ?></label> <input type="checkbox" name="archive[gallery_display_lighbox]" value="1" <?php if (isset($archive['gallery_display_lighbox']) && $archive['gallery_display_lighbox'] == '1') {

                                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                                        } ?> /> </label> <label class="apimo-field"> <label class="apimo-title"><?php _e('Slider', 'apimo'); ?></label> <input type="checkbox" name="archive[gallery_display_slider]" value="1" <?php if (isset($archive['gallery_display_slider']) && $archive['gallery_display_slider'] == '1') {

                                                                                                                                                                                                                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                                                                                                                                                                                                                } ?> /> </label> </div>

                    </div>

                </div>

            </div>



            <!-- Single Properties -->

            <div class="apimo-block apimo_setting_section style_pagina">

                <div class="apimo-block-header">

                    <h3><?php _e("Layout - Detail Page", 'apimo'); ?></h3>

                </div>

                <div class="apimo-block-body apimo-section-description">

                    <div class="apimo-block-info">

                        <p><?php _e('Choose the layout for the single properties page. You can override this option for each post.', 'apimo'); ?></p>

                    </div>

                    <div class="apimo-section-description">

                        <div class="apimo-radiogroup">
                            <label class="apimo-type-radio">

                                <div class="apimo-radio-container">
                                    <input type="radio" name="apimo_style_pagina" id="apimo-pagina_style_1" value="pagina_style_1" <?php if ($apimo_style_pagina == 'pagina_style_1') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>

                                    <label for="apimo-pagina_style_1">

                                        <p><?php _e("Style 1", 'apimo'); ?></p>

                                        <div class="apimo-radio-image"> <img src="<?php echo esc_html($apimo_url . 'assets/images/Horizzontal.png'); ?>"> </div>

                                    </label>
                                </div>

                            </label>

                            <?php
                            /*                       <label class="apimo-type-radio">                            <div class="apimo-radio-container">                                <input type="radio" name="apimo_style_pagina" id="apimo-pagina_style_2" value="pagina_style_2" <?php if ($apimo_style_pagina == 'pagina_style_2') {                                                                                                                                    echo 'checked';                                                                                                                                } ?>>                                <label for="apimo-pagina_style_2">                                    <p><?php _e("Style 2", 'apimo'); ?></p>                                    <div class="apimo-radio-image">                                        <img src="<?php echo esc_url($apimo_url . 'assets/images/Vertical.png'); ?>">                                    </div>                                </label>                            </div>                        </label> */ ?>
                        </div>

                    </div>


                </div>

                <div class="apimo-block-body apimo-section-description">

                    <div class="apimo-block-info">

                        <p><?php _e('Show Unavailable Services', 'apimo'); ?></p>

                    </div>

                    <div class="apimo-section-description">

                        <div class="apimo-checkbox-container">

                            <div class="box-apimo-checkbox"> <input type="checkbox" name="apimo_show_unavailable_service" value="1" id="apimo_show_unavailable_service" <?php checked($apimo_show_unavailable_service, 1); ?>> <span class="check"></span> <label for="apimo_show_unavailable_service"><?php _e('Show Unavailable Services', 'apimo'); ?></label> </div>

                        </div>

                    </div>

                </div>

            </div>

            
            <!-- Form Configuration -->
            <div class="apimo-block apimo_setting_section form_configuration">
                                                                                                                                       
                <div class="apimo-block-header">
                    <h3><?php _e("Form Configuration", 'apimo'); ?></h3>
                </div>

                <div class="apimo-block-body apimo-section-description ">
                    <div class="apimo-block-info">
                        <p><?php _e('Customize the labels, placeholders, and required settings for the contact form fields.', 'apimo'); ?></p>
                    </div>

                    <?php
                    // Retrieve the existing form configuration
                    $saved_form_configuration = get_option('form_configuration');

                    // Define default configuration
                    $default_form_configuration = array(
                        'last_name' => array(
                            'label' => __('Last Name', 'apimo'),
                            'placeholder' => __('Enter your last name', 'apimo'),
                            'required' => 1,
                        ),
                        'first_name' => array(
                            'label' => __('First Name', 'apimo'),
                            'placeholder' => __('Enter your first name', 'apimo'),
                            'required' => 0,
                        ),
                        'phone' => array(
                            'label' => __('Phone', 'apimo'),
                            'placeholder' => __('Enter your phone number', 'apimo'),
                            'required' => 0,
                        ),
                        'email' => array(
                            'label' => __('Email', 'apimo'),
                            'placeholder' => __('Enter your email address', 'apimo'),
                            'required' => 0,
                        ),
                        'message' => array(
                            'label' => __('Message', 'apimo'),
                            'placeholder' => __('Enter your message', 'apimo'),
                            'required' => 0,
                        ),
                    );

                    // Merge saved configuration with defaults, giving priority to saved values
                    $form_configuration = wp_parse_args($saved_form_configuration, $default_form_configuration);

                    // Now update the form fields to use the retrieved configuration
                    ?>

                    <!-- Last Name Field -->
                    <div class="apimo-section-description">
                        <h4><?php _e('Last Name Field', 'apimo'); ?></h4>
                        <label><?php _e('Label', 'apimo'); ?></label>
                        <input type="text" name="apimo_last_name_label" 
                            value="<?php echo esc_attr($form_configuration['last_name']['label']); ?>">

                        <label><?php _e('Placeholder', 'apimo'); ?></label>
                        <input type="text" name="apimo_last_name_placeholder" 
                            value="<?php echo esc_attr($form_configuration['last_name']['placeholder']); ?>">

                        <label>
                            <input type="checkbox" name="apimo_last_name_required" value="1" 
                                <?php checked($form_configuration['last_name']['required'], 1); ?>>
                            <?php _e('Required', 'apimo'); ?>
                        </label>
                    </div>

                    <!-- First Name Field -->
                    <div class="apimo-section-description">
                        <h4><?php _e('First Name Field', 'apimo'); ?></h4>
                        <label><?php _e('Label', 'apimo'); ?></label>
                        <input type="text" name="apimo_first_name_label" 
                            value="<?php echo esc_attr($form_configuration['first_name']['label']); ?>">

                        <label><?php _e('Placeholder', 'apimo'); ?></label>
                        <input type="text" name="apimo_first_name_placeholder" 
                            value="<?php echo esc_attr($form_configuration['first_name']['placeholder']); ?>">

                        <label>
                            <input type="checkbox" name="apimo_first_name_required" value="1" 
                                <?php checked($form_configuration['first_name']['required'], 1); ?>>
                            <?php _e('Required', 'apimo'); ?>
                        </label>
                    </div>

                    <!-- Phone Field -->
                    <div class="apimo-section-description">
                        <h4><?php _e('Phone Field', 'apimo'); ?></h4>
                        <label><?php _e('Label', 'apimo'); ?></label>
                        <input type="text" name="apimo_phone_label" 
                            value="<?php echo esc_attr($form_configuration['phone']['label']); ?>">

                        <label><?php _e('Placeholder', 'apimo'); ?></label>
                        <input type="text" name="apimo_phone_placeholder" 
                            value="<?php echo esc_attr($form_configuration['phone']['placeholder']); ?>">

                        <label>
                            <input type="checkbox" name="apimo_phone_required" value="1" 
                                <?php checked($form_configuration['phone']['required'], 1); ?>>
                            <?php _e('Required', 'apimo'); ?>
                        </label>
                    </div>

                    <!-- Email Field -->
                    <div class="apimo-section-description">
                        <h4><?php _e('Email Field', 'apimo'); ?></h4>
                        <label><?php _e('Label', 'apimo'); ?></label>
                        <input type="text" name="apimo_email_label" 
                            value="<?php echo esc_attr($form_configuration['email']['label']); ?>">

                        <label><?php _e('Placeholder', 'apimo'); ?></label>
                        <input type="text" name="apimo_email_placeholder" 
                            value="<?php echo esc_attr($form_configuration['email']['placeholder']); ?>">

                        <label>
                            <input type="checkbox" name="apimo_email_required" value="1" 
                                <?php checked($form_configuration['email']['required'], 1); ?>>
                            <?php _e('Required', 'apimo'); ?>
                        </label>
                    </div>

                    <!-- Message Field -->
                    <div class="apimo-section-description">
                        <h4><?php _e('Message Field', 'apimo'); ?></h4>
                        <label><?php _e('Label', 'apimo'); ?></label>
                        <input type="text" name="apimo_message_label" 
                            value="<?php echo esc_attr($form_configuration['message']['label']); ?>">

                        <label><?php _e('Placeholder', 'apimo'); ?></label>
                        <input type="text" name="apimo_message_placeholder" 
                            value="<?php echo esc_attr($form_configuration['message']['placeholder']); ?>">

                        <label>
                            <input type="checkbox" name="apimo_message_required" value="1" 
                                <?php checked($form_configuration['message']['required'], 1); ?>>
                            <?php _e('Required', 'apimo'); ?>
                        </label>
                    </div>
                </div>

            </div>
                                                                                                                    


        </div> <!-- Archive Shortcode -->

    </div><!-- Remove </div></div> missing -->



</form>



<script>
    function openDropMenu() {

        document.getElementById("myDropdown").classList.toggle("show");

        return false;

    }

    window.onclick = function(e) {

        if (!e.target.matches('.dropbtn')) {

            var myDropdown = document.getElementById("myDropdown");

            if (myDropdown.classList.contains('show')) {

                myDropdown.classList.remove('show');

            }

        }

    }
</script>
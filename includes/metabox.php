<?php



add_action('add_meta_boxes', 'apimo_meta_box_cb');

function apimo_meta_box_cb()
{

    add_meta_box('gallery_images_metabox', 'Gallery Images', 'apimo_meta_box_gallery', APIMO_POST_TYPE);

    add_meta_box('properties_details_metabox', 'Properties Details', 'apimo_meta_box_details', APIMO_POST_TYPE);

}



function apimo_meta_box_gallery()
{

    global $post;

    $post_ID = $post->ID; // global used by get_upload_iframe_src

    $images = get_post_meta($post_ID, 'apimo_gallery_images', true);

?>

<div class="apimo-property-gallery">

    <div class="select-gallery-input">

        <label>Select Gallery Images : </label>

        <input type="button" id="image_gallery" name="image-gallery" value="Upload Images" />

    </div>

    <div class="apimo-all-selected-images">

        <?php

    if (is_array($images) && count($images)) {

        foreach ($images as $image) {
            $escaped_image = esc_url($image);
        ?>
        <div class="apimo_gallery_image">
            <div class='apimo-remove-image'>X</div>
            <img src="<?php echo esc_url($escaped_image); ?>" />
            <input type="hidden" name="apimo_gallery_images[]" value="<?php echo esc_url($escaped_image); ?>">
        </div>
        <?php
        }

    }

        ?>

    </div>

</div>

<?php

}





function apimo_meta_box_details()
{

    global $post;

    $post_ID = $post->ID; // global used by get_upload_iframe_src

    $apimo_template_type = get_post_meta($post_ID, 'apimo_template_type', true);

?>

<script>

    // Single property tabs fields

    function openCity(evt, cityName) {

        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");

        for (i = 0; i < tabcontent.length; i++) {

            tabcontent[i].style.display = "none";

        }

        tablinks = document.getElementsByClassName("tablinks");

        for (i = 0; i < tablinks.length; i++) {

            tablinks[i].className = tablinks[i].className.replace(" active", "");

        }

        document.getElementById(cityName).style.display = "block";

        evt.currentTarget.className += " active";

    }

    document.getElementById("defaultOpen").click();

</script>

<div class="apimo-metabox properties_details">

    <!-- <div class="properties_details_label">

            <label><?php _e('Properties Details', 'apimo'); ?></label>

        </div> -->

    <div class="apimo_property_details_fields">



        <div class="apimo-details-section">

            <div class="apimo-tab tab">

                <button class="tablinks" onclick="openCity(event, 'General')">General</button>

                <button class="tablinks" onclick="openCity(event, 'Address')">Address</button>

                <button class="tablinks" onclick="openCity(event, 'Price')">Price</button>

            </div>

            <div class="apimo-fields-block">



                <div id="General" class="tabcontent">

                    <div class="detail_row">

                        <div class="apimo-desc">

                            <label class="row_label"><?php _e('Template Type', 'apimo'); ?></label>

                            <p><?php _e('Puoi sostituire il template selezionato di default.', 'apimo'); ?></p>

                        </div>

                        <div class="apimo-field">

                            <input type="radio" name="apimo_template_type" id="template_1" value="pagina_style_1" <?php if ($apimo_template_type == 'pagina_style_1') {
        echo 'checked';
    } ?> />

                            <label for="template_1"><?php _e('Template 1', 'apimo'); ?></label>

                            <input type="radio" name="apimo_template_type" id="template_2" value="pagina_style_2" <?php if ($apimo_template_type == 'pagina_style_2') {
        echo 'checked';
    } ?> />

                            <label for="template_2"><?php _e('Template 2', 'apimo'); ?></label>

                        </div>

                    </div>

                </div>



                <div id="Address" class="tabcontent">



                    <div class="detail_row">

                        <div class="apimo-desc">

                            <label class="row_label"><?php _e('Street Number', 'apimo'); ?></label>

                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>

                        </div>

                        <div class="apimo-field">

                            <input type="text" name="apimo_address"
                                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_address', true)); ?>" />

                        </div>

                    </div>

                    <div class="detail_row">

                        <div class="apimo-desc">

                            <label class="row_label"><?php _e('More details: ', 'apimo'); ?></label>

                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>

                        </div>

                        <div class="apimo-field">

                            <input type="text" name="apimo_address_more"
                                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_address_more', true)); ?>" />

                        </div>

                    </div>

                    <div class="detail_row">

                        <div class="apimo-desc">

                            <label class="row_label"><?php _e('Do you want to publish the address?', 'apimo'); ?></label>

                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>

                        </div>

                        <div class="apimo-field">

                            <input type="checkbox" name="apimo_publish_address" <?php if (get_post_meta($post_ID, 'apimo_address_more', true)) {
        echo 'checked';
    } ?> />

                        </div>

                    </div>

                    <div class="detail_row">

                        <div class="apimo-desc">

                            <label class="row_label"><?php _e('Longitude', 'apimo'); ?></label>

                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>

                        </div>

                        <div class="apimo-field">

                            <input type="text" name="apimo_longitude"
                                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_longitude', true)); ?>" />

                        </div>

                    </div>

                    <div class="detail_row">

                        <div class="apimo-desc">

                            <label class="row_label"><?php _e('Latitude', 'apimo'); ?></label>

                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>

                        </div>

                        <div class="apimo-field">

                            <input type="text" name="apimo_latitude"
                                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_latitude', true)); ?>" />

                        </div>

                    </div>

                    <div class="detail_row">

                        <div class="apimo-desc">

                            <label class="row_label"><?php _e('Radius coordinate : ', 'apimo'); ?></label>

                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>

                        </div>

                        <div class="apimo-field">

                            <input type="text" name="apimo_radius"
                                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_radius', true)); ?>" />

                        </div>

                    </div>



                </div>



                <div id="Tokyo" class="tabcontent">

                    <h3>Tokyo</h3>

                    <p>Tokyo is the capital of Japan.</p>

                </div>

            </div>

        </div>

        <div class="detail_row">

            <div class="apimo-desc">

                <label class="row_label"><?php _e('Enter Agency : ', 'apimo'); ?></label>

            </div>

            <div class="apimo-field">

                <input type="text" name="apimo_agency"
                    value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_agency', true)); ?>" />

            </div>

        </div>

        <?php /*
         <div class="detail_row">
         <label class="row_label"><?php _e('Enter Brand : ','apimo'); ?></label>
         <input type="text" name="apimo_brand"  value="<?php echo esc_html(get_post_meta($post_ID,'apimo_brand',true)); ?>"/>
         </div>
         <div class="detail_row">
         <label class="row_label"><?php _e('Enter User ID : ','apimo'); ?></label>
         <input type="text" name="apimo_user_id"  value="<?php echo esc_html(get_post_meta($post_ID,'apimo_user_id',true)); ?>"/>
         </div>
         <div class="detail_row">
         <label class="row_label"><?php _e('Enter Type : ','apimo'); ?></label>
         <input type="text" name="apimo_type"  value="<?php echo esc_html(get_post_meta($post_ID,'apimo_type',true)); ?>"/>
         </div>
         <div class="detail_row">
         <label class="row_label"><?php _e('Enter SubType : ','apimo'); ?></label>
         <input type="text" name="apimo_subtype"  value="<?php echo esc_html(get_post_meta($post_ID,'apimo_subtype',true)); ?>"/>
         </div>*/?>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Block Name : ', 'apimo'); ?></label>

            <input type="text" name="apimo_block_name"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_block_name', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Lot Reference: ', 'apimo'); ?></label>

            <input type="text" name="apimo_lot_reference"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_lot_reference', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Rooms : ', 'apimo'); ?></label>

            <input type="text" name="apimo_rooms"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_rooms', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Badrooms : ', 'apimo'); ?></label>

            <input type="text" name="apimo_bedrooms"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_bedrooms', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Sleeps : ', 'apimo'); ?></label>

            <input type="text" name="apimo_sleeps"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_sleeps', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Property Price : ', 'apimo'); ?></label>

            <input type="text" name="apimo_price"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_price', true)); ?>" />

        </div>



        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Area unit : ', 'apimo'); ?></label>

            <select name="apimo_area_unit" class="apimo_select2">

                <option value="">Select Area Unit</option>

                <?php

    foreach ($UNIT_AREA as $area_id => $name) {

                ?>

                <option value="<?php echo esc_attr($area_id); ?>" <?php if (get_post_meta($post_ID, 'apimo_area_unit', true) == $area_id) {
            echo 'selected';
        } ?>><?php echo esc_html($name); ?></option>

                <?php

    }

                ?>

            </select>

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Area value : ', 'apimo'); ?></label>

            <input type="text" name="apimo_area_value"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_area_value', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Area total : ', 'apimo'); ?></label>

            <input type="text" name="apimo_area_total"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_area_total', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Area weighted : ', 'apimo'); ?></label>

            <input type="text" name="apimo_area_weighted"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_area_weighted', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Price Hide ? ', 'apimo'); ?></label>

            <input type="checkbox" name="apimo_price_hide" <?php if (get_post_meta($post_ID, 'apimo_price_hide', true)) {
        echo 'checked';
    } ?> />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Price Currency : ', 'apimo'); ?></label>

            <input type="text" name="apimo_price_currency"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_price_currency', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Construction year : ', 'apimo'); ?></label>

            <input type="text" name="apimo_construction_year"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_construction_year', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Construction Renovation year : ', 'apimo'); ?></label>

            <input type="text" name="apimo_renovation_year"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_renovation_year', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Construction Renovation Cost : ', 'apimo'); ?></label>

            <input type="text" name="apimo_renovation_cost"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_renovation_cost', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Residence Period: ', 'apimo'); ?></label>

            <select name="apimo_residence_period" class="apimo_select2">

                <option value="">Select Residence Period</option>

                <?php

    foreach (PROPERTY_PERIOD as $period_id => $period_name) {

                ?>

                <option value="<?php echo esc_html($period_id); ?>" <?php if (get_post_meta($post_ID, 'apimo_residence_period', true) == $period_id) {
            echo 'selected';
        } ?>><?php echo esc_html($period_name); ?>
                </option>

                <?php

    }

                ?>

            </select>

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Residence Fees: ', 'apimo'); ?></label>

            <input type="text" name="apimo_residence_fees"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_residence_fees', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Residence Lots : ', 'apimo'); ?></label>

            <input type="text" name="apimo_residence_lots"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_residence_lots', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Floor Value : ', 'apimo'); ?></label>

            <input type="text" name="apimo_floor_value"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_floor_value', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Floor Levels : ', 'apimo'); ?></label>

            <input type="text" name="apimo_floor_levels"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_floor_levels', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Floors : ', 'apimo'); ?></label>

            <input type="text" name="apimo_floor_floors"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_floor_floors', true)); ?>" />

        </div>



        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Available At : ', 'apimo'); ?></label>

            <input type="text" name="apimo_available_at"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_available_at', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Delivered At : ', 'apimo'); ?></label>

            <input type="text" name="apimo_delivered_at"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_delivered_at', true)); ?>" />

        </div>

        <div class="detail_row">

            <label class="row_label"><?php _e('Enter ID : ', 'apimo'); ?></label>

            <input type="text" name="apimo_id"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_id', true)); ?>" />

        </div>



        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Create Date : ', 'apimo'); ?></label>

            <input type="text" name="apimo_created_at"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_created_at', true)); ?>" />

        </div>



        <div class="detail_row">

            <label class="row_label"><?php _e('Enter Update Date : ', 'apimo'); ?></label>

            <input type="text" name="apimo_updated_at"
                value="<?php echo esc_html(get_post_meta($post_ID, 'apimo_updated_at', true)); ?>" />

        </div>



        <?php if (get_post_meta($post_ID, 'apimo_regulations', true)) { ?>

        <div class="detail_row">

            <pre>

                <php print_r(get_post_meta($post_ID,'apimo_regulations',true)); ?>

                </pre>

        </div>

        <?php } ?>

    </div>

</div>

<?php

}



add_action('save_post', 'save_property_details');

function save_property_details($post_id)
{

    $post = get_post($post_id);

    if ($post->post_type == APIMO_POST_TYPE) {




        if (isset($_POST['apimo_template_type']) && !empty($_POST['apimo_template_type'])) {
            $apimo_template_type = sanitize_text_field($_POST['apimo_template_type']);
            update_post_meta($post_id, 'apimo_template_type', $apimo_template_type);
        }




        if (isset($_POST['apimo_agency']) && !empty($_POST['apimo_agency'])) {

            $apimo_agency = sanitize_text_field($_POST['apimo_agency']);
            update_post_meta($post_id, 'apimo_agency', $apimo_agency);

        }


        if (isset($_POST['apimo_brand']) && !empty($_POST['apimo_brand'])) {
            $apimo_brand = sanitize_text_field($_POST['apimo_brand']);
            update_post_meta($post_id, 'apimo_brand', $apimo_brand);
        }


        if (isset($_POST['apimo_user_id']) && !empty($_POST['apimo_user_id']) && is_numeric($_POST['apimo_user_id'])) {
            $apimo_user_id = sanitize_text_field($_POST['apimo_user_id']);
            update_post_meta($post_id, 'apimo_user_id', $apimo_user_id);
        }



        if (isset($_POST['apimo_type']) && !empty($_POST['apimo_type']) && is_string($_POST['apimo_type'])) {
            $apimo_type = sanitize_text_field($_POST['apimo_type']);
            update_post_meta($post_id, 'apimo_type', $apimo_type);
        }



        if (isset($_POST['apimo_subtype']) && !empty($_POST['apimo_subtype']) && is_string($_POST['apimo_subtype'])) {
            $apimo_subtype = sanitize_text_field($_POST['apimo_subtype']);
            update_post_meta($post_id, 'apimo_subtype', $apimo_subtype);
        }




        if (isset($_POST['apimo_block_name']) && !empty($_POST['apimo_block_name']) && is_string($_POST['apimo_block_name'])) {
            $apimo_block_name = sanitize_text_field($_POST['apimo_block_name']);
            update_post_meta($post_id, 'apimo_block_name', $apimo_block_name);
        }
        if (isset($_POST['apimo_lot_reference']) && !empty($_POST['apimo_lot_reference']) && is_string($_POST['apimo_lot_reference'])) {
            $apimo_lot_reference = sanitize_text_field($_POST['apimo_lot_reference']);
            update_post_meta($post_id, 'apimo_lot_reference', $apimo_lot_reference);
        }
        if (isset($_POST['apimo_address']) && !empty($_POST['apimo_address']) && is_string($_POST['apimo_address'])) {
            $apimo_address = sanitize_text_field($_POST['apimo_address']);
            update_post_meta($post_id, 'apimo_address', $apimo_address);
        }
        if (isset($_POST['apimo_address_more']) && !empty($_POST['apimo_address_more']) && is_string($_POST['apimo_address_more'])) {
            $apimo_address_more = sanitize_text_field($_POST['apimo_address_more']);
            update_post_meta($post_id, 'apimo_address_more', $apimo_address_more);
        }



        if (isset($_POST['apimo_publish_address']) && !empty($_POST['apimo_publish_address'])) {
            $apimo_publish_address = sanitize_text_field($_POST['apimo_publish_address']);
            update_post_meta($post_id, 'apimo_publish_address', $apimo_publish_address);
        }
        if (isset($_POST['apimo_longitude']) && !empty($_POST['apimo_longitude'])) {
            $apimo_longitude = sanitize_text_field($_POST['apimo_longitude']);
            update_post_meta($post_id, 'apimo_longitude', $apimo_longitude);
        }
        if (isset($_POST['apimo_latitude']) && !empty($_POST['apimo_latitude'])) {
            $apimo_latitude = sanitize_text_field($_POST['apimo_latitude']);
            update_post_meta($post_id, 'apimo_latitude', $apimo_latitude);
        }
        if (isset($_POST['apimo_radius']) && !empty($_POST['apimo_radius'])) {
            $apimo_radius = sanitize_text_field($_POST['apimo_radius']);
            update_post_meta($post_id, 'apimo_radius', $apimo_radius);
        }



        if (isset($_POST['apimo_rooms']) && !empty($_POST['apimo_rooms']) && is_numeric($_POST['apimo_rooms'])) {
            $apimo_rooms = intval($_POST['apimo_rooms']);
            update_post_meta($post_id, 'apimo_rooms', $apimo_rooms);
        }
        if (isset($_POST['apimo_bedrooms']) && !empty($_POST['apimo_bedrooms']) && is_numeric($_POST['apimo_bedrooms'])) {
            $apimo_bedrooms = intval($_POST['apimo_bedrooms']);
            update_post_meta($post_id, 'apimo_bedrooms', $apimo_bedrooms);
        }
        if (isset($_POST['apimo_sleeps']) && !empty($_POST['apimo_sleeps']) && is_numeric($_POST['apimo_sleeps'])) {
            $apimo_sleeps = intval($_POST['apimo_sleeps']);
            update_post_meta($post_id, 'apimo_sleeps', $apimo_sleeps);
        }
        if (isset($_POST['apimo_price']) && !empty($_POST['apimo_price']) && is_numeric($_POST['apimo_price'])) {
            $apimo_price = sanitize_text_field($_POST['apimo_price']);
            update_post_meta($post_id, 'apimo_price', $apimo_price);
        }


        if (isset($_POST['apimo_gallery_images']) && !empty($_POST['apimo_gallery_images']) && is_array($_POST['apimo_gallery_images'])) {

            $apimo_gallery_images = array_map('sanitize_text_field', $_POST['apimo_gallery_images']);
            update_post_meta($post_id, 'apimo_gallery_images', $apimo_gallery_images);

        }


        if (isset($_POST['apimo_area_unit']) && !empty($_POST['apimo_area_unit'])) {
            $apimo_area_unit = sanitize_text_field($_POST['apimo_area_unit']);
            update_post_meta($post_id, 'apimo_area_unit', $apimo_area_unit);
        }
        if (isset($_POST['apimo_area_value']) && !empty($_POST['apimo_area_value']) && is_numeric($_POST['apimo_area_value'])) {
            $apimo_area_value = sanitize_text_field($_POST['apimo_area_value']);
            update_post_meta($post_id, 'apimo_area_value', $apimo_area_value);
        }
        if (isset($_POST['apimo_area_total']) && !empty($_POST['apimo_area_total']) && is_numeric($_POST['apimo_area_total'])) {
            $apimo_area_total = intval($_POST['apimo_area_total']);
            update_post_meta($post_id, 'apimo_area_total', $apimo_area_total);
        }


        if (isset($_POST['apimo_area_weighted']) && !empty($_POST['apimo_area_weighted'])) {
            $apimo_area_weighted = sanitize_text_field($_POST['apimo_area_weighted']);
            update_post_meta($post_id, 'apimo_area_weighted', $apimo_area_weighted);
        }
        if (isset($_POST['apimo_price_hide']) && !empty($_POST['apimo_price_hide']) && is_bool($_POST['apimo_price_hide'])) {
            // $apimo_price_hide = $_POST['apimo_price_hide'];
            $apimo_price_hide = sanitize_text_field($_POST['apimo_price_hide']);
            update_post_meta($post_id, 'apimo_price_hide', $apimo_price_hide);
        }



        if (isset($_POST['apimo_price_currency']) && !empty($_POST['apimo_price_currency'])) {
            $apimo_price_currency = sanitize_text_field($_POST['apimo_price_currency']);
            update_post_meta($post_id, 'apimo_price_currency', $apimo_price_currency);
        }
        if (isset($_POST['apimo_construction_year']) && !empty($_POST['apimo_construction_year']) && is_numeric($_POST['apimo_construction_year'])) {
            $apimo_construction_year = sanitize_text_field($_POST['apimo_construction_year']);
            update_post_meta($post_id, 'apimo_construction_year', $apimo_construction_year);
        }

        if (isset($_POST['apimo_renovation_year']) && !empty($_POST['apimo_renovation_year']) && is_numeric($_POST['apimo_renovation_year'])) {
            $apimo_renovation_year = sanitize_text_field($_POST['apimo_renovation_year']);
            update_post_meta($post_id, 'apimo_renovation_year', $apimo_renovation_year);
        }
        if (isset($_POST['apimo_renovation_cost']) && !empty($_POST['apimo_renovation_cost']) && is_numeric($_POST['apimo_renovation_cost'])) {
            $apimo_renovation_cost = sanitize_text_field($_POST['apimo_renovation_cost']);
            update_post_meta($post_id, 'apimo_renovation_cost', $apimo_renovation_cost);
        }


        if (isset($_POST['apimo_residence_period']) && !empty($_POST['apimo_residence_period'])) {
            $apimo_residence_period = sanitize_text_field($_POST['apimo_residence_period']);
            update_post_meta($post_id, 'apimo_residence_period', $apimo_residence_period);
        }
        if (isset($_POST['apimo_residence_fees']) && !empty($_POST['apimo_residence_fees']) && is_numeric($_POST['apimo_residence_fees'])) {
            $apimo_residence_fees = sanitize_text_field($_POST['apimo_residence_fees']);
            update_post_meta($post_id, 'apimo_residence_fees', $apimo_residence_fees);
        }



        if (isset($_POST['apimo_residence_lots']) && !empty($_POST['apimo_residence_lots']) && is_numeric($_POST['apimo_residence_lots'])) {
            $apimo_residence_lots = sanitize_text_field($_POST['apimo_residence_lots']);
            update_post_meta($post_id, 'apimo_residence_lots', $apimo_residence_lots);
        }
        if (isset($_POST['apimo_floor_value']) && !empty($_POST['apimo_floor_value']) && is_numeric($_POST['apimo_floor_value'])) {
            $apimo_floor_value = sanitize_text_field($_POST['apimo_floor_value']);
            update_post_meta($post_id, 'apimo_floor_value', $apimo_floor_value);
        }




        if (isset($_POST['apimo_floor_value']) && !empty($_POST['apimo_floor_value']) && is_numeric($_POST['apimo_floor_value'])) {
            $apimo_floor_value = sanitize_text_field($_POST['apimo_floor_value']);
            update_post_meta($post_id, 'apimo_floor_levels', $apimo_floor_value);
        }

        if (isset($_POST['apimo_floor_floors']) && !empty($_POST['apimo_floor_floors'])) {
            $apimo_floor_floors = sanitize_text_field($_POST['apimo_floor_floors']);
            if (is_numeric($apimo_floor_floors)) {

                update_post_meta($post_id, 'apimo_floor_floors', $apimo_floor_floors);
            }
        }


        if (isset($_POST['apimo_available_at']) && !empty($_POST['apimo_available_at'])) {
            $apimo_available_at = sanitize_text_field($_POST['apimo_available_at']);
            update_post_meta($post_id, 'apimo_available_at', $apimo_available_at);
        }

        if (isset($_POST['apimo_delivered_at']) && !empty($_POST['apimo_delivered_at'])) {
            $apimo_delivered_at = sanitize_text_field($_POST['apimo_delivered_at']);
            update_post_meta($post_id, 'apimo_delivered_at', $apimo_delivered_at);
        }


        if (isset($_POST['apimo_id']) && !empty($_POST['apimo_id'])) {
            $apimo_id = sanitize_text_field($_POST['apimo_id']);
            if (is_numeric($apimo_id)) {
                update_post_meta($post_id, 'apimo_id', $apimo_id);
            }
        }

        if (isset($_POST['apimo_created_at']) && !empty($_POST['apimo_created_at'])) {
            $apimo_created_at = sanitize_text_field($_POST['apimo_created_at']);
            update_post_meta($post_id, 'apimo_created_at', $apimo_created_at);
        }

        if (isset($_POST['apimo_updated_at']) && !empty($_POST['apimo_updated_at'])) {
            $apimo_updated_at = sanitize_text_field($_POST['apimo_updated_at']);
            update_post_meta($post_id, 'apimo_updated_at', $apimo_updated_at);
        }
    }

}
<?php

function search_property_shortcode($attrs) {
    ob_start(); // Start output buffering

    


    $normal_filter = isset($attrs['normal_filter']) ? sanitize_text_field($attrs['normal_filter']) : 'category_filter,subtype_filter,number_of_bedrooms,price_range,property_areas';
    if (is_string($normal_filter) && strpos($normal_filter, ',') !== false) {
        $apimo_filter = array_map('esc_attr', explode(',', $normal_filter));
    } else {
        $apimo_filter = array();
    }
    $apimo_data_id = rand();

     $advanced_filter = isset($attrs['advance_filter']) ? sanitize_text_field($attrs['advance_filter']) : 'garden,terrace,balcony,garage_box,parking_space';

    if (is_string($advanced_filter) && strpos($advanced_filter, ',') !== false) {
        $advance_filter_data = array_map('esc_attr', explode(',', $advanced_filter));
    } else {
        $advance_filter_data = array();
    }
    


    




    if (!empty($advance_filter_data)) {

        $apimo_filter['advance'] = $advance_filter_data;

    }

    ?>
    <?php if (!empty($apimo_filter)) :  ?>

            <div class="filter-container">
                
                <input type="hidden" id="page_redirect" value="<?php echo $attrs['search_page'] ?>">

                <div class="filter-mobile-toggle">

                    <svg id="Modalità_Isolamento" data-name="Modalità Isolamento" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180.48 212.8">

                        <path d="M364,278.8a19,19,0,0,1,3.46-10.05l54.05-69.49c3.8-4.89,1.85-8.86-4.26-8.86H282.75c-6.16,0-8,4-4.26,8.86l54.05,69.49A19,19,0,0,1,336,278.8v76.78a14,14,0,1,0,28,0Zm16.8,76.78a30.8,30.8,0,1,1-61.6,0V278.8c0,.2-54-69.23-54-69.23-12.32-15.84-2.7-36,17.52-36h134.5c20.14,0,29.87,20.09,17.52,36l-54,69.49c.09-.14.08,76.52.08,76.52Z" transform="translate(-259.76 -173.6)"></path>

                    </svg>

                    <p><?php _e('Filter the properties', 'apimo'); ?></p>

                </div>
                <?php 
                    $filter_none = '';
                    if(isset($attrs['post_limit'])){
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

                                                <option value=""><?php _e('Select Category', 'apimo') ?></option>

                                                <?php $terms_country = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_category',

                                                    'hide_empty' => false

                                                ));

                                                foreach ($terms_country as $term_country) :

                                                ?>

                                                    <option value="<?php echo esc_attr($term_country->term_id); ?>"><?php echo esc_html($term_country->name); ?></option>

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

                                                <?php $terms_country = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_subtype',

                                                    'hide_empty' => false

                                                ));

                                                foreach ($terms_country as $term_country) :

                                                ?>

                                                    <option value="<?php echo esc_attr($term_country->term_id); ?>"><?php echo esc_html($term_country->name); ?></option>

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

                                        <?php echo _e('Location', 'apimo'); ?>

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

                                                <?php $terms_country = $terms = get_terms(array(

                                                    'taxonomy' => 'country',

                                                    'hide_empty' => false

                                                ));

                                                foreach ($terms_country as $term_country) :

                                                ?>

                                                    <option value="<?php echo esc_attr($term_country->term_id); ?>"><?php echo esc_html($term_country->name); ?></option>

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

                                                <?php $terms_region = $terms = get_terms(array(

                                                    'taxonomy' => 'region',

                                                    'hide_empty' => false

                                                ));

                                                foreach ($terms_region as $term_region) :

                                                ?>

                                                    <option value="<?php echo esc_attr($term_region->term_id); ?>"><?php echo esc_html($term_region->name); ?></option>

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

                                                <?php $terms_region = $terms = get_terms(array(

                                                    'taxonomy' => 'city',

                                                    'hide_empty' => false,

                                                    'parent' => 0

                                                ));

                                                foreach ($terms_region as $term_region) :

                                                ?>

                                                    <option value="<?php echo esc_attr($term_region->term_id); ?>"><?php echo esc_html($term_region->name); ?></option>

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

                                                <?php $terms_region = $terms = get_terms(array(

                                                    'taxonomy' => 'district',

                                                    'hide_empty' => false

                                                ));

                                                foreach ($terms_region as $term_region) :

                                                ?>

                                                    <option value="<?php echo esc_attr($term_region->term_id); ?>"><?php echo esc_html($term_region->name); ?></option>

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





                        <?php if (in_array('price_range', $apimo_filter)) : // Price ?>

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

                                                <input type="number" min="0" name="price_range_min" data-id="price_range_min" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('From', 'apimo') ?>">

                                            </div>

                                            <div class="range-to">

                                                <input type="number" min="0" name="price_range_max" data-id="price_range_max" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('To', 'apimo') ?>">

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

                                                <input type="number" min="0" name="property_areas_min" data-id="property_areas_min" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('From', 'apimo') ?>">

                                            </div>

                                            <div class="range-to">

                                                <input type="number" min="0" name="property_areas_max" data-id="property_areas_max" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('To', 'apimo') ?>">

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

                                            <div class="label"><?php _e('Comparment', 'apimo'); ?></div>

                                            <div class="qty-buttons">

                                                <button class="qty qty-minus apimo-qty-minus">-</button>

                                                <input type="number" min="0" name="number_of_rooms" data-id="number_of_rooms" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('0', 'apimo') ?>">

                                                <button class="qty qty-plus apimo-qty-plus">+</button>

                                            </div>

                                        </div>

                                    <?php endif; ?>

                                    <?php if (in_array('number_of_bedrooms', $apimo_filter)) : ?>

                                        <div class="filter-item-qty apimo-archive-filter apimo_number_of_bedrooms" data-id="number_of_bedrooms">

                                            <div class="label"><?php _e('Bathroom', 'apimo'); ?></div>

                                            <div class="qty-buttons">

                                                <button class="qty qty-minus apimo-qty-minus">-</button>

                                                <input type="number" min="0" name="number_of_bedrooms" data-id="number_of_bedrooms" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_text" placeholder="<?php _e('0', 'apimo') ?>">

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

                                        foreach ($apimo_filter['advance'] as $advance_filter) :

                                            if ($advance_filter == 'garden') :

                                                $term = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 49,

                                                    'hide_empty' => false

                                                ));

                                        ?>

                                                <div class="apimo-archive-filter apimo_advance_garden" data-id="advance_garden">

                                                    <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="advance_garden" id="apimo_garden" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

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

                                                $term = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 18,

                                                    'hide_empty' => false

                                                ));

                                            ?>

                                                <div class="apimo-archive-filter apimo_advance_garden" data-id="apimo_terrace">

                                                    <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_terrace" id="apimo_terrace" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

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

                                                $term = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 43,

                                                    'hide_empty' => false

                                                ));

                                            ?>

                                                <div class="apimo-archive-filter apimo_advance_balcony" data-id="apimo_balcony">

                                                    <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_balcony" id="apimo_balcony" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

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

                                                $term = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 4,

                                                    'hide_empty' => false

                                                ));

                                            ?>

                                                <div class="apimo-archive-filter apimo_advance_garage_box" data-id="apimo_garage_box">

                                                    <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_garage_box" id="apimo_garage_box" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

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

                                                $term = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 5,

                                                    'hide_empty' => false

                                                ));

                                            ?>

                                                <div class="apimo-archive-filter apimo_advance_parking" data-id="apimo_parking">

                                                    <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_parking" id="apimo_parking" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

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

                                                $term = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_areas',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 6,

                                                    'hide_empty' => false

                                                ));

                                            ?>

                                                <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_cellar">

                                                    <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[areas][]" data-id="apimo_cellar" id="apimo_cellar" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

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

                                                $term = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_service',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 11,

                                                    'hide_empty' => false

                                                ));

                                            ?>

                                                <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_pool">

                                                    <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[service][]" data-id="apimo_pool" id="apimo_pool" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

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

                                                $term = $terms = get_terms(array(

                                                    'taxonomy' => 'apimo_service',

                                                    'meta_key' => 'apimo_term_id',

                                                    'meta_value' => 6,

                                                    'hide_empty' => false

                                                ));

                                            ?>

                                                <div class="apimo-archive-filter apimo_advance_cellar" data-id="apimo_lift">

                                                    <input type="checkbox" value="<?php echo esc_attr($term[0]->term_id); ?>" name="apimo_advance[service][]" data-id="apimo_lift" id="apimo_lift" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="apimo_input apimo_filter_input apimo_input_checkbox">

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
                        

                        <div class="filter-item">
                            <button class="btn btn-primary search_shortcode_buttton">
                                SEARCH
                            </button>
                        </div>
                                        
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

                                        <input type="radio" id="relevance" name="order-by-properties" value="relevance" checked>

                                        <label for="relevance"><?php _e('Relevance', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="price_low_to_hig" name="order-by-properties" value="price_low_to_high">

                                        <label for="price_low_to_hig"><?php _e('Rising price', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="price_high_to_low" name="order-by-properties" value="price_high_to_low">

                                        <label for="price_high_to_low"><?php _e('Descending price', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="area_low_to_high" name="order-by-properties" value="area_low_to_high">

                                        <label for="area_low_to_high"><?php _e('Rising area', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="price_low_to_hig" name="order-by-properties" value="area_high_to_low">

                                        <label for="area_high_to_low"><?php _e('Descending area', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="bedrooms_low_to_high" name="order-by-properties" value="bedrooms_low_to_high">

                                        <label for="bedrooms_low_to_high"><?php _e('Bedrooms increasing', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="bedrooms_high_to_low" name="order-by-properties" value="bedrooms_high_to_low">

                                        <label for="bedrooms_high_to_low"><?php _e('Bedrooms descending', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="rooms_low_to_high" name="order-by-properties" value="rooms_low_to_high">

                                        <label for="rooms_low_to_high"><?php _e('Comparment increasing', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="rooms_high_to_low" name="order-by-properties" value="rooms_high_to_low">

                                        <label for="rooms_high_to_low"><?php _e('Comparment descending', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="created_at_low_to_high" name="order-by-properties" value="created_at_low_to_high">

                                        <label for="created_at_low_to_high"><?php _e('Creation date: from oldest to newest', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="created_at_high_to_low" name="order-by-properties" value="created_at_high_to_low">

                                        <label for="created_at_high_to_low"><?php _e('Creation date: from newest to oldest', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="updated_at_low_to_high" name="order-by-properties" value="updated_at_low_to_high">

                                        <label for="updated_at_low_to_high"><?php _e('Update date: from oldest to newest', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="updated_at_high_to_low" name="order-by-properties" value="updated_at_high_to_low">

                                        <label for="updated_at_high_to_low"><?php _e('Update date: from newest to oldest', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="published_at_low_to_high" name="order-by-properties" value="published_at_low_to_high">

                                        <label for="published_at_low_to_high"><?php _e('Publish date: from oldest to newest', 'apimo'); ?></label>

                                    </div>

                                    <div class="order-by-radio-item">

                                        <input type="radio" id="published_at_high_to_low" name="order-by-properties" value="published_at_high_to_low">

                                        <label for="published_at_high_to_low"><?php _e('Publish date: from newest to oldest', 'apimo'); ?></label>

                                    </div>

                                </div>

                                <div class="apply-filter">

                                    <button type="button" data-unique-id="<?php echo esc_attr($apimo_data_id); ?>" class="btn-apply  apimo-apply-filter"><?php _e('Apply order', 'apimo') ?></button>

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

        <?php endif; ?>
    <?php 
    return ob_get_clean(); // Return the buffered content
}

add_shortcode('search_property', 'search_property_shortcode');

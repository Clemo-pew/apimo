<?php

global $UNIT_AREA;

$metas = get_post_meta(get_the_ID());

//price 

// echo "<pre>";
// if (isset($metas['apimo_price_data']) && is_array($metas['apimo_price_data'])) {
//     foreach ($metas['apimo_price_data'] as $priceData) {
//         // Check if the data is serialized
//         if (is_string($priceData) && preg_match('/^O:\d+:"stdClass"/', $priceData)) {
//             // Unserialize the object
//             $priceData = unserialize($priceData);
//         }

//         // Check if we have an object now
//         if (is_object($priceData)) {
//             foreach ($priceData as $key => $value) {
//                 if (is_object($value)) {
//                     echo ucfirst($key) . ":\n";
//                     foreach ($value as $subKey => $subValue) {
//                         echo "  " . ucfirst($subKey) . ": " . ($subValue !== null ? $subValue : "N/A") . "\n";
//                     }
//                 } else {
//                     echo ucfirst($key) . ": " . ($value !== null ? $value : "N/A") . "\n";
//                 }
//             }
//         } else {
//             echo "Invalid price data format.\n";
//         }
//         echo "\n";
//     }
// } else {
//     echo "No valid price data available.\n";
// }
// echo "</pre>";



$thumbnail = get_the_post_thumbnail_url(get_the_ID());
//echo '<pre>';
$city_term = wp_get_post_terms(get_the_ID(), 'city');
//print_r($city_term);
// if (count($city_term) > 1) {
//     if ($city_term[0]->parent == 0) {
//         $city = $city_term[0]->name . ' - ' . $city_term[1]->name;
//     } else {
//         $city = $city_term[1]->name . ' - ' . $city_term[0]->name;
//     }
// } else {
// $city_term = wp_get_post_terms(get_the_ID(), 'city');
$city = $city_term[0]->name;

$zip_code = get_term_meta($city_term[0]->term_id, 'zip_code', true);

$city = $city . ' - ' . $zip_code;
// }



$external_areas = wp_get_post_terms(get_the_ID(), 'apimo_areas');

$subtype = "";

$subtypes = wp_get_post_terms(get_the_ID(), 'apimo_subtype');

if (isset($subtypes[0])) {
    $subtype = $subtypes[0]->name;
}

$apimo_archive_settings = get_option('apimo_style_archive');

$apimo_archive_settings['archive_display_option'] = ($apimo_archive_settings['archive_display_option']) ? $apimo_archive_settings['archive_display_option'] : array();





// echo '<pre>';

// print_r($apimo_archive_settings);

// echo '</pre>';

$gallery_images = maybe_unserialize($metas['apimo_gallery_images'][0]);



?>





<div class="apimo-properties-item Product-block">

    <div class="Pro-Image">

        <?php if (!isset($apimo_archive_settings['gallery_display_slider']) && !isset($apimo_archive_settings['gallery_display_lighbox'])) :



        ?>

            <div class="apimo-propery-image apimo-property-thumb  ">

				
                <div class="apimo-image">



                    <img src="<?php echo esc_url($thumbnail); ?>" class="single-apimo-img" alt="ccc">





                </div>

            </div>

        <?php



        elseif ($apimo_archive_settings['gallery_display_slider'] == 1) :

            $rand = rand(); ?>

            <div class="apimo-propery-images-archive apimo-display apimo-slider-image-<?php /*echo count($gallery_images); */ if (is_array($gallery_images) || is_object($gallery_images)) {
                                                                                            echo count($gallery_images);
                                                                                        } ?>">



                <?php if (isset($apimo_archive_settings['gallery_display_lighbox']) && $apimo_archive_settings['gallery_display_lighbox'] == 1) :

                ?>

                    <div class="apimo-image">

                        <div class="apimo-image-slide-wrapper">

                            <a data-fslightbox="gallery_<?php echo esc_attr(get_the_ID() . $rand); ?>" href="<?php echo esc_url($thumbnail) ?>">

                                <img src="<?php echo esc_url($thumbnail); ?>" class="img-fluid" alt="">

                            </a>

                        </div>



                    </div>

                <?php

                else :

                ?>

                    <div class="apimo-image">

                        <div class="apimo-image-slide-wrapper">
                            <?php

                            if ($thumbnail == "") {
                                $src = plugin_dir_url(dirname(__FILE__)) . 'assets/images/noimage.png';
                            } else {
                                $src = $thumbnail;
                            }

                            ?>
                            <img src="<?php echo esc_url($src); ?>" class="single-apimo-img" alt="">

                        </div>



                    </div>

                <?php

                endif;

                ?>



                <?php

                if (is_array($gallery_images) || is_object($gallery_images)) {
                    foreach ($gallery_images as $gallery_image) {

                        if (isset($apimo_archive_settings['gallery_display_lighbox']) && $apimo_archive_settings['gallery_display_lighbox'] == 1) :

                ?>

                            <div class="apimo-image">

                                <a data-fslightbox="gallery_<?php echo esc_attr(get_the_ID() . $rand); ?>" href="<?php echo esc_url($gallery_image) ?>">

                                    <img src="<?php echo esc_url($gallery_image); ?>" class="single-apimo-img" alt="">

                                </a>

                            </div>

                        <?php

                        else :

                        ?>

                            <div class="apimo-image">

                                <img src="<?php echo esc_url($gallery_image); ?>" class="single-apimo-img" alt="">

                            </div>

                        <?php

                        endif;

                        ?>

                <?php

                    }
                }

                ?>

            </div>



            <?php

            ?>

        <?php elseif (isset($apimo_archive_settings['gallery_display_lighbox']) && $apimo_archive_settings['gallery_display_lighbox'] == 1) :

            $rand = rand(); ?>

            <div class="apimo-propery-image apimo-property-thumb light-box-only ">

                <div class="apimo-image">

                    <a data-fslightbox="gallery_<?php echo esc_attr(get_the_ID() . $rand); ?>" href="<?php echo esc_url($thumbnail) ?>">

                        <img src="<?php echo esc_url($thumbnail); ?>" class="img-fluid" alt="">

                    </a>

                </div>

            </div>

            <div style="display:none">

                <?php foreach ($gallery_images as $gallery_image) :

                ?>

                    <a data-fslightbox="gallery_<?php echo esc_attr(get_the_ID() . $rand); ?>" href="<?php echo esc_url($gallery_image) ?>">

                        <img src="<?php echo esc_url($gallery_image) ?>" />

                    </a>

                <?php

                endforeach;  ?>

            </div>



        <?php endif; ?>

        <?php if ($subtype) : ?>

            <div class="Pro-category">

                <span><?php echo esc_html($subtype); ?></span>

            </div>

        <?php endif; ?>

        <?php
        // foreach (unserialize($metas['apimo_content'][0]) as $language) {

        //     if ($language->language == 'it') {

        //         if ($language->hook != '' || !empty($language->hook)) {

        //             echo '<div class="Pro-category ProCategory2">';

        //             echo '<span>' . nl2br($language->hook) . '</span>';

        //             echo '</div>';
        //         }
        //     }
        // } 

        if (isset($metas['apimo_content'][0])) {
            $contents = unserialize($metas['apimo_content'][0]);
            if (is_array($contents)) {
                foreach ($contents as $language) {
                    if ($language->language == 'it') {
                        if (!empty($language->hook)) {
                            echo '<div class="Pro-category ProCategory2">';
                            echo '<span>' . nl2br($language->hook) . '</span>';
                            echo '</div>';
                        }
                    }
                }
            }
        }

        ?>

    </div>





    <a class="Pro-content" href="<?php echo get_permalink(); ?>">

        <div class="Pro-top-info">

            <div class="Pro-address">

                <?php if ($metas['apimo_publish_address'][0] === '1') : ?>

                    <svg xmlns="http://www.w3.org/2000/svg" width="12.783" height="15.979" viewBox="0 0 12.783 15.979">

                        <g id="noun_Location_94613" transform="translate(356 -253.3)">

                            <path id="Path_11" data-name="Path 11" d="M-349.608,253.3A6.388,6.388,0,0,0-356,259.692c0,6.392,6.392,9.588,6.392,9.588s6.392-3.018,6.392-9.588A6.388,6.388,0,0,0-349.608,253.3Zm0,9.588a3.205,3.205,0,0,1-3.2-3.2,3.205,3.205,0,0,1,3.2-3.2,3.205,3.205,0,0,1,3.2,3.2A3.205,3.205,0,0,1-349.608,262.888Z" transform="translate(0 0)" fill="#6a6a6a" />

                        </g>

                    </svg>

                    <span class="value"><?php if ($city) {

                                            echo esc_html($city);
                                        } ?><?php if ($metas['apimo_address'][0]) {

                                                echo ' - ' . esc_html($metas['apimo_address'][0]);
                                            } ?></span>

                <?php else : ?>

                    <svg xmlns="http://www.w3.org/2000/svg" width="12.783" height="15.979" viewBox="0 0 12.783 15.979">

                        <g id="noun_Location_94613" transform="translate(356 -253.3)">

                            <path id="Path_11" data-name="Path 11" d="M-349.608,253.3A6.388,6.388,0,0,0-356,259.692c0,6.392,6.392,9.588,6.392,9.588s6.392-3.018,6.392-9.588A6.388,6.388,0,0,0-349.608,253.3Zm0,9.588a3.205,3.205,0,0,1-3.2-3.2,3.205,3.205,0,0,1,3.2-3.2,3.205,3.205,0,0,1,3.2,3.2A3.205,3.205,0,0,1-349.608,262.888Z" transform="translate(0 0)" fill="#6a6a6a" />

                        </g>

                    </svg>

                    <span class="value"><?php if ($city) {

                                            echo esc_html($city);
                                        } ?></span>

                <?php endif; ?>

            </div>

            <div class="Pro-name">

                <h3><?php echo get_the_title(); ?></h3>

            </div>



            <?php if ($grid_desktop == 'column-desktop-2') :

                foreach (unserialize($metas['apimo_content'][0]) as $language) {

                    if ($language->language == 'it') {

            ?>

                        <div class="apimo-description-card">

                            <p><?php echo nl2br(($language->comment_full != null || !empty($language->comment_full)) ? $language->comment_full : $language->comment); ?></p>

                        </div>

            <?php

                    }
                }

            endif;

            ?>

            <?php if ($apimo_archive_settings['hideicon'] != 'hideicon') : ?>

                <?php $classIconBlock = "with-icon"; ?>

            <?php else : ?>

                <?php $classIconBlock = "without-icon"; ?>

            <?php endif; ?>

            <div class="Pro-description Flex-col <?php echo esc_attr($classIconBlock); ?>">



                <?php if ($apimo_archive_settings['hideicon'] != 'hideicon') : ?>

                    <!-- With Icon -->

                    <?php if (in_array('number_of_rooms', $apimo_archive_settings['archive_display_option'])) { ?>

                        <div class="Pro-meta">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.511 24.511">

                                <path id="Path_12" data-name="Path 12" d="M32.06,15.821H34.2a.306.306,0,0,0,.306-.306V10.306A.306.306,0,0,0,34.2,10h-23.9a.306.306,0,0,0-.306.306V34.2a.306.306,0,0,0,.306.306H34.2a.306.306,0,0,0,.306-.306V19.5a.613.613,0,1,0-1.226,0v2.451H29.3a.613.613,0,0,0,0,1.226H32.06v8.579h-6.1V26.295a.613.613,0,1,0-1.226,0v5.459H13.064V23.175h2.145v2.757a.613.613,0,0,0,1.226,0V23.175h9.8a.613.613,0,0,0,0-1.226h-.306V21.03a.613.613,0,0,0-1.226,0v.919H13.064V12.757H24.706v4.9a.613.613,0,0,0,1.226,0v-.306h3.677a.613.613,0,1,0,0-1.226H25.932v-3.37h5.821v2.757A.306.306,0,0,0,32.06,15.821Z" transform="translate(-10 -10)" fill="#6a6a6a" />

                            </svg>

                            <span class="value"><?php if ($metas['apimo_rooms'][0]) {

                                                    echo esc_html($metas['apimo_rooms'][0]);
                                                } else {

                                                    echo 0;
                                                } ?> <?php _e('Rooms', 'apimo'); ?></span>

                        </div>

                    <?php } ?>

                    <?php

                    if (in_array('bathroom', $apimo_archive_settings['archive_display_option'])) { ?>

                        <div class="Pro-meta">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.608 24.511">

                                <g id="noun_Bath_4032349" transform="translate(0)">

                                    <path id="Path_1" data-name="Path 1" d="M25.026,13.963H4.755V3.213A2.252,2.252,0,0,1,7,.961a1.5,1.5,0,0,1,1.08.44l.475.479A2.535,2.535,0,0,0,8.37,5.155l.2.26a.383.383,0,0,0,.295.146.341.341,0,0,0,.222-.077L12.633,2.8a.383.383,0,0,0,.046-.529l-.2-.257A2.524,2.524,0,0,0,9.328,1.3L8.753.724A2.455,2.455,0,0,0,7,0,3.217,3.217,0,0,0,3.79,3.213V17.46a5.45,5.45,0,0,0,5.059,5.431h0v1.237a.383.383,0,1,0,.766,0V22.906h9.957v1.222a.383.383,0,1,0,.766,0V22.891h0A5.45,5.45,0,0,0,25.4,17.46V14.335A.383.383,0,0,0,25.026,13.963Z" transform="translate(-3.79 0)" fill="#6a6a6a" />

                                    <path id="Path_2" data-name="Path 2" d="M20.061,17.1a.479.479,0,0,0,.207-.306.463.463,0,0,0-.073-.36l-.421-.632a.483.483,0,0,0-.666-.134.471.471,0,0,0-.2.306.479.479,0,0,0,.069.36l.421.632a.486.486,0,0,0,.4.214A.46.46,0,0,0,20.061,17.1Z" transform="translate(-13.109 -9.62)" fill="#6a6a6a" />

                                    <path id="Path_3" data-name="Path 3" d="M21.026,23.82a.486.486,0,0,0,.437.272.484.484,0,0,0,.452-.318.49.49,0,0,0-.019-.383l-.326-.686a.483.483,0,0,0-.437-.276.484.484,0,0,0-.452.318.49.49,0,0,0,.019.383Z" transform="translate(-14.194 -13.84)" fill="#6a6a6a" />

                                    <path id="Path_4" data-name="Path 4" d="M23.484,30.893a.479.479,0,0,0,.448.3.484.484,0,0,0,.44-.291.456.456,0,0,0,0-.383l-.28-.709a.479.479,0,0,0-.448-.3.467.467,0,0,0-.176.034.46.46,0,0,0-.264.257.471.471,0,0,0,0,.383Z" transform="translate(-15.744 -18.208)" fill="#6a6a6a" />

                                    <path id="Path_5" data-name="Path 5" d="M23.418,14.347a.479.479,0,0,0,.23-.061.493.493,0,0,0,.188-.67l-.383-.666a.475.475,0,0,0-.651-.188.493.493,0,0,0-.188.67L23,14.1a.479.479,0,0,0,.421.249Z" transform="translate(-15.364 -7.836)" fill="#6a6a6a" />

                                    <path id="Path_6" data-name="Path 6" d="M27,21a.5.5,0,0,0,.234-.057.479.479,0,0,0,.188-.655l-.383-.666a.479.479,0,0,0-.421-.249.505.505,0,0,0-.234.061.479.479,0,0,0-.188.655l.383.666A.475.475,0,0,0,27,21Z" transform="translate(-17.574 -11.952)" fill="#6a6a6a" />

                                    <path id="Path_7" data-name="Path 7" d="M29.787,26.263a.494.494,0,0,0,.042.383l.383.663a.483.483,0,1,0,.843-.463l-.383-.666a.486.486,0,0,0-.421-.249.494.494,0,0,0-.234.061.479.479,0,0,0-.23.272Z" transform="translate(-19.817 -15.999)" fill="#6a6a6a" />

                                    <path id="Path_8" data-name="Path 8" d="M26.722,11.051l.383.666a.494.494,0,0,0,.421.245.463.463,0,0,0,.234-.061.483.483,0,0,0,.184-.655L27.56,10.6a.479.479,0,0,0-.421-.249.506.506,0,0,0-.234.061.483.483,0,0,0-.184.64Z" transform="translate(-17.905 -6.386)" fill="#6a6a6a" />

                                    <path id="Path_9" data-name="Path 9" d="M31.692,17.357a.479.479,0,0,0,.349.149.49.49,0,0,0,.329-.126.471.471,0,0,0,.153-.337.479.479,0,0,0-.13-.345l-.521-.555a.49.49,0,0,0-.352-.153.483.483,0,0,0-.349.812Z" transform="translate(-20.604 -9.866)" fill="#6a6a6a" />

                                    <path id="Path_10" data-name="Path 10" d="M36.475,23.107a.49.49,0,0,0,.682.023.483.483,0,0,0,.023-.682l-.521-.555a.49.49,0,0,0-.352-.153.481.481,0,0,0-.349.812Z" transform="translate(-23.557 -13.414)" fill="#6a6a6a" />

                                </g>

                            </svg>

                            <span class="value"><?php if ($metas['apimo_bathrooms'][0]) {

                                                    echo esc_html($metas['apimo_bathrooms'][0]);
                                                } else {

                                                    echo 0;
                                                } ?> <?php _e('Bath', 'apimo'); ?></span>

                        </div>

                    <?php } ?>

                    <?php

                    if (in_array('areas', $apimo_archive_settings['archive_display_option'])) {

                    ?>

                        <div class="Pro-meta">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.83 24.588">

                                <path id="Path_13" data-name="Path 13" d="M29.579,26.363l-2.125-2.125a.9.9,0,0,0-1.269,1.269l.607.607H8.964V8.536l.607.607a.951.951,0,0,0,.635.276.838.838,0,0,0,.635-.276.883.883,0,0,0,0-1.269L8.716,5.748a.971.971,0,0,0-1.3,0L5.294,7.873A.9.9,0,0,0,6.563,9.143l.607-.607v19.4H26.792l-.607.607a.883.883,0,0,0,0,1.269.951.951,0,0,0,.635.276.838.838,0,0,0,.635-.276l2.125-2.125a1.018,1.018,0,0,0,.276-.662A.856.856,0,0,0,29.579,26.363Z" transform="translate(-5.025 -5.5)" fill="#6a6a6a" />

                                <path id="Path_14" data-name="Path 14" d="M30.811,34.253H42.87a.919.919,0,0,0,.911-.911V21.311a.919.919,0,0,0-.911-.911H30.811a.919.919,0,0,0-.911.911V33.37A.914.914,0,0,0,30.811,34.253Z" transform="translate(-23.035 -16.288)" fill="#6a6a6a" />

                            </svg>

                            <span class="value">
                                <?php
                                if (isset($metas['apimo_area_display_filter'][0]) && $metas['apimo_area_display_filter'][0]) {
                                    echo esc_html($metas['apimo_area_display_filter'][0]);
                                } else {
                                    echo 0;
                                }
                                ?>
                                <?php
                                if (
                                    isset($metas['apimo_area_unit'][0]) &&
                                    isset($UNIT_AREA[$metas['apimo_area_unit'][0]])
                                ) {
                                    echo esc_html($UNIT_AREA[$metas['apimo_area_unit'][0]]);
                                }

                                ?>
                            </span>


                        </div>

                    <?php } ?>



                <?php else : ?>

                    <!-- Without Icon -->

                    <?php if (in_array('number_of_rooms', $apimo_archive_settings['archive_display_option'])) { ?>

                        <div class="Pro-meta">

                            <span class="value"><?php if ($metas['apimo_rooms'][0]) {

                                                    echo esc_html($metas['apimo_rooms'][0]);
                                                } else {

                                                    echo 0;
                                                } ?> <?php _e('Rooms', 'apimo'); ?></span>

                        </div>

                    <?php } ?>

                    <?php

                    if (in_array('bathroom', $apimo_archive_settings['archive_display_option'])) { ?>

                        <div class="Pro-meta">

                            <span class="value"><?php if ($metas['apimo_bathrooms'][0]) {

                                                    echo esc_html($metas['apimo_bathrooms'][0]);
                                                } else {

                                                    echo 0;
                                                } ?> <?php _e('Bath', 'apimo'); ?></span>

                        </div>

                    <?php } ?>

                    <?php

                    if (in_array('areas', $apimo_archive_settings['archive_display_option'])) {

                    ?>

                        <div class="Pro-meta">

                            <span class="value"><?php if ($metas['apimo_area_display_filter'][0]) {

                                                    echo esc_html($metas['apimo_area_display_filter'][0]);
                                                } else {

                                                    echo 0;
                                                } ?> <?php if ($metas['apimo_area_unit'][0]) {

                                                            echo esc_html($UNIT_AREA[$metas['apimo_area_unit'][0]]);
                                                        } ?></span>

                        </div>

                    <?php } ?>

                <?php endif; ?>



            </div>



            <?php /* <div class="Pro-description__other"> */ ?>

            <div class="Pro-description Flex-col <?php echo esc_attr($classIconBlock); ?>">

                <?php if ($apimo_archive_settings['hideicon'] != 'hideicon') : ?>

                    <!-- With Icon -->

                    <?php

                    if (in_array('external_areas', $apimo_archive_settings['archive_display_option'])) {

                    ?>

                        <?php

                        foreach ($external_areas as $area) {

                            $id = get_term_meta($area->term_id, 'apimo_term_id', true);



                            if ($id == 49) { ?>

                                <div class="Pro-meta">



                                    <svg id="Modalità_Isolamento" data-name="Modalità Isolamento" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 515.13 531.98">

                                        <path d="M586.46,533H571.61c-33-54.72-.36-107.92,1.07-110.19h0a6.49,6.49,0,0,0-9.52-8.53,92.61,92.61,0,0,1-33.71,16,224.51,224.51,0,0,0,13.44,102.48l.05.17h-13.8c-28.55-82.6-7.84-159.49,21.72-195.44A6.49,6.49,0,0,0,544.73,327a114.84,114.84,0,0,0-54.41,25.29V326.76a145,145,0,0,1,36.11-47.09,270.76,270.76,0,0,1,38.29-29l.15-.09.08-.05.17-.1h0a6.5,6.5,0,1,1,6.64,11.17,254.73,254.73,0,0,0-30,21.9c40.75,4.93,71.86-29.64,65-70h0a6.51,6.51,0,0,0-3.73-4.83,58.89,58.89,0,0,0-84.46,60.73,189,189,0,0,0-28.18,31.22V180.32a47.61,47.61,0,0,0,63-54.88A46.68,46.68,0,0,0,567,75.21a46.71,46.71,0,0,0-40.71-32.65,47.6,47.6,0,0,0-87.25,0,46.7,46.7,0,0,0-40.68,32.65,46.67,46.67,0,0,0,13.71,50.23,47.6,47.6,0,0,0,65.28,53.93v88.95c-5.3-4-12.13-9.09-19.36-14.34h0a61.69,61.69,0,0,0-84.15-57.5,6.52,6.52,0,0,0-4,5.22,61.66,61.66,0,0,0,66.47,68.63A294.29,294.29,0,0,0,409,252.51a6.48,6.48,0,1,1,6.06-11.46c15.18,8,48.52,33,62.25,43.58V365c-1.39,1.57-2.74,3.14-4,4.69,9.91,34.8,17.1,89.56,1.72,163.33H461.83c16.49-76.82,11.13-175.2-31.46-222.19a6.49,6.49,0,0,0-11.26,5.05c5.83,56.56-7.1,91.79-19.13,111.55,16.86,77.91,49.69,94,53.8,105.6H438.1c-56.35-55.59-57.82-156.79-57.83-157.82a6.48,6.48,0,0,0-12.88-.87A152.41,152.41,0,0,1,336,445.45c17.05,73.23,45.39,72.1,50.84,87.56H370.49c-44.16-31.36-51.85-111.15-51.92-112a6.49,6.49,0,0,0-12.32-2.24,120.75,120.75,0,0,1-29.68,34.93c4,52.83,23.62,71.44,26.41,79.3H288.12c-43.73-65.88-17.25-164.93-17-165.93h0a6.5,6.5,0,0,0-9-7.58,81.87,81.87,0,0,0-24.78,21.71v-78.7c13.58-10.4,47.22-35.64,62.24-43.59a6.49,6.49,0,1,1,6.06,11.48,297.68,297.68,0,0,0-27.19,17.82,61.67,61.67,0,0,0,66.43-68.64,6.47,6.47,0,0,0-4-5.21,61.68,61.68,0,0,0-84.14,57.5c-7.24,5.24-14.06,10.33-19.37,14.33v-89a47.6,47.6,0,0,0,65.28-53.9,47.51,47.51,0,0,0-27-82.88,47.61,47.61,0,0,0-87.26,0,47.52,47.52,0,0,0-27,82.88,47.6,47.6,0,0,0,62.92,54.88V318.43a189.14,189.14,0,0,0-28.17-31.19,58.9,58.9,0,0,0-84.47-60.74,6.49,6.49,0,0,0-3.73,4.83c-6.88,40.34,24.14,75,65,70a255.56,255.56,0,0,0-30-21.9,6.49,6.49,0,0,1,6.61-11.17l.18.11.07,0,.17.1c27.34,16.69,61.78,46.52,74.41,76.16-2.07,63.19.37,61.08,13.68,188.34H225l-19.15-173a6.49,6.49,0,0,0-12.94.67c-.66,78.08-51.9,157-62.38,172.27H115.6c2.36-6.61,21.23-28.67,41.14-75.13-12.94-12.53-29.13-31.79-31.61-51.52A6.49,6.49,0,0,0,112.59,405c-1,2.7-22.89,64.23-7,128.05H98.82a6.49,6.49,0,0,0,0,13H586.46a6.49,6.49,0,1,0,0-13ZM451.8,103.38A32,32,0,1,1,461.2,126a32.06,32.06,0,0,1-9.4-22.62ZM198.85,121.3h0a32.06,32.06,0,1,1,9.39,22.61,32.06,32.06,0,0,1-9.39-22.61Z" transform="translate(-92.52 -14.01)" />

                                    </svg>



                                    <span class="value"><?php echo _e('Garden', 'apimo'); ?></span>

                                </div>

                            <?php }

                            if ($id == 50) { ?>

                                <div class="Pro-meta">



                                    <svg id="Modalità_Isolamento" data-name="Modalità Isolamento" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 410.85 366.53">

                                        <path d="M233.35,344a77.86,77.86,0,0,0,64.51,34.33,76.42,76.42,0,0,0,41.28-12,58.69,58.69,0,0,0,7.5-5.21A49.67,49.67,0,0,0,419,293.21,69.72,69.72,0,0,0,386.68,186,56.79,56.79,0,0,0,390,176a60.59,60.59,0,0,0-108.14-49.5,64.17,64.17,0,0,0-85.34,60.87,63.18,63.18,0,0,0,4,22.06,49.83,49.83,0,0,0-39.2,48.55A48.15,48.15,0,0,0,164,273.67,49.73,49.73,0,1,0,233.35,344Z" transform="translate(-144.75 -101.19)" />

                                        <path d="M340.7,384.72a93.35,93.35,0,0,1-42.84,10.36,94.45,94.45,0,0,1-61.15-22.4v77.79H212.13v16.8H361.87v-16.8H340.7Z" transform="translate(-144.75 -101.19)" />

                                        <path d="M517.11,277.09v-4.31a59.58,59.58,0,0,0-45.47-57.91,59.68,59.68,0,0,0-64-43.73,30.56,30.56,0,0,1-.89,5.93h0a86.91,86.91,0,0,1,42.61,74.6,85.66,85.66,0,0,1-10.47,41.27,66.35,66.35,0,0,1-30.74,92.68,59.13,59.13,0,0,0,35.72,12h2.36a59.29,59.29,0,0,0,37.35-15.12,55.17,55.17,0,1,0,33.6-105.11Z" transform="translate(-144.75 -101.19)" />

                                        <path d="M446.27,414.4h-2.36a75.94,75.94,0,0,1-45.24-14.84l-2.13.45a21.36,21.36,0,0,0-3.14.5v50.4h-18v16.8h103v-16.8h-32.2Z" transform="translate(-144.75 -101.19)" />

                                        <path d="M497.28,450.46h25.59v16.8H497.28Z" transform="translate(-144.75 -101.19)" />

                                        <path d="M159.77,450.46h35.45v16.8H159.77Z" transform="translate(-144.75 -101.19)" />

                                    </svg>



                                    <span class="value"><?php echo _e('Park', 'apimo'); ?></span>

                                </div>

                            <?php }

                            if ($id == 51) {

                            ?>

                                <div class="Pro-meta">



                                    <svg id="Modalità_Isolamento" data-name="Modalità Isolamento" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 328.22">

                                        <path d="M316.55,310.85l-2-39.47a105,105,0,0,1,9.32-5.06q39.53-24.76,43.13-63.91a79.62,79.62,0,0,0-4.25-34.61,21.41,21.41,0,0,0-1.86-4.26,78.06,78.06,0,0,0-8-14.65,7.13,7.13,0,0,1-1.6-2.66,99.86,99.86,0,0,0-10.91-12.79c-2.4-2.39-4.79-4.79-7.2-6.91l-.25.26a.8.8,0,0,1-.27-.53c0-.27,0-.27-.27-.54-1.6-1.33-3.21-2.66-4.53-3.72A117,117,0,0,0,310,109a7.09,7.09,0,0,0-1.33-.81c-.27-.26-.27-.26-.53-.26A173.67,173.67,0,0,0,288.74,122a54.18,54.18,0,0,0-4,3.72c-.27.27-.53.27-.53.54V126c-.27,0-.27,0-.27.27a127.77,127.77,0,0,0-18.38,20c-.53.8-1.07,1.86-1.59,2.66a64.12,64.12,0,0,0-8.25,14.38v.27a11.79,11.79,0,0,0-1.6,4.26,76.27,76.27,0,0,0-4.26,34.62q3.58,39.15,43.13,63.91c2.93,1.59,6.13,3.19,9.33,5.06a3.4,3.4,0,0,0,1.05.79,1,1,0,0,1,.81.27l-1.31,40a312.68,312.68,0,0,0-79.26,21.61l-1.18-24.35c1.87-1.07,4-2.13,6.13-3.46q26-16.38,28.75-42.35A50.77,50.77,0,0,0,254.39,241c-.27-1.07-.81-2.13-1.07-2.93a50.71,50.71,0,0,0-5.32-9.86,5.63,5.63,0,0,1-1.07-1.59,54.86,54.86,0,0,0-7.45-8.52L235,213.6c-.27-.26-.27-.26-.55-.26,0-.27,0-.27-.25-.27a27.93,27.93,0,0,0-2.93-2.4,70.77,70.77,0,0,0-11.72-8.78c-.26-.28-.53-.28-.79-.54s-.27-.26-.54-.26a113.82,113.82,0,0,0-12.78,9.58,30.43,30.43,0,0,0-2.93,2.4c-.27,0-.27,0-.27.27a95.25,95.25,0,0,0-12.25,13.31c-.27.53-.79,1.06-1.05,1.6a44.14,44.14,0,0,0-5.6,9.58v.27c-.27.81-.8,1.86-1.07,2.93a50.85,50.85,0,0,0-2.66,22.9c1.6,17.31,11.18,31.42,28.49,42.34,2.14,1.33,4.26,2.4,6.39,3.47,0,.26.27.26.53.52.27,0,.27,0,.54.27L214.73,338C133.5,375.43,96.6,436.1,96.6,436.1c259.51-131.16,511-52.29,511-52.29-156.34-95.72-291-73-291-73Z" transform="translate(-96.6 -107.88)" />

                                    </svg>



                                    <span class="value"><?php echo _e('Land', 'apimo'); ?></span>

                                </div>

                        <?php }
                        } ?>

                    <?php } ?>

                <?php else : ?>

                    <!-- Without Icon -->

                    <?php

                    if (in_array('external_areas', $apimo_archive_settings['archive_display_option'])) {

                    ?>

                        <?php

                        foreach ($external_areas as $area) {

                            $id = get_term_meta($area->term_id, 'apimo_term_id', true);



                            if ($id == 49) { ?>

                                <div class="Pro-meta">

                                    <span class="value"><?php echo _e('Garden', 'apimo'); ?></span>

                                </div>

                            <?php }

                            if ($id == 50) { ?>

                                <div class="Pro-meta">

                                    <span class="value"><?php echo _e('Park', 'apimo'); ?></span>

                                </div>

                            <?php }

                            if ($id == 51) {

                            ?>

                                <div class="Pro-meta">

                                    <span class="value"><?php echo _e('Land', 'apimo'); ?></span>

                                </div>

                        <?php }
                        } ?>

                    <?php } ?>

                <?php endif; ?>

            </div>





        </div>

        <div class="Pro-price Flex-col space-between">

            <?php if ($metas['apimo_price_hide'][0]) : ?>

                <span><?php _e('Private Negotiation', 'apimo'); ?></span>

            <?php else : ?>

                <span>
                    <?php
                    $price = $metas['apimo_price'][0] ? $metas['apimo_price'][0] : 0;
                    $currency = isset($metas['apimo_price_currency']) ? $metas['apimo_price_currency'] : 'EUR';

                    echo esc_html(apimo_currency_format($price, $currency));
                    ?>
                </span>

            <?php endif; ?>
            <span class="apimo-property-reference">
                <?php
                echo esc_html($metas['apimo_id'][0]);
                ?>
            </span>
        </div>


    </a>

</div>
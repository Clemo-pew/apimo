<?php



get_header(apply_filters('apimo_single_property_header_type',''));



do_action('apimo_before_single_property');

if(have_posts()){

    while(have_posts()){
        // die("hello world");
        the_post();

        global $post;

        $single_settings = get_option('apimo_style_pagina');

        $metas = get_post_meta($post->ID);    

        // print_r($metas['apimo_template_type'][0]);die();

        $style = isset($metas['apimo_template_type'][0]) ? $metas['apimo_template_type'][0] : $single_settings;



        // die($style);


        if($style == 'pagina_style_1'){

            include 'single_property_style_2.php';

        }

        elseif($style == 'pagina_style_2'){

            include 'single_property_style_2.php';

        }

        else{

            echo 'Select Template Type...';

        }

    }

}

do_action('apimo_after_single_property');

get_footer(apply_filters('apimo_single_property_footer_type',''));



?>
<?php

function create_rift_slider_post_type() {

    global $rift_slider_config;

    register_post_type("rift_slide", array(
        'labels' => array(
            'name' => __('Rift Slides', $rift_slider_config->text_domain),
            'singular_name' => __('Rift Slide', $rift_slider_config->text_domain),
            'add_new' => __('Add New Slide', $rift_slider_config->text_domain),
            'add_new_item' => __('Add New Rift Slide', $rift_slider_config->text_domain),
            'edit' => __('Edit Slide', $rift_slider_config->text_domain),
            'edit_item' => __('Edit Rift Slide', $rift_slider_config->text_domain),
            'new_item' => __('New Rift Slide', $rift_slider_config->text_domain),
            'view' => __('View Slide', $rift_slider_config->text_domain),
            'view_item' => __('View Rift Slide', $rift_slider_config->text_domain),
            'search_items' => __('Search Rift Slides', $rift_slider_config->text_domain),
            'not_found' => __('No rift slide found', $rift_slider_config->text_domain),
            'not_found_in_trash' => __('No rift slides found in the trash', $rift_slider_config->text_domain),
            'parent' => __('Rift Slider', $rift_slider_config->text_domain),
            'menu_name' => 'Rift Slider'
        ),
        'description' => __('This is where rift sliders are stored', $rift_slider_config->text_domain),
        'public' => true,
        'map_meta_cap' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'rift-slide', 'with_front' => true),        
        'query_var' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'has_archive' => true,
        'menu_position' => 101,
        'show_ui' => true,
        'show_in_menu' => true
            )
    );
}

add_action('init', 'create_rift_slider_post_type');

function create_carousel_taxonomy() {

    $labels = array(
        'name' => _x('Carousels', 'taxonomy general name'),
        'singular_name' => _x('Carousel', 'taxonomy singular name'),
        'search_items' => __('Search Carousels'),
        'all_items' => __('All Carousels'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Carousel'),
        'update_item' => __('Update Carousel'),
        'add_new_item' => __('Add New Carousel'),
        'new_item_name' => __('New Carousel Name'),
        'menu_name' => __('Carousels'),
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'carousel'),
    );

    register_taxonomy('carousel', array('rift_slide'), $args);
}

add_action('init', 'create_carousel_taxonomy');

new rift_slider_custom_tag_checklist_non_heirarchical('carousel', 'rift_slide');

new rift_slider_custom_post_type_list_columns('rift_slide');
?>
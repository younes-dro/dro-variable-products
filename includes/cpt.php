<?php

add_action('plugins_loaded', function() {
    $popup = array(
        'labels' => array(
            'name' => esc_html__('Allo Poissons', 'dro-notices'),
            'singular_name' => esc_html__('Info', 'dro-notices'),
            'add_new' => esc_html__('Add New Info', 'dro-notices'),
            'add_new_item' => esc_html__('Add New Info', 'dro-notices'),
            'edit_item' => esc_html__('Edit Info', 'dro-notices'),
            'new_item' => esc_html__('New Info', 'dro-notices'),
            'view_item' => esc_html__('View Info', 'dro-notices'),
            'search_items' => esc_html__('Search Infos', 'dro-notices'),
            'not_found' => esc_html__('No Infos Found', 'dro-notices'),
            'not_found_in_trash' => esc_html__('No Infos Found In Trash', 'dro-notices')
        ),
        'public' => false,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => true,
        'supports' => array('title', 'editor'),
        'has_archive' => false,
        'show_in_nav_menus' => false,
        'show_in_rest' => false,
        'rewrite' => false,
        'menu_icon' => 'dashicons-megaphone'
    );

    require 'class-dro-notices.php';
    /* Create CPT */
    $dro_notices = new DRO_Notices($popup);    
});


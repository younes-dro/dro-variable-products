<?php

add_action( 'wp_ajax_popup', 'popup' );
add_action( 'wp_ajax_nopriv_popup', 'popup' );

function popup() {

//        var_dump($_POST);
//    exit();
    $args = array(
        'post_type' => 'dro_notices',
        'name' => $_POST['slug']
    );
//            var_dump($args);
//    exit();

    $loop = new WP_Query($args);
//    print_r($loop);
    if ( $loop->have_posts() ) {
 
    // Start looping over the query results.
    while ( $loop->have_posts() ) {
 
        $loop->the_post();
//        the_title('<h1>', '</h1>');
        // Contents of the queried post results go here.
        the_content();
 
    }
 
}
 
// Restore original post data.
wp_reset_postdata();

	exit();
}


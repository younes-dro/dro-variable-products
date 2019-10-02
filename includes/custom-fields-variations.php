<?php
//Add our Custom Field ( main / promo prix kg )to simple product
add_action( 'woocommerce_product_options_sku', 'dro_woo_add_custom_fields' ); // After SKU field
//Save our Custom Field ( main / promo prix kg )to simple product
add_action( 'woocommerce_process_product_meta', 'dro_woo_add_custom_fields_save' );
// Add Variation Settings
add_action('woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3);
// Save Variation Settings
add_action('woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2);


function dro_woo_add_custom_fields(){
    global $woocommerce, $post;
    echo '<div class="options_group">';
 	// Number Field
	woocommerce_wp_text_input(
 		array(
 			'id'                => '_main_prix_kilo',
 			'label'             => __( 'Prix Kg', 'woocommerce' ),
 			'placeholder'       => '',
			'desc_tip'    		=> false,
 			'description'       => __( "Le prix sera afficher au desous du total.", 'woocommerce' ),
 			'type'              => 'number',
 			'custom_attributes' => array(
 					'step' 	=> 'any',
 					'min'	=> '0'
 				)
 		)
 	);
	woocommerce_wp_text_input(
 		array(
 			'id'                => '_promo_prix_kilo',
 			'label'             => __( 'Promo Prix Kg', 'woocommerce' ),
 			'placeholder'       => '',
			'desc_tip'    		=> false,
 			'description'       => __( "", 'woocommerce' ),
 			'type'              => 'number',
 			'custom_attributes' => array(
 					'step' 	=> 'any',
 					'min'	=> '0'
 				)
 		)
 	);        
        echo '</div>';
}

/**
 * Save Custom Field ( main / promo prix )
 * 
 */
function dro_woo_add_custom_fields_save( $post_id ){
    
 	// 
 	$main_prix_kilo = $_POST['_main_prix_kilo'];
	update_post_meta( $post_id, '_main_prix_kilo', esc_attr( $main_prix_kilo ) );
 	$promo_prix_kilo = $_POST['_promo_prix_kilo'];
	update_post_meta( $post_id, '_promo_prix_kilo', esc_attr( $promo_prix_kilo ) );        
}

/**
 * Create new fields for variations
 *
 */
function variation_settings_fields($loop, $variation_data, $variation) {
    // Text Field
//	woocommerce_wp_text_input( 
//		array( 
//			'id'          => '_text_field[' . $variation->ID . ']', 
//			'label'       => __( 'My Text Field', 'woocommerce' ), 
//			'placeholder' => 'http://',
//			'desc_tip'    => 'true',
//			'description' => __( 'Enter the custom value here.', 'woocommerce' ),
//			'value'       => get_post_meta( $variation->ID, '_text_field', true )
//		)
//	);
    // Number Field
	woocommerce_wp_text_input( 
		array( 
			'id'          => '_prix_kilo[' . $variation->ID . ']', 
			'label'       => __( 'Prix /Kg', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Prix par Kg', 'woocommerce' ),
			'value'       => get_post_meta( $variation->ID, '_prix_kilo', true ),
			'custom_attributes' => array(
							'step' 	=> 'any',
							'min'	=> '0'
						) 
		)
	);
    // Textarea
//	woocommerce_wp_textarea_input( 
//		array( 
//			'id'          => '_textarea[' . $variation->ID . ']', 
//			'label'       => __( 'My Textarea', 'woocommerce' ), 
//			'placeholder' => '', 
//			'description' => __( 'Enter the custom value here.', 'woocommerce' ),
//			'value'       => get_post_meta( $variation->ID, '_textarea', true ),
//		)
//	);
    // Select
//	woocommerce_wp_select( 
//	array( 
//		'id'          => '_select[' . $variation->ID . ']', 
//		'label'       => __( 'My Select Field', 'woocommerce' ), 
//		'description' => __( 'Choose a value.', 'woocommerce' ),
//		'value'       => get_post_meta( $variation->ID, '_select', true ),
//		'options' => array(
//			'one'   => __( 'Option 1', 'woocommerce' ),
//			'two'   => __( 'Option 2', 'woocommerce' ),
//			'three' => __( 'Option 3', 'woocommerce' )
//			)
//		)
//	);
//	
    $product = wc_get_product($variation->ID);
    $title = $product->get_meta('_sans_tete');
    // Checkbox
    woocommerce_wp_checkbox(
            array(
                'id' => '_entier[' . $variation->ID . ']',
                'label' => __('Entier', 'woocommerce'),
                'description' => __('', 'woocommerce'),
                'value' => get_post_meta($variation->ID, '_entier', true),
            )
    );
    woocommerce_wp_checkbox(
            array(
                'id' => '_sans_tete[' . $variation->ID . ']',
                'label' => __('Sans tête', 'woocommerce'),
                'description' => __('', 'woocommerce'),
                'value' => $title,
            )
    );
    woocommerce_wp_checkbox(
            array(
                'id' => '_sans_ecaille[' . $variation->ID . ']',
                'label' => __('Sans écaille', 'woocommerce'),
                'description' => __('', 'woocommerce'),
                'value' => get_post_meta($variation->ID, '_sans_ecaille', true),
            )
    );
    woocommerce_wp_checkbox(
            array(
                'id' => '_deux[' . $variation->ID . ']',
                'label' => __('Les deux', 'woocommerce'),
                'description' => __('', 'woocommerce'),
                'value' => get_post_meta($variation->ID, '_deux', true),
            )
    );


    // Hidden field  
//	woocommerce_wp_hidden_input(
//	array( 
//		'id'    => '_hidden_field[' . $variation->ID . ']', 
//		'value' => 'hidden_value'
//		)
//	);
}

/**
 * Save new fields for variations
 *
 */
function save_variation_settings_fields($post_id) {
    // Text Field
//	$text_field = $_POST['_text_field'][ $post_id ];
//	if( ! empty( $text_field ) ) {
//		update_post_meta( $post_id, '_text_field', esc_attr( $text_field ) );
//	}
    // Number Field
//	$number_field = $_POST['_number_field'][ $post_id ];
//	if( ! empty( $number_field ) ) {
//		update_post_meta( $post_id, '_number_field', esc_attr( $number_field ) );
//	}
    // Textarea
//	$textarea = $_POST['_textarea'][ $post_id ];
//	if( ! empty( $textarea ) ) {
//		update_post_meta( $post_id, '_textarea', esc_attr( $textarea ) );
//	}
    // Select
//	$select = $_POST['_select'][ $post_id ];
//	if( ! empty( $select ) ) {
//		update_post_meta( $post_id, '_select', esc_attr( $select ) );
//	}
    // Checkbox
//    $checkbox_sans_tete = isset($_POST['_sans_tete'][$post_id]) ? 'yes' : 'no';
//    $checkbox_sans_ecaille = isset($_POST['_sans_ecaille'][$post_id]) ? 'yes' : 'no';
//    $checkbox_cuisson= isset($_POST['_cuisson'][$post_id]) ? 'yes' : 'no';    
//    update_post_meta($post_id, '_sans_tete', $checkbox_sans_tete);
//    update_post_meta($post_id, '_sans_ecaille', $checkbox_sans_ecaille);
//    update_post_meta($post_id, '_cuisson', $checkbox_cuisson);
    
        // Prix Kg
	$_prix_kilo = $_POST['_prix_kilo'][ $post_id ];
	if( ! empty( $_prix_kilo ) ) {
		update_post_meta( $post_id, '_prix_kilo', esc_attr( $_prix_kilo ) );
	}

    $product = wc_get_product($post_id);

    $title_entier = isset($_POST['_entier'][$post_id]) ? $_POST['_entier'][$post_id] : '';
    $title_sans_tete = isset($_POST['_sans_tete'][$post_id]) ? $_POST['_sans_tete'][$post_id] : '';
    $title_sans_ecaille = isset($_POST['_sans_ecaille'][$post_id]) ? $_POST['_sans_ecaille'][$post_id] : '';
    $title_deux = isset($_POST['_deux'][$post_id]) ? $_POST['_deux'][$post_id] : '';


    $product->update_meta_data('_entier', sanitize_text_field($title_entier));
    $product->update_meta_data('_sans_tete', sanitize_text_field($title_sans_tete));
    $product->update_meta_data('_sans_ecaille', sanitize_text_field($title_sans_ecaille));
    $product->update_meta_data('_deux', sanitize_text_field($title_deux));

    $product->save();

    // Hidden field
//	$hidden = $_POST['_hidden_field'][ $post_id ];
//	if( ! empty( $hidden ) ) {
//		update_post_meta( $post_id, '_hidden_field', esc_attr( $hidden ) );
//	}
}

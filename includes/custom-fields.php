<?php
/*
 * Add our Custom Fields to simple products
 */
function mytheme_woo_add_custom_fields() {

	global $woocommerce, $post;

	echo '<div class="options_group">';

 	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_text_field',
			'label'       => __( 'My Text Field', 'woocommerce' ),
			'placeholder' => 'http://',
			'desc_tip'    => true,
			'description' => __( "Here's some really helpful tooltip text.", "woocommerce" )
		)
 	);

 	// Number Field
	woocommerce_wp_text_input(
 		array(
 			'id'                => '_number_field',
 			'label'             => __( 'My Number Field', 'woocommerce' ),
 			'placeholder'       => '',
			'desc_tip'    		=> false,
 			'description'       => __( "Here's some really helpful text that appears next to the field.", 'woocommerce' ),
 			'type'              => 'number',
 			'custom_attributes' => array(
 					'step' 	=> 'any',
 					'min'	=> '0'
 				)
 		)
 	);

 	// Textarea
 	woocommerce_wp_textarea_input(
 		array(
 			'id'          => '_textarea',
 			'label'       => __( 'My Textarea', 'woocommerce' ),
 			'placeholder' => '',
			'desc_tip'    => true,
			'description' => __( "Here's some really helpful tooltip text.", "woocommerce" )
 		)
 	);

 	// Select
 	woocommerce_wp_select(
 		array(
 			'id'      => '_select',
 			'label'   => __( 'My Select Field', 'woocommerce' ),
 			'options' => array(
 				'one'   => __( 'Option 1', 'woocommerce' ),
 				'two'   => __( 'Option 2', 'woocommerce' ),
 				'three' => __( 'Option 3', 'woocommerce' )
 				)
 		)
 	);

 	// Checkbox
 	woocommerce_wp_checkbox(
 		array(
 			'id'            => '_checkbox',
 			'wrapper_class' => 'show_if_simple',
 			'label'         => __('My Checkbox Field', 'woocommerce' ),
 			'description'   => __( 'Check me!', 'woocommerce' )
 		)
 	);

 	// Hidden field
 	woocommerce_wp_hidden_input(
 		array(
 			'id'    => '_hidden_field',
 			'value' => 'hidden_value'
 			)
 	);

 	// Custom field Type
 	?>
 	<p class="form-field custom_field_type">
 		<label for="custom_field_type"><?php echo __( 'Custom Field Type', 'woocommerce' ); ?></label>
 		<span class="wrap">
 			<?php $custom_field_type = get_post_meta( $post->ID, '_custom_field_type', true ); ?>
 			<input placeholder="<?php _e( 'Field One', 'woocommerce' ); ?>" class="" type="number" name="_field_one" value="<?php echo $custom_field_type[0]; ?>" step="any" min="0" style="width: 100px;" />
 			<input placeholder="<?php _e( 'Field Two', 'woocommerce' ); ?>" type="number" name="_field_two" value="<?php echo $custom_field_type[1]; ?>" step="any" min="0" style="width: 100px;" />
 		</span>
 		<span class="description"><?php _e( 'Place your own description here!', 'woocommerce' ); ?></span>
 	</p>
 	<?php

 	echo '</div>';

}
// General Tab
//add_action( 'woocommerce_product_options_pricing', 'mytheme_woo_add_custom_fields' ); // After pricing fields
//add_action( 'woocommerce_product_options_downloads', 'mytheme_woo_add_custom_fields' ); // After downloadable file fields and only visible when it's a downloable product
//add_action( 'woocommerce_product_options_tax', 'mytheme_woo_add_custom_fields' ); // After tax fields
add_action( 'woocommerce_product_options_general_product_data', 'mytheme_woo_add_custom_fields' ); // After all General default fields

// Inventory tab
//add_action( 'woocommerce_product_options_sku', 'mytheme_woo_add_custom_fields' ); // After SKU field
//add_action( 'woocommerce_product_options_stock', 'mytheme_woo_add_custom_fields' ); // After Manage Stock field
//add_action( 'woocommerce_product_options_stock_fields', 'mytheme_woo_add_custom_fields' ); // After Manage Stock field but only visible is checked
//add_action( 'woocommerce_product_options_stock_status', 'mytheme_woo_add_custom_fields' ); // After Stock Status field
//add_action( 'woocommerce_product_options_sold_individually', 'mytheme_woo_add_custom_fields' ); // After Sold Individually field
//add_action( 'woocommerce_product_options_inventory_product_data', 'mytheme_woo_add_custom_fields' ); // After all Inventory default fields

// Shipping tab
//add_action( 'woocommerce_product_options_dimensions', 'mytheme_woo_add_custom_fields' );  // After Dimensions field
//add_action( 'woocommerce_product_options_shipping', 'mytheme_woo_add_custom_fields' ); // After all Shipping default fields

// Linked Products tab
//add_action( 'woocommerce_product_options_related', 'mytheme_woo_add_custom_fields' ); // After all Linked Products default fields

// Attributes tab
//add_action( 'woocommerce_product_options_attributes', 'mytheme_woo_add_custom_fields' ); // After all Attributes default fields

// Advanced tab
//add_action( 'woocommerce_product_options_reviews', 'mytheme_woo_add_custom_fields' ); // After Enable Reviews field
//add_action( 'woocommerce_product_options_advanced', 'mytheme_woo_add_custom_fields' ); // After all Advanced default fields

/*
 * Save our simple product fields
 */
function mytheme_woo_add_custom_fields_save( $post_id ){

 	// Text Field
 	$woocommerce_text_field = $_POST['_text_field'];
	update_post_meta( $post_id, '_text_field', esc_attr( $woocommerce_text_field ) );

 	// Number Field
 	$woocommerce_number_field = $_POST['_number_field'];
	update_post_meta( $post_id, '_number_field', esc_attr( $woocommerce_number_field ) );

 	// Textarea
 	$woocommerce_textarea = $_POST['_textarea'];
	update_post_meta( $post_id, '_textarea', esc_html( $woocommerce_textarea ) );

 	// Select
 	$woocommerce_select = $_POST['_select'];
	update_post_meta( $post_id, '_select', esc_attr( $woocommerce_select ) );

 	// Checkbox
 	$woocommerce_checkbox = isset( $_POST['_checkbox'] ) ? 'yes' : 'no';
 	update_post_meta( $post_id, '_checkbox', $woocommerce_checkbox );

 	// Hidden Field
 	$woocommerce_hidden_field = $_POST['_hidden_field'];
	update_post_meta( $post_id, '_hidden_field', esc_attr( $woocommerce_hidden_field ) );

 	// Custom Field
 	$custom_field_type =  array( esc_attr( $_POST['_field_one'] ), esc_attr( $_POST['_field_two'] ) );
 	update_post_meta( $post_id, '_custom_field_type', $custom_field_type );

}
add_action( 'woocommerce_process_product_meta', 'mytheme_woo_add_custom_fields_save' );

/*
 * Add our Custom Fields to variable products
 */
function mytheme_woo_add_custom_variation_fields( $loop, $variation_data, $variation ) {

	echo '<div class="options_group form-row form-row-full">';

 	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_variable_text_field[' . $variation->ID . ']',
			'label'       => __( 'My Text Field', 'woocommerce' ),
			'placeholder' => 'http://',
			'desc_tip'    => true,
			'description' => __( "Here's some really helpful tooltip text.", "woocommerce" ),
			'value' => get_post_meta( $variation->ID, '_variable_text_field', true )
		)
 	);

	// Add extra custom fields here as necessary...

	echo '</div>';

}
// Variations tab
//add_action( 'woocommerce_variation_options', 'mytheme_woo_add_custom_variation_fields', 10, 3 ); // After variation Enabled/Downloadable/Virtual/Manage Stock checkboxes
//add_action( 'woocommerce_variation_options_pricing', 'mytheme_woo_add_custom_variation_fields', 10, 3 ); // After Price fields
//add_action( 'woocommerce_variation_options_inventory', 'mytheme_woo_add_custom_variation_fields', 10, 3 ); // After Manage Stock fields
//add_action( 'woocommerce_variation_options_dimensions', 'mytheme_woo_add_custom_variation_fields', 10, 3 ); // After Weight/Dimension fields
//add_action( 'woocommerce_variation_options_tax', 'mytheme_woo_add_custom_variation_fields', 10, 3 ); // After Shipping/Tax Class fields
//add_action( 'woocommerce_variation_options_download', 'mytheme_woo_add_custom_variation_fields', 10, 3 ); // After Download fields
add_action( 'woocommerce_product_after_variable_attributes', 'mytheme_woo_add_custom_variation_fields', 10, 3 ); // After all Variation fields

/*
 * Save our variable product fields
 */
function mytheme_woo_add_custom_variation_fields_save( $post_id ){

 	// Text Field
 	$woocommerce_text_field = $_POST['_variable_text_field'][ $post_id ];
	update_post_meta( $post_id, '_variable_text_field', esc_attr( $woocommerce_text_field ) );

}
add_action( 'woocommerce_save_product_variation', 'mytheme_woo_add_custom_variation_fields_save', 10, 2 );

/*
 * Display our example custom field above the summary on the Single Product Page
 */
function mytheme_display_woo_custom_fields() {
	global $post;

	$ourTextField = get_post_meta( $post->ID, '_text_field', true );

	if ( !empty( $ourTextField ) ) {
		echo '<div>Our Text Field: ' . $ourTextField . '</div>';
	}
}
add_action( 'woocommerce_single_product_summary', 'mytheme_display_woo_custom_fields', 15 );


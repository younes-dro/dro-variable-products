<?php
/*
  Plugin Name: DRO Variable Products
  Plugin URI: https://github.com/younes-dro
  Description: Add multiple variable products and custom fields for product variations
  Version: 1.0.0
  Author: Younes DRO
  Author URI: https://github.com/younes-dro
  License: GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: dro-vp
  Domain Path: /languages
 */

/*  Copyright 2019 Younes DRO (email : younesdro@gmail.com)
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  custom
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

function cfwc_cart_item_name($name, $cart_item, $cart_item_key) {
    if (isset($cart_item['_entier'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('Entier...')
        );
    }
    if (isset($cart_item['_sans_tete'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('Sans tête')
        );
    }
    if (isset($cart_item['_sans_ecaille'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('Sans écaille')
        );
    }
    if (isset($cart_item['_deux'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('Les deux')
        );
    }
    if (isset($cart_item['_sans_queue'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('Sans queue')
        );
    }
    if (isset($cart_item['_avec_peau'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('Avec peau')
        );
    }
    if (isset($cart_item['_sans_peau'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('sans peau')
        );
    }
    if (isset($cart_item['_coupe_deux'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('Coupé en deux')
        );
    }
    if (isset($cart_item['_cuisson'])) {
        $name .= sprintf(
                '<p>%s</p>', esc_html('Pour cuisson en croûte de sel')
        );
    }    

    return $name;
}

add_filter('woocommerce_cart_item_name', 'cfwc_cart_item_name', 10, 3);

function cfwc_add_custom_data_to_order($item, $cart_item_key, $values, $order) {
    foreach ($item as $cart_item_key => $values) {
        if (isset($values['_entier'])) {
            $item->add_meta_data(__('Entier', 'cfwc'), ' ', true);
        }
        if (isset($values['_sans_tete'])) {
            $item->add_meta_data(__('Sans tête', 'cfwc'), ' ', true);
        }
        if (isset($values['_sans_ecaille'])) {
            $item->add_meta_data(__('Sans écaille', 'cfwc'), ' ', true);
        }
        if (isset($values['_deux'])) {
            $item->add_meta_data(__('Les deux', 'cfwc'), ' ', true);
        }
        if (isset($values['_sans_queue'])) {
            $item->add_meta_data(__('Sans queue', 'cfwc'), ' ', true);
        }
        if (isset($values['_avec_peau'])) {
            $item->add_meta_data(__('Avec peau', 'cfwc'), ' ', true);
        }
        if (isset($values['_sans_peau'])) {
            $item->add_meta_data(__('Sans peau', 'cfwc'), ' ', true);
        }
        if (isset($values['_coupe_deux'])) {
            $item->add_meta_data(__('Coupé deux', 'cfwc'), ' ', true);
        }
        if (isset($values['_cuisson'])) {
            $item->add_meta_data(__('Pour cuisson en croûte de sel', 'cfwc'), ' ', true);
        }        
        
    }
}

add_action('woocommerce_checkout_create_order_line_item', 'cfwc_add_custom_data_to_order', 10, 4);


/* Display sale price before regular parice  */
add_filter( 'woocommerce_format_sale_price', 'invert_formatted_sale_price', 10, 3 );
function invert_formatted_sale_price( $price, $regular_price, $sale_price ) {
    return '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del class="dro-regular-price">' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
}

function woocommerce_ajax_add_to_cart_js() {
    if (function_exists('is_product') && is_product()) {
        wp_enqueue_style('customcss', plugin_dir_url(__FILE__) . 'assets/css/style.css');

        wp_enqueue_script('dro-woocommerce-ajax-add-to-cart', plugin_dir_url(__FILE__) . 'assets/js/ajax-add-to-cart.js', array('jquery'), '', true);



        wp_enqueue_script('dro-woocommerce-custom', plugin_dir_url(__FILE__) . 'assets/js/custom.js', array('jquery', 'thickbox'), '', true);
        wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/726d2aa665.js');

        wp_localize_script('dro-woocommerce-custom', 'ajaxpopup', admin_url('admin-ajax.php'));

        $ajax_url = add_query_arg(
                array(
            'action' => 'popup'
                ), admin_url('admin-ajax.php')
        );
        wp_localize_script('dro-woocommerce-custom', 'ajax_args', array(
            'ajax_url' => $ajax_url)
        );
    }
}

add_action('wp_enqueue_scripts', 'woocommerce_ajax_add_to_cart_js', 99);

function woocommerce_variable_add_to_cart() {
    global $product, $post;
    // print_r($product->product_type);
    $variations = $product->get_available_variations();
//    ob_start(); // Start buffering
    ?>
    <form class="cart" action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post" enctype="multipart/form-data">
        <table class="dro-variable-product" id="dro-variable-product">
            <tbody>
                <?php
                foreach ($variations as $key => $value) {
                    ?>
                    <tr>
                        <td width="65%">
                            <h2 class="product_title_variation"><?php echo implode('/', $value['attributes']); ?></h2>

                            <div class="description_variation"><?php echo $value['variation_description']; ?></div>
                            <div class="custom-field-container">
                                <?php
                                $product = wc_get_product($value['variation_id']);

                                // Check for the custom field value
                                $entier = $product->get_meta('_entier');
                                $sans_tete = $product->get_meta('_sans_tete');
                                $sans_ecaille = $product->get_meta('_sans_ecaille');
                                $deux = $product->get_meta('_deux');
                                $sans_queue = $product->get_meta('_sans_queue');
                                $sans_peau = $product->get_meta('_sans_peau');
                                $avec_peau = $product->get_meta('_avec_peau');
                                $coupe_deux = $product->get_meta('_coupe_deux');
                                $cuisson = $product->get_meta('_cuisson');
                                if ($entier) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_entier" name="_entier[' . $value['variation_id'] . ']">'
                                    . 'Entier'
                                    . '<i id="entier" class="infos entier fa fa-info-circle"></i>'
                                    . '</div>';
                                }
                                if ($sans_tete) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_sans_tete" name="_sans_tete[' . $value['variation_id'] . ']">'
                                    . 'Sans tête'
                                    . '<i id="sans-tete" class="infos sans-tete fa fa-info-circle"></i>'
                                    . '</div>';
                                }
                                if ($sans_ecaille) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_sans_ecaille" name="_sans_ecaille[' . $value['variation_id'] . ']">'
                                    . 'Sans écaille'
                                    . '<i id="sans-ecaille" class="infos sans-ecaille fa fa-info-circle"></i>'
                                    . '</div>';
                                }
                                if ($deux) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_deux" name="_deux[' . $value['variation_id'] . ']">'
                                    . 'Les deux'
                                    . '<i id="deux" class="infos deux fa fa-info-circle"></i>'
                                    . '</div>';
                                }
                                if ($sans_queue) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_sans_queue" name="_sans_queue[' . $value['variation_id'] . ']">'
                                    . 'Sans queue'
                                    . '<i id="sans-queue" class="infos deux fa fa-info-circle"></i>'
                                    . '</div>';
                                }
                                if ($sans_peau) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_sans_peau" name="_sans_peau[' . $value['variation_id'] . ']">'
                                    . 'Sans peau'
                                    . '<i id="sans-peau" class="infos deux fa fa-info-circle"></i>'
                                    . '</div>';
                                }
                                if ($avec_peau) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_avec_peau" name="_avec_peau[' . $value['variation_id'] . ']">'
                                    . 'Avec peau'
                                    . '<i id="avec-peau" class="infos deux fa fa-info-circle"></i>'
                                    . '</div>';
                                }
                                if ($coupe_deux) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_coupe_deux" name="_coupe_deux[' . $value['variation_id'] . ']">'
                                    . 'Coupé en deux'
                                    . '<i id="coupe-deux" class="infos deux fa fa-info-circle"></i>'
                                    . '</div>';
                                }
                                if ($cuisson) {
                                    // Only display our field if we've got a value for the field title
                                    echo '<div class="cfwc-custom-field-wrapper">'
                                    . '<label for="cfwc-title-field"></label><input value="yes" type="checkbox" id="_cuisson" name="_cuisson[' . $value['variation_id'] . ']">'
                                    . 'Pour cuisson en croûte de sel'
                                    . '<i id="cuisson" class="infos deux fa fa-info-circle"></i>'
                                    . '</div>';
                                }                                
                                ?>
                            </div>
                        </td>

                        <td align="center">
                            <?php echo $value['price_html']; ?>
                            <?php // if(($product->get_meta('_prix_kilo')) || $product->get_meta('_prix_kilo')){?>
                            <span class="price-variation-kilo">
                                <?php
                                if ($product->get_meta('_prix_kilo')) {
                                    echo $product->get_meta('_prix_kilo') . ' €/kg';
                                }
                                ?>
                            </span>
                            <input type="hidden" class="display_regular_price" value="<?php print_r($value['display_regular_price']) ?>" />
                            <input type="hidden" class="display_price" value="<?php print_r($value['display_price']) ?>" />
                            <input type="hidden" name="variation_id[]" value="<?php echo $value['variation_id'] ?>" />
                            <input type="hidden" name="product_id[]" value="<?php echo esc_attr($post->ID); ?>" />
                            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($post->ID); ?>" />
                            <?php
                            if (!empty($value['attributes'])) {
                                foreach ($value['attributes'] as $attr_key => $attr_value) {
                                    ?>
                                    <input type="hidden" name="<?php echo $attr_key ?>" value="<?php echo $attr_value ?>">
                                    <?php
                                }
                            }
                            woocommerce_quantity_input([ 'input_name' => 'quantity[]', 'min_value' => 0, 'input_value' => '0', 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity()]);
                            ?>
                            <?php // do_action( 'woocommerce_before_add_to_cart_button' );  ?>


                        </td>
                    </tr>

                    <?php
                }
                ?>
                <tr><td class="total-container"  colspan="3">
                        <input type="hidden" id="input-total-variable-products" value="0" />
                        <span id="total-variable-products"></span><?php //echo get_woocommerce_currency_symbol()       ?>
                        <?php
                        $_main_prix_kilo = get_post_meta($post->ID, '_main_prix_kilo', '_main_prix_kilo', true);
//                        var_dump($_main_prix_kilo);
                        $_promo_prix_kilo = get_post_meta($post->ID, '_promo_prix_kilo', '_promo_prix_kilo', true);
//                        var_dump($_promo_prix_kilo);
                        ?>
                        <?php if (($_main_prix_kilo) || ($_promo_prix_kilo)): ?>
                            <div class="price-box">
                                <?php if ($_main_prix_kilo): ?>
                                    <p class="kg-price special-price">
                                        <span class=""><?php echo $_main_prix_kilo; ?></span>
                                    </p>
                                <?php endif; ?>
                                <?php if ($_promo_prix_kilo): ?>
                                    <p class="kg-price special-price">
                                        <span class=""><?php echo $_promo_prix_kilo; ?></span>
                                    </p>
                                <?php endif; ?>                            
                            </div>
                        <?php endif; ?>                        

                    </td></tr>
                <tr><td  class="add-cart-" colspan="3"><button type="submit" class="single_add_to_cart_button button alt"><?php echo apply_filters('single_add_to_cart_text', __('Add to cart', 'woocommerce'), $product->product_type); ?></button></td></tr>
            </tbody>
        </table>
        <input type="hidden" name="action" value="woocommerce_ajax_add_to_cart" />
    </form>
    <div class="popup-infos">

        <div class="popup-content">

            <div class="content">

                <h1 class="header-popup">INFORMATIONS SUR LES MODES DE DÉCOUPE  <span class="close-popup"><i class="fa fa-close"></i></span></h1>

                <div class="popup_content">
                </div>

            </div>
        </div>
    </div>
    <?php
    //return;
}

add_action('template_redirect', 'dro_qib_enqueue_script');

function dro_qib_enqueue_script() {

    wc_enqueue_js('			
			
			// Make the code work after page load.
			$(document).ready(function(){			
				//DroQtyChng();		
			});

			// Make the code work after executing AJAX.
			$(document).ajaxComplete(function () {
				//DroQtyChng();
			});
                        console.log("loaded ! ");
                        
                        $(document).on( "click", "button.qib-button", function(){
                           $regular_price = $(this).parent().siblings(".display_price").val();
                           $regular_price = Number($regular_price);
                           $regular_price = $regular_price.toFixed(2);       
                           

                           $total = $("#input-total-variable-products").val();
                           $total = parseFloat($total);
                           $newTotal = 0;
                           
                            //console.log($(this).siblings(".quantity").children(".qty").val());
                           if ( $(this).is(".plus") ){
                           
                                $newTotal = parseFloat($total) + parseFloat($regular_price);
                                $newTotal = $newTotal.toFixed(2);
                                $("#input-total-variable-products").val( $newTotal );
                           
                           }else{
                               if($(this).siblings(".quantity").children(".qty").val() == 0 ){
                                   console.log("qte 0");
                                   return;
                               }
                            if( ($total === 0)  || ($total - $regular_price < 0) ){
                                console.log("Echec");
                             return;
                            }
                            $newTotal = parseFloat($total) - parseFloat($regular_price);
                            $newTotal = $newTotal.toFixed(2);
                            $("#input-total-variable-products").val( $newTotal );
                            console.log("new total ",$newTotal);
                            }
                           $finalTotal = ( $newTotal != 0) ? $newTotal+ " €" : "";
                           $("#total-variable-products").text($finalTotal);
                           
                        });

			
		');
}

include plugin_dir_path(__FILE__) . "includes/ajax.php";
//include plugin_dir_path(__FILE__) . "includes/checkbox.php";
include plugin_dir_path(__FILE__) . "includes/custom-fields-variations.php";
include plugin_dir_path(__FILE__) . "includes/cpt.php";
include plugin_dir_path(__FILE__) . "includes/ajax-popup.php";


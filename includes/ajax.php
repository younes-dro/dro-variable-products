<?php

add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
        
function woocommerce_ajax_add_to_cart() {
            $erreur = 0;
            
//            echo count($_POST['variation_id']);
//            foreach($_POST['_sans_tete'] as $key => $value){
//                echo $key . ' : ' . $value . '|';
//            }
//            exit();
//            for( $i = 0 ; $i < count($_POST['variation_id']) ; $i++ ){
//                $id = $_POST['variation_id'][$i];
                
//                var_dump($_POST['_sans_tete']);
//                if(isset( $_POST['_sans_tete'][$id] )){
//                    echo $id;
//                    var_dump($_POST['_sans_tete'][$id]);
//                }
                
//                
//                echo $i . ':' 
//                .print_r($_POST['_sans_tete'][$i],true)
//                        . ' | ';
//
//        var_dump($_POST['_sans_tete'][2]);
//            }
//            exit();
            for( $i = 0 ; $i < count($_POST['variation_id']) ; $i++ ){
                if($_POST['quantity'][$i] >0){
                
                $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id'][$i]));
                // $quantity = empty($_POST['quantity'][$i]) ? 1 : wc_stock_amount($_POST['quantity'][$i]);
                $quantity = $_POST['quantity'][$i] ;
                $variation_id = absint($_POST['variation_id'][$i]);
                $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

                $product_status = get_post_status($product_id);
                
                /* Custom field */
                if(isset( $_POST['_entier'][$variation_id] )){
                    add_filter( 'woocommerce_add_cart_item_data', function($cart_item_data, $product_id, $variation_id, $quantity){
                        $cart_item_data['_entier'] = $_POST['_entier'][$variation_id];
                        return $cart_item_data;
                    }, 10, 4 );
                }                
                if(isset( $_POST['_sans_tete'][$variation_id] )){
                    add_filter( 'woocommerce_add_cart_item_data', function($cart_item_data, $product_id, $variation_id, $quantity){
                        $cart_item_data['_sans_tete'] = $_POST['_sans_tete'][$variation_id];
                        return $cart_item_data;
                    }, 10, 4 );
                }
                if(isset( $_POST['_sans_ecaille'][$variation_id] )){
                    add_filter( 'woocommerce_add_cart_item_data', function($cart_item_data, $product_id, $variation_id, $quantity){
                        $cart_item_data['_sans_ecaille'] = $_POST['_sans_ecaille'][$variation_id];
                        return $cart_item_data;
                    }, 10, 4 );
                }
                if(isset( $_POST['_deux'][$variation_id] )){
                    add_filter( 'woocommerce_add_cart_item_data', function($cart_item_data, $product_id, $variation_id, $quantity){
                        $cart_item_data['_deux'] = $_POST['_deux'][$variation_id];
                        return $cart_item_data;
                    }, 10, 4 );
                }                

                if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
    
                    do_action('woocommerce_ajax_added_to_cart', $product_id);
    
                    if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                       // wc_add_to_cart_message(array($product_id => $quantity), true);
                    }
    
                   // WC_AJAX :: get_refreshed_fragments();
                } else {
                    $erreur++;

                }
            }

            }
            if ($erreur > 0){
                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

                echo wp_send_json($data);
            }
            var_dump($erreur);
            wp_die();
        }

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {
  $(document).on("click", ".single_add_to_cart_button", function(e) {
    e.preventDefault();
    var $thisbutton = $(this),
      $form = $("form.cart");
    // id = $thisbutton.val();
    //   product_qty = $form.find("input[name=quantity]").val() || 1,
    //   product_id = $form.find("input[name=product_id]").val() || id,
    // product_id = $form.find("input[name=product_id]").val() || id,
    // variation_id = $form.find("input[name=variation_id]").val() || 0;

    var form_data = $form.serializeArray();
    // console.log(form_data);
    // return;
    // var data = {
    //   action: "woocommerce_ajax_add_to_cart",
    //   // product_id: product_id,
    //   // product_sku: "",
    //   //   quantity: product_qty,
    //   //   variation_id: variation_id,
    //   form_data: form_data
    // };

     $(document.body).trigger("adding_to_cart", [$thisbutton, form_data]);

    $.ajax({
      type: "post",
      url: wc_add_to_cart_params.ajax_url,
      data: form_data,
      beforeSend: function(response) {
        $thisbutton.removeClass("added").addClass("loading");
      },
      complete: function(response) {
        $thisbutton.addClass("added").removeClass("loading");
      },
      success: function(response) {
        console.log('response : ');
        console.log(response);
        // return;
        if (response.error & response.product_url) {
          window.location = response.product_url;
          return;
        } else {
          $(document.body).trigger("added_to_cart", [
            response.fragments,
            response.cart_hash,
            $thisbutton
          ]);
        }
      }
    });

    return false;
  });
})(jQuery);

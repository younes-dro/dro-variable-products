
(function ($) {


    // PopUp Infos
    window.ajaxURL = ajax_args.ajax_url;
    $(document).on("click", ".infos", function () {


        var slug = $(this).attr("id");
        console.log(slug);
        data = {slug: slug};
        $.ajax({
            type: "post",
            url: window.ajaxURL,
            data: data,
            beforeSend: function (response) {
            $('.popup-infos').fadeIn();
            $('.popup-infos .popup_content').html('<h1>Loading.........</h1>');
            },
            complete: function (response) {
//        $thisbutton.addClass("added").removeClass("loading");
            },
            success: function (response) {
//        console.log('response : ');
                console.log(response);
                $('.popup-infos .popup_content').html(response);
                $('.popup-infos').fadeIn();
            }
        });

    });
    $(document).on("click", ".popup-infos", function () {
        $(this).fadeOut();
    });
    
    // checkbox
    $(document).on('click','input[type=checkbox]',function(){
        $this = $(this);
        $nextInputQty = $this.parents('tr').find('.input-text.qty');
        $currentVal = $nextInputQty.val();
        if(Number($currentVal) === 0){
//            $nextInputQty.val(1);
            $newPlusButton = $nextInputQty.parent().next('button.qib-button.plus');
            $newPlusButton.trigger('click');
        }else{
            console.log('no');
        }
    });
})(jQuery);



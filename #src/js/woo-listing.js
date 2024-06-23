jQuery(document).ready(function($) {
        $('.view-switcher').on('click', 'button', function() {
        $('.catalog-main .wrap .right').addClass('loading');
        var view = $(this).data('view');
        var $button = $(this); // Сохраняем ссылку на текущий элемент

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'update_product_view',
                view: view
            },
            success: function(response) {
                if (response === 'success') {
                    var $products = $('.catalog-main .wrap .right ul.products');
                    $products.removeClass('grid list carousel').addClass(view);
                    localStorage.setItem('product_view', view);
                    $('.catalog-main .wrap .right').removeClass('loading');
                    $('.view-switcher button').removeClass('active');
                    $button.addClass('active');
                }
            }
        });
    });

    // Восстанавливаем выбранный вид при загрузке страницы
    var savedView = localStorage.getItem('product_view');
    if (savedView && $('.view-switcher button[data-view="' + savedView + '"]').length) {
        var $targetButton = $('.view-switcher button[data-view="' + savedView + '"]');
        var $products = $('.catalog-main .wrap .right ul.products');
        
        $products.addClass(savedView);
        $('.view-switcher button').removeClass('active');
        $targetButton.addClass('active');
    }
});
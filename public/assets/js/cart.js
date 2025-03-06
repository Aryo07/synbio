$(document).ready(function() {
    function updateCartCount() {
        $.ajax({
            url: window.location.origin + '/carts/count',
            type: 'GET',
            success: function(response) {
                if (response.count > 0) {
                    $('#cart-count').text(response.count).show();
                } else {
                    $('#cart-count').hide();
                }
            }
        });
    }

    updateCartCount();
});
$(document).ready(function() {
    function updateCartCount() {
        $.ajax({
            url: window.location.origin + '/carts/count',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
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
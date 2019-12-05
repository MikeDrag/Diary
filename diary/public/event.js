$(document).ready(function() {
    $('#categories-list a').on('click', function () {
        $('#category-items-container .item').html('');
        let category = $(this).data('category');

        $.ajax({
            url: '/category/id?name=' + category,
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $.each(data, function (k, v) {
                    console.log(data[k]);
                        $('#category-items-container .item').append('<div class="item">' +
                            '<h3>' + data.name + '</h3>' +
                            '<p>' + '<img src="' + data.imageUrl + '"/>' + '</p>' +

                            '</div>');
                });
            },
        });
    });
});
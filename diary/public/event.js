$(document).ready(function() {
    $('#categories-list a').on('click', function () {
        $('#category-items-container .item').html('');
        let category = $(this).data('category');

        $.ajax({
            url: '/category/id?name=' + category,
            method: 'post',
            dataType: 'json',
            success: function (data) {
                $.each(data, function (k, v) {
                    console.log(name);
                        $('#category-items-container').append('<div class="item">' +
                            '<h3><a href="' + '/category/id?name=' + v.name + '"' + ">" + v.name + '</a></h3>' +
                            '<p>' + '<img src="' + v.imageUrl + '"/>' + '</p>' +
                            '</div>');
                });
            },
        });
    });
});
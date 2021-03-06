//validate login
$(document).ready(function () {
    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 50
            },
            password: {
                required: true,
                minlength: 5
            },
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Email must be a valid email address",
                maxlength: "Email cannot be more than 50 characters",
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 5 characters"
            },
        }
    });

    //validate createUser
    $("#createForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 20
            },
            username: {
                required: true,
                maxlength: 30
            },
            email: {
                required: true,
                email: true,
                maxlength: 50
            },
            password: {
                required: true,
                minlength: 5
            },
        },
        messages: {

            name: {
                required: "Name is required",
                maxlength: "Name cannot be more than 20 characters"
            },
            username: {
                required: "username is required",
                maxlength: "username cannot be more than 30 characters"
            },
            email: {
                required: "Email is required",
                email: "Email must be a valid email address",
                maxlength: "Email cannot be more than 50 characters",
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 5 characters"
            },
        }
    });

    //create products shopify
    $("#createShopify").validate({
        rules: {
            body_html: {
                required: true,
                maxlength: 20
            },
            title: {
                required: true,
                maxlength: 30
            },
            handle: {
                required: true,
                maxlength: 50
        },
        },
        messages: {

            body_html: {
                required: "body_html is required",
                maxlength: "body_html cannot be more than 20 characters"
            },
            title: {
                required: "title is required",
                maxlength: "title cannot be more than 30 characters"
            },
            handle: {
                required: "handle is required",
                maxlength: "handle cannot be more than 50 characters",
            },
        }
    });

    //Listuser
    $("input#searchName").on('blur keyup', function () {
        console.log($(this).val());
        $.ajax({
            type: 'GET',
            url: '/users/search', // route ??
            data: {
                name: $(this).val()
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                var htmlItems = '';
                $.each(response, function (index, item) {
                    htmlItems += "<div><a href='/users?name=" + item['name'] + "'>" + item['name'] + "</a></div>";
                });
                $('.autocomplete-items').html(htmlItems)
            }
        });
    });

    //Validate createProducts
    $("#create-product").validate({
        rules: {
            title: {
                required: true,
                maxlength: 20
            },
            name: {
                required: true,
                maxlength: 20
            },
            description: {
                required: true,
                description: true,
                maxlength: 1000
            },
            price: {
                required: true,
                maxlength: 10
            },
            quantity: {
                required: true,
                maxlength: 10
            },
        },
        messages: {

            title: {
                required: "title is required",
                maxlength: "title cannot be more than 20 characters"
            },
            name: {
                required: "Name is required",
                maxlength: "Name cannot be more than 20 characters"
            },
            description: {
                required: "description is required",
                description: "description must be a valid description address",
                maxlength: "description cannot be more than 100 characters",
            },
            price: {
                required: "price is required",
                maxlength: "price cannot be more than 20 characters"
            },
            quantiy: {
                required: "quantiy is required",
                maxlength: "quantiy cannot be more than 20 characters"
            },
        }
    });

    //Autocomplete Products
    $("input#searchTitle").on('blur keyup', function () {
        console.log($(this).val());
        $.ajax({
            type: 'GET',
            url: '/products/search', // route ??
            data: {
                title: $(this).val()
            },
            dataType: "json",
            success: function (response) {
                console.log(response);

                var htmlItems = '';
                $.each(response, function (index, item) {
                    htmlItems += "<div><a href='/products?title=" + item['title'] + "'>" + item['title'] + "</a></div>";
                });
                $('.autocomplete-items').html(htmlItems)
            }
        });
    });

});

//Loc status pending/approve/rejects
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function filterStatus(status) {
    $.ajax({
        type: 'post',
        dataType: 'JSON',
        data: { status },
        url: 'products/fitter/' + status,
        success: function (result) {
            var html = ''
            result.keyword.forEach(element => {
                html += '<tr><td>' + element.id + '</td>'
                html += '<td>' + element.title + '</td>'
                html += '<td>' + element.description + '</td>'
                html += '<td>' + element.quantity + '</td>'
                html += '<td><img width="100px" src="/' + element.image + '" alt="' + element.image + '"/></td>'
                html += '<td>' + element.price + '</td>'
                html += '<td>' + element.status + '</td></tr>'
            });
            $('#list_products').html(html)
        }
    });
}

function filterByStatus(status) {
    $.ajax({
        type: 'post',
        dataType: 'JSON',
        data: { status },
        url: 'posts/fitter/' + status,
        success: function (result) {
            var html = ''
            result.keyword.forEach(element => {
                html += '<tr><td>' + element.id + '</td>'
                html += '<td><img width="100px" src="' + element.image + '" alt="' + element.image + '"/></td>'
                html += '<td>' + element.title + '</td>'
                html += '<td>' + element.content + '</td>'
                html += '<td>' + element.status + '</td></tr>'
            });

            $('#list_posts').html(html)
        }
    });
}

function changeUserStatus(_this, id) {
    var status = $(_this).prop('checked') == true ? 'publish' : 'unpublish';
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/posts/change-status',
        type: 'post',
        data: {
            _token: _token,
            id: id,
            status: status
        },
        success: function (result) {
        }
    });
}
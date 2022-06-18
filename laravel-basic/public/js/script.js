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
                minlength: 2
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
                minlength: "price must be at least 2 characters"
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

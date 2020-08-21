$(function () {    
    $.ajax({
        url: $(location).attr('href'),
        success: function (data) {
            $('#result').html(data);
        }
    });

    $(document).on('submit','#register_form',function (event) {
        ajax($('#register_form'), '/customer/registration', event);
    });

    $(document).on('submit','#login_form',function (event) {
        ajax($('#login_form'), '/customer/login', event);
    function clear() {
        $('#success').html('');
        $('#error').html('');
    }

    $.ajax({
        url: $(location).attr('href'),
        success: function (data) {
            $('#result').html(data);
        }
    });

    $(document).on('click', '#loginPage, #registrPage, #logout', function (event) {
        ajaxLink($(this).attr("href"));
        event.preventDefault();
    });

    function ajaxLink(url) {
        clear();
        $.ajax({
            url: url,
            success: function (data) {
                $('#result').html(data);
                history.pushState(null, null, url);
            }

        })
    }

    $(document).on('submit','#register_form, #login_form',function (event) {
        ajaxForm($(this), $(this).data("action"));
        event.preventDefault();

    });

    function ajaxForm(form, action, event) {

        $.ajax({
            url: action,
            data: form.serialize(),
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    clear();
                    if (data.action == "redirect") {
                        window.location.href = data.redirectUrl;
                    } else {
                        $('#success').html(data.message);
                    }
                } else {
                    $('#error').html(data.message);
                }

            }
        });
    }
});

$.ajax({
    url: $(location).attr('href'),
    success: function (data) {
        $('#result').html(data);
    }
});

$(function () {
    let loginForm = $('#login_form');
    let registrationForm = $('#register_form');

    registrationForm.submit(function (event) {
        ajax(registrationForm, '/customer/registration', event);
    });

    loginForm.submit(function (event) {
        ajax(loginForm, '/customer/login', event);
    });

    function ajax(form, action, event) {
        event.preventDefault();

        $.ajax({
            url: action,
            data: form.serialize(),
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    $('#success').html('');
                    $('#error').html('');
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
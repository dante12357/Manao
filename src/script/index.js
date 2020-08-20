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

$(function () {
    $.ajax({
        url: $(location).attr('href'),
        success: function (data) {
            $('#result').html(data);
        }
    });

    function clear() {
        $('#success').html('');
        $('#error').html('');
    }


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
                if (data.success) {
                    if (data.action == "redirect") {
                        window.location.href = data.redirectUrl;
                    }
                }
            }


        })
    }

    $(document).on('submit', '#register_form, #login_form', function (event) {
        ajaxForm($(this), $(this).data("action"));
        event.preventDefault();

    });

    function ajaxForm(form, action) {

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
})

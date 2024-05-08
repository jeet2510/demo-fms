$(document).ready(function () {
    $('.ajax-form').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        form.find('.text-red-500').remove();
        var formData = form.serialize();
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    window.location.reload();
                    $(document).ajaxStop(function () {
                        $('<div class="alert alert-success">' + response.success + '</div>').insertBefore(form);
                    });
                } else {
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

                if (jqXHR.responseText.startsWith('<!DOCTYPE')) {
                    window.location.reload();
                    return;
                }
                if (jqXHR.responseJSON) {
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        form.find('#' + key).after('<p class="text-red-500" style="color:red">' + value + '</p>');
                    });
                } else {
                    if (jqXHR.status >= 400 && jqXHR.status < 500) {
                        form.append('<p class="text-red-500" style="color:red">An error occurred. Please try again later.</p>');
                    } else if (jqXHR.status >= 500 && jqXHR.status < 600) {
                        form.append('<p class="text-red-500" style="color:red">Server error. Please try again later.</p>');
                    } else {
                        form.append('<p class="text-red-500" style="color:red">An error occurred. Please try again later.</p>');
                    }
                }
            }
        });
    });
});

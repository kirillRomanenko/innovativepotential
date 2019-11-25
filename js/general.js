$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: my_ajax_object.ajax_url,
        data: { action: 'sizeBasedCalculation' },
        success: function (responce) {
            console.log(responce);
        }
    });
});
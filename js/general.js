$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: my_ajax_object.ajax_url,
        // dataType: 'json',
        data: { action: 'importExcel' },
        // success: makeTable,
    });
});
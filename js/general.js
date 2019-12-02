$(document).ready(function () {
    $('.js-add-file').on('change', function (event, files, label) {
        const file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '');

        $(this).siblings('label').empty().text(file_name);
    });

    $('#form').submit((e) => {
        e.preventDefault();
        let file_data;
        let form_data = new FormData();

       $('.js-add-file').map(function() {
            file_data = $(this).prop('files')[0];
            form_data.append('file', file_data);
       })                

        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            cache: false,
            dataType: 'json',
            processData: false, 
            contentType: false,
            data: {'action': 'calcInnovativePotential', form_data},
            
            success: function (responce) {
            }
        });
    });
});
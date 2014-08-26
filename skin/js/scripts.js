Dropzone.options.dropzoneForm = {
    addRemoveLinks: true,
    maxFilesize: 5
};

$('.remove-file').click(function()
{
    var path = $(this).parent().data('path');
    $('#modal_remove .modal-body span').text(path);
    $('#modal_remove').modal();
});

$('.remove-file-execute').click(function()
{
    var file = $(this).parent().parent().find('.modal-body span').text();
    $.post('/file_handler/remove', {file: file}, function(data)
    {
        var message = $.parseJSON(data);
        $('#modal_remove').modal('hide');

        if (message.status === 'success') {
            $('.alert b').html('Success!');
            $('.alert span').html('File <b>' + file + '</b> was removed.');
            $('.alert').addClass('alert-success').show().autoClose();

            $('[data-path="' + file + '"]').parent().remove();
            var fileCount = $('.btn-group .btn-default .badge').text();
            $('.btn-group .btn-default .badge').text(fileCount -1);
        } else {
            $('.alert b').html('Fail!');
            $('.alert span').html(message.message);
            $('.alert').addClass('alert-danger').show().autoClose();
        }
    });
});
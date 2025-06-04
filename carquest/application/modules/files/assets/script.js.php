<script type="text/javascript">
    //Preview
    $(document).on("click", ".preview_file_note", function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'admin/files/preview',
            type: "POST",
            dataType: "text",
            data: {id: id},
            beforeSend: function () {
                $('#ajax_pop_up_preview').html(`<div class="ajax_processing">
                    <p class="processing text-left">Processing...</p></div>`);
            },
            success: function (msg) {
                setTimeout(function () {
                    $('#ajax_pop_up_preview').html(msg);
                }, 500);
            }
        });
        $('#preview').modal('show');
    });   
</script>
@section('d-scripts')
    <script>
        $('#fetch-btn').on('click', function () {
            var $button = $(this);
            $.ajax({
                url: $button.data('action'),
                type: 'GET',
                data: {
                    url: $('input[name="url"]').val(),
                },
                beforeSend: function () {
                    $button.prop('disabled', true).addClass('disabled');
                },
                success: function (content) {
                    $('#fields-wrapper').html(content['view']);
                    // $attributeIdSelect.select2("val", "0");
                    $button.prop('disabled', false).removeClass('disabled');
                    $('.select2').select2();
                },
                error: function (content) {
                    $button.prop('disabled', false).removeClass('disabled');
                    alert(content.responseJSON["message"]);
                }
            });

        })
    </script>
@endsection

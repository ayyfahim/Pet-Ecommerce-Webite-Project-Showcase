@section('d-scripts')
    <script>
        $(document).on('click', '.delete-option-button', function () {
            $(this).parent().parent().parent().remove();
        });

        function addOption($button) {
            var action = $button.data('action');
            var attribute_id = 0;
            if ($button.data('attribute_id')) {
                attribute_id = $button.data('attribute_id');
            }
            var $optionsWrapper = $('.options-wrapper');
            var index = parseInt($('input[name="index"]').val()) + 1;
            var configuration_index = parseInt($('input[name="configuration_index"]').val()) + 1;
            $.ajax({
                url: action,
                type: 'GET',
                data: {index: index, configuration_index: configuration_index, attribute_id: attribute_id},
                beforeSend: function () {
                    $button.prop('disabled', true).addClass('disabled');
                },
                success: function (content) {
                    $button.prop('disabled', false).removeClass('disabled');
                    if (attribute_id) {
                        $button.parent().before(content);
                    } else {
                        $optionsWrapper.append(content);
                    }
                    altair_md.inputs();
                    if (attribute_id) {
                        altair_forms.select_elements();
                    }
                    $('input[name="index"]').val(index);
                    $('input[name="configuration_index"]').val(configuration_index);
                },
                error: function () {
                    $button.prop('disabled', false).removeClass('disabled');
                    alert("Something wrong happen. Please try again later");
                }
            });
        }

        $('.add-option-button').on('click', function () {
            addOption($(this));
        });
    </script>
@endsection

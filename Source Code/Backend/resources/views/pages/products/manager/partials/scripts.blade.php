@section('d-scripts')
    <script src="{{asset('assets/admin/js/tree-select.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".tree-select").treeMultiselect({
                collapsible: true,
                hideSidePanel: true,
                // maxSelections: 1,
                sectionDelimiter: '/',
                startCollapsed: true,
                searchable: true,
                onChange: function () {
                    var selectedOptions = $(".tree-select").val();
                    var elements = [];
                    for (var i = 0; i < selectedOptions.length; i++) {
                        var value = selectedOptions[i];
                        var text = $('.tree-select option[value="' + value + '"]').data('path');
                        var element = "<div class='category-value'>" + text + "</div>";
                        elements.push(element);
                    }
                    $('.categories-text').html(elements);
                }
            });
        });
    </script>
    <script>
        var $configurationsWrapper = $('.configurations-wrapper');
        $(document).on('click', '.delete-option-button', function () {
            var $deleteBtn = $(this);
            var optionId = $deleteBtn.data('option_id');
            if (optionId) {
                var optionHTML = '<input type="hidden" name="options_to_delete[]" value="' + optionId + '">';
                $configurationsWrapper.append(optionHTML);
            }
            $deleteBtn.parent().parent().remove();
        });
        $(document).on('click', '.delete-variation-button', function () {
            var $deleteBtn = $(this);
            var variationId = $deleteBtn.data('variation_id');
            if (variationId) {
                var variationHTML = '<input type="hidden" name="variations_to_delete[]" value="' + variationId + '">';
                $(".variations-items-wrapper").append(variationHTML);
            }
            $('.variation-item[data-variation_id="' + variationId + '"]').remove();
        });
        $(document).on('click', '.delete-media-btn', function () {
            var $deleteBtn = $(this);
            var mediaId = $deleteBtn.data('media_id');
            if (mediaId) {
                var mediaHTML = '<input type="hidden" name="media_to_delete[]" value="' + mediaId + '">';
                $(".gallery-wrapper").append(mediaHTML);
                $('.media-item[data-media_id="' + mediaId + '"]').remove();
            } else {
                $deleteBtn.parent().parent().parent().remove();
            }
        });

        function addOption($button) {
            var action = $button.data('action');
            var attribute_id = $button.data('attribute_id');
            var attribute_key = $button.data('attribute_key');
            var $optionsWrapper = $('.options-wrapper');
            var index = parseInt($('input[name="index"]').val()) + 1;
            var configuration_index = parseInt($('input[name="configuration_index"]').val()) + 1;
            $.ajax({
                url: action,
                type: 'GET',
                data: {
                    index: index,
                    configuration_index: configuration_index,
                    attribute_id: attribute_id,
                    attribute_key: attribute_key
                },
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
                    $('input[name="index"]').val(index);
                    $('input[name="configuration_index"]').val(configuration_index);
                },
                error: function () {
                    $button.prop('disabled', false).removeClass('disabled');
                    alert("Something wrong happen. Please try again later");
                }
            });
        }

        $(document).on('click', '.add-option-button', function (e) {
            addOption($(this));
        });
        $(document).on('click', '.select-variation-image-button', function (e) {
            $("#variationMediaModal").data('variation_id', $(this).data('id'));

        });
        $(document).on('click', 'button#attributes-assign-attribute', function (e) {
            let $button = $(this);
            let $attributeIdSelect = $('select#attributes-attribute-id');
            let attribute_id = $attributeIdSelect.val();
            var index = parseInt($('input[name="index"]').val());
            $.ajax({
                url: $button.data('action'),
                type: 'GET',
                data: {
                    product_id: $button.data('product_id'),
                    attribute_id: attribute_id,
                    index: index,
                },
                beforeSend: function () {
                    $button.prop('disabled', true).addClass('disabled');
                },
                success: function (content) {
                    $button.parent().parent().before(content['view']);
                    $('input[name="index"]').val(index + 1);
                    $attributeIdSelect.select2("val", "0");
                    $button.prop('disabled', false).removeClass('disabled');
                },
                error: function (content) {
                    $button.prop('disabled', false).removeClass('disabled');
                    alert(content.responseJSON["message"]);
                }
            });

        });
        $(document).on('click', '#variationMediaModal .variation-image', function (e) {
            let $imageContainer = $(this);
            let $image = $imageContainer.find('img');
            let $modal = $imageContainer.parent().parent().parent().parent();
            let variation_id = $modal.data('variation_id');
            let id = $imageContainer.data('id');
            let $variationContainer = $('[data-variation_id="' + variation_id + '"]');
            $variationContainer.find('img').attr('src', $image.attr('src')).removeClass('d-none');
            $variationContainer.find('input.media_id').val(id);
            $modal.modal('hide');
        });
    </script>
    <script>
        $('.inputtags').tagsinput({
            confirmKeys: [13, 188]
        });
    </script>
    <script>
        var $region = $('select[name="region"]');
        var $country = $('select[name="country_id"]');
        var $cities = $('select.cities');
        $region.on('change', function () {
            getCountries($(this).val());
        });

        function getCountries(region) {
            $.ajax({
                url: "{{route('product.admin.voucher.countries')}}",
                type: 'GET',
                data: {
                    region: region
                },
                beforeSend: function () {
                    $country.html('');
                    $cities.html('');
                },
                success: function (content) {
                    var data = [
                        {
                            id: '',
                            text: ''
                        }
                    ];
                    content['data'].forEach(function (item, index) {
                        console.log(item);
                        data.push({
                            id: item['id'],
                            text: item['name']
                        });
                    });
                    console.log(data);
                    $country.select2({
                        theme: "bootstrap",
                        placeholder: $(this).data('placeholder'),
                        containerCssClass: ":all:",
                        data: data
                    });
                },
                error: function (content) {

                }
            });
        }

        $country.on('change', function () {
            getCities($(this).val());
        });

        function getCities(country_id) {
            $.ajax({
                url: "{{route('product.admin.voucher.cities')}}",
                type: 'GET',
                data: {
                    country_id: country_id
                },
                beforeSend: function () {
                    $cities.html('');
                },
                success: function (content) {
                    var data = [
                        {
                            id: '',
                            text: ''
                        }
                    ];
                    content['data'].forEach(function (item, index) {
                        console.log(item);
                        data.push({
                            id: item['name'],
                            text: item['name']
                        });
                    });
                    console.log(data);
                    $cities.select2({
                        theme: "bootstrap",
                        placeholder: $(this).data('placeholder'),
                        containerCssClass: ":all:",
                        maximumSelectionSize: 6,
                        data: data
                    });
                },
                error: function (content) {

                }
            });
        }
    </script>
@endsection

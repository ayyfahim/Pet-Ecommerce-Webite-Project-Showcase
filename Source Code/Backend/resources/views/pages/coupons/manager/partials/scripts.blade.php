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
                        var text = $('.tree-select option[value="' + value + '"]').text();
                        var element = "<div class='category-value'>" + text + "</div>";
                        elements.push(element);
                    }
                    $('.categories-text').html(elements);
                }
            });
        })
    </script>
@endsection

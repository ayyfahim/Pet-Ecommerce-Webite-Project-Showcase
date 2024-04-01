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
    <script>
        $(function () {
            altair_form_adv.date_range()
        }), altair_form_adv = {
            date_range: function () {
                var t = $("#uk_dp_start"), e = $("#uk_dp_end"), i = UIkit.datepicker(t, {format: "YYYY-MM-DD"}),
                    n = UIkit.datepicker(e, {format: "YYYY-MM-DD"});
                t.on("change", function () {
                    n.options.minDate = t.val(), setTimeout(function () {
                        e.focus()
                    }, 300)
                }), e.on("change", function () {
                    i.options.maxDate = e.val()
                })
            }
        };
    </script>
@endsection

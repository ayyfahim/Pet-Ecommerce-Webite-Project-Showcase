@section('d-scripts')
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

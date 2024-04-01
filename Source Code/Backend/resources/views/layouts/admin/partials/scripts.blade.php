<script src="{{asset('assets/admin/js/app.js')}}"></script>
<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
<script src="https://cdn.tiny.cloud/1/5xh6x4d1wqq4jy99nwy4afaru9vf6kshss8skxwm59fgjmzo/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
<script>
    $(document).ready(function () {
        if ($('.tinymce-text').length) {
            var upload_route = "{{route('media.store')}}";
            tinymce.init({
                selector: '.tinymce-text',
                images_upload_url: upload_route,
                file_picker_types: 'image',
                force_br_newlines : true,
                force_p_newlines : false,
                forced_root_block : '',
                plugins: [
                    "advlist autolink link code image lists charmap print preview hr anchor pagebreak spellchecker',\n" +
                    "            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',\n" +
                    "            'save table contextmenu directionality emoticons template paste textcolor",
                ],
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            });
            tinymce.activeEditor.uploadImages(function (success) {
                $.post(upload_route, tinymce.activeEditor.getContent()).done(function () {
                });
            });
        }
    });
</script>

@yield('scripts')

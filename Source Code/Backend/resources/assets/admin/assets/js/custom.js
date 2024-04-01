document.addEventListener("DOMContentLoaded", init, false);
var arrCounter = 0;

var filesCounterAlertStatus = false;

var maxSize = 5000;

function init() {
    document.querySelectorAll('.files').forEach(item => {
        item.addEventListener("change", handleFileSelect, false);
    })
}

// $(document).on('change', '.files', function (e) {
//     handleFileSelect(e);
// });

//the handler for file upload event
function handleFileSelect(e) {
    var wrapperClass = $(e.target).data("wrapper");
    var counter = parseInt($(e.target).data("count"));
    var isProduct = $(e.target).data("product");
    var $wrapper = $(wrapperClass);
    var isMultiple = $(e.target).prop('multiple');
    //to make sure the user select file/files
    if (!e.target.files) return;

    //To obtaine a File reference
    var files = e.target.files;
    $(wrapperClass + " .img-preview.new").remove();
    $(wrapperClass + " .media-item.new").remove();
    // Loop through the FileList and then to render image files as thumbnails.
    for (var i = 0, f; (f = files[i]); i++) {
        //instantiate a FileReader object to read its contents into memory
        var fileReader = new FileReader();

        // Closure to capture the file information and apply validation.
        fileReader.onload = (function (readerEvt) {
            return function (e) {
                //Apply the validation rules for attachments upload
                // ApplyFileValidationRules(readerEvt);

                //Render attachments thumbnails.
                RenderThumbnail(e, readerEvt, $wrapper, isMultiple, isProduct, counter);
                counter++;
            };
        })(f);

        // Read in the image file as a data URL.
        // readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
        // More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
        fileReader.readAsDataURL(f);
    }
    document.querySelectorAll('.files').forEach(item => {
        item.addEventListener("change", handleFileSelect, false);
    })
}

//To remove attachment once user click on x button
$(function ($) {
    $(document).on("click", ".img-remove", function () {
        var $button = $(this);
        var mediaId = $button.data('id');
        var $wrapper = $($button.data('wrapper'));
        var $input = '<input name="media_to_delete[]" type="hidden" value="' + mediaId + '">';
        $button.parent().parent().remove();
        $wrapper.append($input);
    });
});

//Apply the validation rules for attachments upload
function ApplyFileValidationRules(readerEvt) {
    //To check file type according to upload conditions
    if (CheckFileType(readerEvt.type) == false) {
        alert(
            "The file (" +
            readerEvt.name +
            ") does not match the upload conditions, You can only upload jpg/png/gif files"
        );
        e.preventDefault();
        return;
    }

    //To check file Size according to upload conditions
    if (CheckFileSize(readerEvt.size) == false) {
        alert(
            "The file (" +
            readerEvt.name +
            ") does not match the upload conditions, The maximum file size for uploads should not exceed " + (maxSize / 1000) + " MB"
        );
        e.preventDefault();
        return;
    }
}

//To check file type according to upload conditions
function CheckFileType(fileType) {
    if (fileType == "image/jpeg") {
        return true;
    } else if (fileType == "image/png") {
        return true;
    } else if (fileType == "image/gif") {
        return true;
    } else {
        return false;
    }
    return true;
}

//To check file Size according to upload conditions
function CheckFileSize(fileSize) {
    if (fileSize < maxSize * 100) {
        return true;
    } else {
        return false;
    }
    return true;
}

//Render attachments thumbnails.
function RenderThumbnail(e, readerEvt, $wrapper, isMultiple, isProduct, counter) {
    var thumbHTML = "";
    if (CheckFileType(readerEvt.type) == false) {
        thumbHTML = '<div class="img-preview new text-center">\n' +
            '                            <div class="filename">' + readerEvt.name + '</div>\n' +
            '                        </div>';
    } else {
        if (isProduct) {
            thumbHTML = '<div class="media-item new">\n' +
                '    <div class="row">\n' +
                '        <div class="col-md-2 text-center mb-4">\n' +
                '                <img width="100" height="80" src="' + e.target.result + '" alt="">\n' +
                '        </div>\n' +
                '        <input type="hidden" name="gallery[index][]" value="' + counter + '">' +
                '        <div class="col-md-6 text-center pt-2">\n' +
                '                <input class="form-control"\n' +
                '                       value="' + readerEvt.name.split('.')[0] + '"\n' +
                '                       name="gallery[alt][]"/>\n' +
                '        </div>\n' +
                '        <div class="col-md-4 text-center pt-2">\n' +
                '            <div class="custom-control custom-checkbox d-inline-block mr-1">\n' +
                '                <input type="radio" class="custom-control-input" name="main" value="' + counter + '"\n' +
                '                       id="media-main-' + counter + '">\n' +
                '                <label class="custom-control-label" for="media-main-' + counter + '">Main</label>\n' +
                '            </div>\n' +
                // '            <button type="button" class="btn btn-danger delete-media-btn btn-xs mt-2">\n' +
                // '                Delete\n' +
                // '            </button>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <hr>\n' +
                '</div>';
        } else {

            thumbHTML = '<div class="img-preview new text-center">\n' +
                '                            <img data-id="' + readerEvt.name + '" src="' + e.target.result + '" alt="">\n' +
                '                        </div>';
        }
    }
    if (isMultiple) {
        $wrapper.append(thumbHTML);
    } else {
        $wrapper.html(thumbHTML);
    }
}
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

var $appointemntCardContainer = null;

/**
 * function to get errors and handle them.
 * array of selectors
 * @param error
 * @param selectors
 * @param fields
 */
function error_handler(error, fields, selectors) {
    var error_text = "";
    $(selectors).each(function (index, item) {
        if (fields[index].indexOf("[]") != -1) {
            fields[index] = fields[index].replace('[]', '');
        }
        if (error.hasOwnProperty(fields[index])) {
            error_text = error[fields[index]];
            $(item).addClass("is-invalid");
            $(item).siblings('.invalid-feedback').text(error_text).show();
        } else {
            error_text = "";
            if ($(item).hasClass('is-invalid')) {
                $(item).removeClass("is-invalid").addClass('is-valid');
                $(item).siblings('.invalid-feedback').text(error_text).show();
            }
        }
    });
}

/**
 * function to empty out the error labels
 * @param selectors
 */
function empty_errors(selectors) {
    for (var i = 0; i < selectors.length; i++) {
        $(selectors[i]).removeClass("is-invalid");
        $(selectors[i]).siblings('.invalid-feedback').html("");
    }
}

/**
 * function to take selector and print out the text on it
 * @param selector
 * @param text
 * @param type
 */
function PrintOnSelector(selector, text) {
    $(selector).html(text);
}

function tellme(data) {
    w = window.open('', 'newwinow', 'width=800,height=600,menubar=1,status=0,scrollbars=1,resizable=1');
    d = w.document.open("text/html", "replace");
    d.writeln(data['responseText']);
}

/**
 * Prepare form data to send ajax request
 */
$(document).on("submit", "form.ajax", function (e) {
    e.preventDefault();
    // tinyMCE.triggerSave();
    var form = $(this);
    var form_id = form.attr('id');
    var url = form.attr("action");
    var type = form.attr("method");
    var scroll_to_top = 1;
    if (this.hasAttribute('data-scroll'))
        scroll_to_top = 0;
    var contentType = "application/x-www-form-urlencoded; charset=UTF-8";
    var cache = false;
    var processData = true;
    var new_tab = 0;
    if (form.data("new_tab"))
        new_tab = 1;
    var $viewWrapper = 0;
    var $viewAppendWrapper = 0;
    var $keyInput = 0;
    if (form.data('view-wrapper')) {
        $viewWrapper = $(form.data('view-wrapper'));
    } else if (form.data('table') && form.data('append')) {
        $viewAppendWrapper = $(form.data('table'));
        $keyInput = form.children('input[name="key"]');
    } else if (form.data('append-view-wrapper') && form.data('append')) {
        $viewAppendWrapper = $(form.data('append-view-wrapper'));
    }
    if (form.attr('enctype') === "multipart/form-data") {
        var data = new FormData(this);
        console.log(data);
        contentType = false;
        processData = false;
    } else {
        var data = form.serialize();
    }
    var fields = [];
    var selectors = [];
    $('#' + form_id + ' input, #' + form_id + ' select, #' + form_id + ' textarea').each(
        function () {
            var input = $(this);
            if (input.attr('type') !== "hidden" && input.attr('name')) {
                fields.push(input.attr('name'));
                selectors.push(input);
            }
        }
    );
    ajax_request(form, url, type, data, contentType, cache, processData, fields, selectors, scroll_to_top, null, null, new_tab, $viewWrapper, $viewAppendWrapper, $keyInput)
});

/**
 * Prepare form data to send ajax request
 */
$(document).on('click', '.ajax_without_form', function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.data("action");
    var type = form.data("method");
    var reload = 0;
    if (form.data('reload'))
        reload = 1;
    form.data().key++;
    var data_attributes = form.data();
    var data = {};
    data['_token'] = $('meta[name="csrf-token"]').attr('content');
    for (var key in data_attributes) {
        if (key !== "action" && key !== "method" && key !== "reload") {
            data[key] = data_attributes[key];
        }
    }
    var contentType = "application/x-www-form-urlencoded; charset=UTF-8";
    var cache = false;
    var processData = true;
    var fields = [];
    var selectors = [];
    var callback_success = 0;
    var new_tab = 0;
    if (form.data("new_tab"))
        new_tab = 1;
    var $viewWrapper = 0;
    var $viewAppendWrapper = 0;
    var $keyInput = 0;
    if (form.data('view-wrapper')) {
        $viewWrapper = $(form.data('view-wrapper'));
    } else if (form.data('table') && form.data('append')) {
        $viewAppendWrapper = $(form.data('table'));
        $keyInput = form.children('input[name="key"]');
    } else if (form.data('append-view-wrapper') && form.data('append')) {
        $viewAppendWrapper = $(form.data('append-view-wrapper'));
    }
    if (!reload) {
        callback_success = function () {
            console.log("callback success");
            form.siblings("a.card-fav").removeClass('d-none');
            form.addClass("d-none");
            console.log("removed")
        }
    }
    ajax_request(form, url, type, data, contentType, cache, processData, fields, selectors, 0, null, null, new_tab, $viewWrapper, $viewAppendWrapper, $keyInput, form)
});

/**
 * Send ajax request
 */
function ajax_request(form, url, type, data, contentType, cache, processData, fields, selectors, scroll_to_top, callback_success, reload, new_tab, $viewWrapper, $viewAppendWrapper, $keyInput) {
    var $button = form.find("button[type='submit']");
    $button.prop('disabled', true).addClass('btn-progress');
    $.ajax({
        url: url,
        type: type,
        data: data,
        contentType: contentType,
        cache: cache,
        processData: processData,
        success: function (data) {
            $(".alerts-wrapper .alert-danger p").html("");
            $(".alerts-wrapper .alert-danger").addClass("d-none");
            empty_errors(selectors);
            var message = data['message'];
            // if (scroll_to_top)
            //   window.scrollTo(0, 0);
            $button.prop('disabled', false).removeClass('btn-progress');
            if (form.data('appointment-store') && $appointemntCardContainer) {
                $appointemntCardContainer.html(data['view']);
                $("#appointmentStoreModal").modal('hide');
                $("#appointmentStoreModal form input[name='patient_id']").val('');
                $("#appointmentStoreModal form input[name='q']").val('');
                return;
            } else if (form.data('appointment-destroy') == "1" && $appointemntCardContainer) {
                $appointemntCardContainer.html(data['view']);
                $("#confirmationModal").modal('hide');
                return;
            } else if (form.data('appointment-update') == "1" && $appointemntCardContainer) {
                $appointemntCardContainer.html(data['view']);
                $("#changeStatusModal").modal('hide');
                return;
            }
            if (data['view']) {
                if ($viewWrapper) {
                    $viewWrapper.html(data['view']);
                } else if ($viewAppendWrapper) {
                    $viewAppendWrapper.append(data['view']);
                    $('.modal').modal('hide');
                    if ($keyInput) {
                        $keyInput.val(parseInt($keyInput.val()) + 1);
                    }
                    $(".select2.rendered").each(function () {
                        $(this).select2();
                        $(this).removeClass('rendered');
                    });
                    $(".datepicker.rendered").each(function () {
                        console.log($(this));
                        $(this).daterangepicker({
                            locale: {format: 'DD-MM-YYYY'},
                            singleDatePicker: true,
                            autoUpdateInput: false,
                        });
                        $(this).on('apply.daterangepicker', function (ev, picker) {
                            $(this).val(picker.startDate.format('DD-MM-YYYY'));
                        });
                        $(this).removeClass('rendered');
                    });
                }
                return;
            }
            if (message) {
                var success_message_selector = $(".alerts-wrapper .alert-success p");
                PrintOnSelector(success_message_selector, message);
                $(".alerts-wrapper .alert-success").removeClass("d-none").show(0).delay(4000).fadeOut();
            }
            if (data['url']) {
                if (new_tab) {
                    window.open(data['url'], '_blank');
                } else {
                    setTimeout(function () {
                            location.href = data['url'];
                        }
                        , 700);
                }
            }
            if (reload) {
                setTimeout(function () {
                        location.reload();
                    }
                    , 700);
            }
            if (callback_success)
                callback_success();
        },
        error: function (data) {
            $(".alerts-wrapper .alert-success p").html("");
            $(".alerts-wrapper .alert-success").addClass("d-none");
            var message = data.responseJSON["message"];
            if (message) {
                var error_message_selector = $(".alerts-wrapper .alert-danger p");
                PrintOnSelector(error_message_selector, message);
                $(".alerts-wrapper .alert-danger").removeClass("d-none").show(0).delay(4000).fadeOut();
            }
            var errors = data.responseJSON["errors"];
            if (errors)
                error_handler(errors, fields, selectors);
            $button.prop('disabled', false).removeClass('btn-progress');
        }
    });
}

$(document).on('click', '.alerts-wrapper .alert button.close', function () {
    $(this).parent().parent().addClass('d-none');
});

$(document).on('click', '.confirm-action-button', function (e) {
    e.preventDefault();
    var action = $(this).data('action');
    var label = $(this).data("label");
    if (this.hasAttribute("data-method")) {
        $("#confirmationModal form").attr('method', $(this).data('method'));
    }
    if (this.hasAttribute("data-appointment-destroy")) {
        $appointemntCardContainer = $(this).parent().parent().parent().parent().parent().parent().parent().parent();
        $("#confirmationModal form").attr('data-appointment-destroy', 1);
    }
    if (this.hasAttribute("data-custom_method")) {
        $("#confirmationModal form input[name='_method']").remove();
        $("#confirmationModal form").prepend($(this).data('custom_method'));
    }
    if (this.hasAttribute("data-append-input")) {
        var name = $(this).data('field_name');
        var value = $(this).data('field_value');
        input_to_generate = "<input class='removableInput' type='hidden' " +
            "name='" + name +
            "' value='" + value + "'/>";
        $("#confirmationModal form input[name='" + name + "']").remove();
        $("#confirmationModal form").prepend(input_to_generate);
    }
    if (label)
        $("#confirmationModal p").text(label);
    $("#confirmationModal form").attr("action", action);
    $("#confirmationModal").modal('show');
});

function cleanConfirmationModal() {
    $('#confirmationModal input.removableInput').remove();
}

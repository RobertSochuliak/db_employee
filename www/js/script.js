var basePath = "";
$(document).ready(function () {
    if ($(window).width() < 1600) {
        $('.page-sidebar-fixed').addClass('page-sidebar-minified');
    } else {
        $('.page-sidebar-fixed').removeClass('page-sidebar-minified');
    }
});

function sendRequest(url, method = 'GET', data, success = null, error = null, callback, element = null) {
    var req_url = url;
    var req_method = method;
    var req_data = data;

    const getCircularReplacer = () => {
        const seen = new WeakSet;
        return (key, value) => {
            if (typeof value === "object" && value !== null) {
                if (seen.has(value)) {
                    return;
                }
                seen.add(value);
            }
            return value;
        };
    };
    $.ajax({
        url: req_url,
        type: req_method,
        data: {dataRequest: JSON.stringify(req_data, getCircularReplacer())},
        success: function (response) {
            var dataResponse = JSON.parse(response);
            if (dataResponse.response) {
                if (success == null && error == null) {
                    if (typeof callback == "function" && element != null) {
                        callback(dataResponse.data, element);
                    } else if (typeof callback == "function") {
                        callback(dataResponse.data);
                    }
                } else {
                    if (typeof callback == "function" && element != null) {
                        callback(dataResponse.data, element);
                    } else if (typeof callback == "function") {
                        callback(dataResponse.data);
                    }
                    if (success != null){
                        swal(success.title, success.desc, "success").then(function(){
                            if (typeof success.callback == "function") {
                                success.callback(dataResponse.data);
                            }
                        });
                    }
                }
            } else {
                if (success == null && error == null) {
                    if (typeof callback == "function" && element != null) {
                        callback(dataResponse.data, element);
                    } else if (typeof callback == "function") {
                        callback(dataResponse.data);
                    }
                } else {
                    if (typeof callback == "function" && element != null) {
                        callback(dataResponse.data, element);
                    } else if (typeof callback == "function") {
                        callback(dataResponse.data);
                    }
                    swal(error.title, (dataResponse.data) ? dataResponse.data : error.desc, "error");
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}

function clearFormDataAction(element) {
    $(element).attr('data-action', 'select');
}

function sendRequestQuestion(question, confirm, cancel, callback, text = null) {
    swal({
        title: question,
        text: text,
        icon: "warning",
        buttons: {
            cancel: {
                text: cancel,
                value: null,
                visible: true,
                className: 'btn btn-default',
                closeModal: true,
            },
            confirm: {
                text: confirm,
                value: true,
                visible: true,
                className: 'btn btn-warning',
                closeModal: true
            }
        }
    })
        .then((value) => {
            if (value) {
                if (typeof callback == "function") {
                    callback();
                }
            }
        });
}

function clearFromInputs(form) {
    $(form).find('.form-group input').val("");
    $(form).find('.form-group textarea').val("");
}

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}
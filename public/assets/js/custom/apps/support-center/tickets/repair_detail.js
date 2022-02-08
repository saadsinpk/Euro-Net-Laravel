"use strict";

// Class definition
var KTTicket = function() {
    var submitButton;
    var validator;
    var form;
    var form_ship;
    var modalEl;

    // Init form inputs
    var initForm = function() {
        // Ticket attachments
        // For more info about Dropzone plugin visit: https: //www.dropzonejs.com/#usage
        if ( $("#shipping_attachments").length > 0){
            var myDropzone = new Dropzone("#shipping_attachments", {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/fileUpload", // Set the url for your upload script location
                paramName: "file", // The name that will be used to transfer the file
                maxFiles: 1,
                maxFilesize: 999999, // MB
                addRemoveLinks: true,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },

                removedfile: function(file) {
                    var name = file.upload.filename;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '/uploadedFile-remove',
                        data: { filename: name },
                        success: function(data) {
                            console.log("File has been successfully removed!!");
                            console.log(form_ship.querySelectorAll("input[type='hidden']"))
                            console.log(name);
                            form_ship.querySelectorAll("input[type='hidden']").forEach(e => {
                                if (e.value == name) {
                                    e.remove();
                                }
                            });
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
                success: function(file, response) {
                    console.log(response);
                    console.log(response.file_name);
                    $(form_ship).append("<input type='hidden' name='file_name' value='" + response.file_name + "'>");
                },
                error: function(file, response) {
                    return false;
                }
            });
        }

        if ( $("#attachments").length > 0){
            var myDropzone_ship = new Dropzone("#attachments", {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/fileUpload", // Set the url for your upload script location
                paramName: "file", // The name that will be used to transfer the file
                maxFiles: 10,
                maxFilesize: 999999, // MB
                addRemoveLinks: true,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },

                removedfile: function(file) {
                    var name = file.upload.filename;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '/uploadedFile-remove',
                        data: { filename: name },
                        success: function(data) {
                            console.log("File has been successfully removed!!");
                            console.log(form.querySelectorAll("input[type='hidden']"))
                            console.log(name);
                            form.querySelectorAll("input[type='hidden']").forEach(e => {
                                if (e.value == name) {
                                    e.remove();
                                }
                            });
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
                success: function(file, response) {
                    console.log(response);
                    console.log(response.file_name);
                    $(form).append("<input type='hidden' name='file_name[]' value='" + response.file_name + "'>");
                },
                error: function(file, response) {
                    return false;
                }
            });
        }
    }

    // Handle form validation and submittion
    var handleForm = function() {
        validator = FormValidation.formValidation(
            form, {
                fields: {
                    description: {
                        validators: {
                            notEmpty: {
                                message: 'Description is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Action buttons
        submitButton.addEventListener('click', function(e) {
            console.log("test");
            e.preventDefault();
            var formdata = $(form).serialize();
            var url = $(form).attr("action");
            // Validate form before submit
            if (validator) {
                validator.validate().then(function(status) {

                    if (status == 'Valid') {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: url,
                            method: "POST",
                            data: formdata,
                            dataType: "JSON",
                            success: function() {
                                submitButton.setAttribute('data-kt-indicator', 'on');

                                // Disable button to avoid multiple click 
                                submitButton.disabled = true;

                                setTimeout(function() {
                                    submitButton.removeAttribute('data-kt-indicator');

                                    // Enable button
                                    submitButton.disabled = false;

                                    // Show success message. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                    Swal.fire({
                                        text: "Form has been successfully submitted!",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function(result) {
                                        if (result.isConfirmed) {
                                            form.reset();
                                            window.location.reload();
                                        }
                                    });
                                }, 2000);
                            }
                        }).catch(function(error) {
                            if (error.status == 422) {
                                Swal.fire({
                                    text: "The email has already been taken.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            } else {
                                Swal.fire({
                                    text: "Somethings went wrong. Try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    } else {
                        // Show error message.
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });

    }

    return {
        // Public functions
        init: function() {
            form = document.querySelector("#repair_form")
            form_ship = document.querySelector("#ship_form")
            submitButton = form.querySelector("[type='submit']")
            handleForm();
            initForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTTicket.init();
});
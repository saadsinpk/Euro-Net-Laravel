"use strict";

// Class definition
var KTTicket_notes = function() {
    var submitButton_notes;
    var validator;
    var form;
    var modalEl;

    // Init form inputs
    var initForm_notes = function() {
        // Ticket attachments
        // For more info about Dropzone plugin visit: https: //www.dropzonejs.com/#usage
        var myDropzone = new Dropzone("#attachments_notes", {
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
                $(form).append("<input type='hidden' name='file_name[]' value='" + response.file_name + "'>");
            },
            error: function(file, response) {
                return false;
            }
        });
    }

    // Handle form validation and submittion
    var handleForm_notes = function() {
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
        submitButton_notes.addEventListener('click', function(e) {
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
                                submitButton_notes.setAttribute('data-kt-indicator', 'on');

                                // Disable button to avoid multiple click 
                                submitButton_notes.disabled = true;

                                setTimeout(function() {
                                    submitButton_notes.removeAttribute('data-kt-indicator');

                                    // Enable button
                                    submitButton_notes.disabled = false;

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
            form = document.querySelector("#repair_notes_form")
            submitButton_notes = form.querySelector("[type='submit_notes']")
            handleForm_notes();
            initForm_notes();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTTicket_notes.init();
});
"use strict";

// Class definition
var KTModalUpdateAdmin = function() {
    var element;
    var submitButton;
    var cancelButton;
    var closeButton;
    var form;
    var modal;
    var validator;

    // Init form inputs
    var initForm = function() {

        validator = FormValidation.formValidation(
            form, {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Admin name is required'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Admin email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            },
                        }
                    }
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
            // Prevent default button action

            e.preventDefault();
            console.log
            if (validator) {
                validator.validate().then(function(status) {

                    var url = $("#kt_modal_update_admin_form").attr("action");
                    var formData = new FormData();

                    var id = $("#id").val();
                    var avatar = $("#avatar")[0].files[0];
                    var name = $("#name").val();
                    var email = $("#email").val();

                    formData.append("id", id);
                    formData.append("name", name);
                    formData.append("email", email);

                    if (avatar != undefined) {
                        formData.append("avatar", avatar);
                    }

                    if (status == 'Valid') {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: url,
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function() {
                                // Show loading indication
                                submitButton.setAttribute('data-kt-indicator', 'on');

                                // Simulate form submission
                                setTimeout(function() {
                                    // Simulate form submission
                                    submitButton.removeAttribute('data-kt-indicator');

                                    // Show popup confirmation 
                                    Swal.fire({
                                        text: "Form has been successfully submitted!",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function(result) {
                                        form.reset(); // Reset form	
                                        if (result.isConfirmed) {
                                            modal.hide();
                                            window.location.reload();
                                        }
                                    });

                                    //form.submit(); // Submit form
                                }, 2000);
                            }
                        }).catch(function(error) {
                            console.log(error);
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
                    }
                })
            }
        });

        cancelButton.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    form.reset(); // Reset form	
                    modal.hide(); // Hide modal				
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

        closeButton.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    form.reset(); // Reset form	
                    modal.hide(); // Hide modal				
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });
    }

    return {
        // Public functions
        init: function() {
            // Elements
            element = document.querySelector('#kt_modal_update_admin');
            modal = new bootstrap.Modal(element);

            form = element.querySelector('#kt_modal_update_admin_form');
            submitButton = form.querySelector('#kt_modal_update_admin_submit');
            cancelButton = form.querySelector('#kt_modal_update_admin_cancel');
            closeButton = element.querySelector('#kt_modal_update_admin_close');

            initForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTModalUpdateAdmin.init();
});
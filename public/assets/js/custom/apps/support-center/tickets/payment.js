"use strict";

// Class definition
var KTModalPayment = function() {
    var submitButton;
    var cancelButton;
    var closeButton;
    var validator;
    var form;
    var modal;

    var url
    var formdata

    // Init form inputs

    var payment_form_update = function() {
        jQuery('#payment_update_form').click(function() {
            Swal.fire({
                text: "Do you want to update payment detail?",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Yes!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    jQuery('input[name="update_payment"]').trigger("click");
                }
            });
        });
    }
    var handleForm = function() {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form, {
                fields: {
                    'amount': {
                        validators: {
                            notEmpty: {
                                message: 'Amount name is required'
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
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function(status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        formdata = $(form).serialize();


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

                                // Disable submit button whilst loading
                                submitButton.disabled = true;

                                setTimeout(function() {
                                    submitButton.removeAttribute('data-kt-indicator');

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
                                            // Hide modal
                                            form.reset();
                                            modal.hide();

                                            // Enable submit button after loading
                                            submitButton.disabled = false;

                                            if(formdata.id != '') {
                                                var newurl=window.location.href;
                                                var newurl_split=newurl.split('/edit')[0];
                                                window.location = newurl_split;
                                            } else {
                                                window.location.reload();
                                            }
                                            // Redirect to Admins list page
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

    var closeForm = () => {
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
        })
    }

    var handleSendRequest = () => {
        // Select all delete buttons
        const sendButton = document.querySelectorAll('[data-action ="send_payment"]');
        sendButton.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function(e) {
                e.preventDefault();
                $(form.querySelector("[name='repair_id']")).remove();
                $(form.querySelector("[name='user_id']")).remove();

                const repair_id = $(this).attr("data-id")
                const user_id = $(this).attr("data-user-id")
                console.log(repair_id);
                console.log(user_id);
                $(form).append("<input type='hidden' name='repair_id' value=" + repair_id + ">");
                $(form).append("<input type='hidden' name='user_id' value=" + user_id + ">");
            })
        });
    }

    $(document.body).on('click', '.delete_this' ,function(e){
        e.preventDefault();
        var thishref = $(this).attr("href");
        Swal.fire({
            text: "Are you sure you want to delete?",
            icon: "success",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Yes delete it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-primary"
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                window.location.replace(thishref);
            }
        });
        return false;
    });

    const updateStatus = () => {
        // $(document.querySelector('[name="status"]')).select2({ width: '200px' });
        const statusButtons = document.querySelectorAll('[name="status"]');

        // statusButtons.forEach(d => {
            $(document).on("change", '[name="status"]', function(e){
                e.preventDefault();
                const status = this.value;
                const id = $(this).attr("data-id");
                var main_this = jQuery(this);
                console.log(status);
                console.log(id);

                Swal.fire({
                    text: "Are you sure you want to change status?",
                    icon: "success",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes Change it!",
                    cancelButtonText: "Cancel",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-primary"
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '/admin/repair/update-status/' + id + '/' + status + '',
                            method: "get",
                            data: formdata,
                            dataType: "JSON",
                            success: function() {
                                jQuery(main_this).closest("tr").find(".badge.mt-3").text(jQuery(main_this).closest("tr").find('[name="status"]').find(":selected").text());
                                jQuery(main_this).closest("tr").find(".badge.mt-3").attr("style","background:"+jQuery(main_this).closest("tr").find('[name="status"]').find(":selected").attr("data-color")+"; top: -1rem; left: 1rem;");
                                jQuery(main_this).closest("tr").remove();
                            }
                        })
                    }
                });

            })
        // })
    }

    return {
        // Public functions
        init: function() {
            modal = new bootstrap.Modal(document.querySelector('#kt_payment_modal'));

            form = document.querySelector('#kt_payment_modal form');

            submitButton = form.querySelector('[data-action="submit"]');
            cancelButton = form.querySelector('[data-action="cancel"]');
            closeButton = form.querySelector('[data-action="close"]');
            url = $(form).attr("action");
            handleForm();
            payment_form_update();
            closeForm();
            updateStatus();
            handleSendRequest();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTModalPayment.init();
});
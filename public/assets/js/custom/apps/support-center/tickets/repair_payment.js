"use strict";

// Class definition
var KTModalNewPayment = function() {
    var submitButton;
    var validator;
    var form;
    var datatable;
    var table


    var database = function() {
        // Set date data order
        var url = "/user/repair_payment/"
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url
            },
            columns: [{
                    data: 'number',
                    name: 'number',
                },
                {
                    data: 'problem',
                    name: 'problem',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    class: 'text-end'
                },
            ],
            "info": false,
            'order': [],

            'columnDefs': []
        });

        datatable.on('draw', function() {
            dropdownInstance();
        });
    }

    var dropdownInstance = () => {
        var items = document.querySelectorAll("a[data-kt-menu-trigger]");
        KTMenu.createInstances();
        $.each(items, function() {
            KTMenu.getInstance(this);

        })
    }

    // Handle form validation and submittion
    var handleForm = function() {

        validator = FormValidation.formValidation(
            form, {
                fields: {
                    'bitmain_id': {
                        validators: {
                            notEmpty: {
                                message: 'Category is required'
                            }
                        }
                    },
                    'problem': {
                        validators: {
                            notEmpty: {
                                message: 'Target description is required'
                            }
                        }
                    },
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Name is required'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            },
                        }
                    },
                    'phone': {
                        validators: {
                            notEmpty: {
                                message: 'Phone Number is required'
                            },
                            regexp: {
                                message: 'The phone number can only contain the digits, spaces, -, (, ), + and .',
                                regexp: /^[0-9\s\-()+\.]+$/
                            },
                            stringLength: {
                                min: 11,
                                max: 11,
                                message: 'The message must be 11 characters'
                            }
                        }
                    },
                    'serial_num': {
                        validators: {
                            notEmpty: {
                                message: 'Name is required'
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
            var formdata = $(form).serialize();
            $(form.querySelector('[name="bitmain_id"]')).on('change', function() {
                validator.revalidateField('bitmain_id');
            });
            console.log(validator)
            if (validator) {

                validator.validate().then(function(status) {

                    if (status == 'Valid') {

                        var url = $(form).attr("action");
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
                            success: function(res) {
                                submitButton.setAttribute('data-kt-indicator', 'on');

                                // Disable button to avoid multiple click 
                                submitButton.disabled = true;

                                setTimeout(function() {
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;

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
                                            $(form.querySelectorAll("select")).each(function() {
                                                $(this).val(null).trigger('change');
                                            })
                                            $(table).DataTable().ajax.reload();

                                        }
                                    });
                                }, 2000);
                            }
                        }).catch(function(error) {
                            Swal.fire({
                                text: "Somethings went wrong. Try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
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

            table = document.querySelector('#repair_payment_table');

            if ($("#user_id").val()) {
                database();
            }

            form = document.querySelector('#repair_payment_form');
            submitButton = form.querySelector('[type="submit"]');
            console.log(submitButton)
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTModalNewPayment.init();
});
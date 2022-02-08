"use strict";

// Class definition
var KTModalNewPayment = function() {
    var submitButton;
    var validator;
    var form;
    var datatable;
    var table;
    var table_2;
    var validator2;
    var validator1;

    var database = function() {
        // Set date data order
        var url = "/user/repair_shipping/"
        datatable = $(table_2).DataTable({
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
                    data: 'tracking_number',
                    name: 'tracking_number',
                },
                {
                    data: 'shipping_company',
                    name: 'shipping_company',
                },
                {
                    data: 'label',
                    name: 'label',
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

        var url = "/user/repair_payment/"
        datatable = $(table).DataTable({
            createdRow: function( row, data, dataIndex){
                if( data['last_admin_reply'] ==  `1`){
                    $(row).addClass('grayClass');
                }
            },
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
                    data: 'payment_method',
                    name: 'payment_method',
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

        validator2 = FormValidation.formValidation(
            form, {
                fields: {
                    'phone': {
                        validators: {
                            notEmpty: {
                                message: 'Phone is required'
                            }
                        }
                    },
                    'bitmain_id': {
                        validators: {
                            notEmpty: {
                                message: 'Bitmain is required'
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
                    'serial_num': {
                        validators: {
                            notEmpty: {
                                message: 'Name is required'
                            }
                        }
                    },
                    'street': {
                        validators: {
                            notEmpty: {
                                message: 'Street is required'
                            }
                        }
                    },
                    'city': {
                        validators: {
                            notEmpty: {
                                message: 'City is required'
                            }
                        }
                    },
                    'country': {
                        validators: {
                            notEmpty: {
                                message: 'Country is required'
                            }
                        }
                    },
                    'postalcode': {
                        validators: {
                            notEmpty: {
                                message: 'Postalcode is required'
                            }
                        }
                    },
                    'payment_method': {
                        validators: {
                            notEmpty: {
                                message: 'Payment method is required'
                            }
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

        validator1 = FormValidation.formValidation(
            form, {
                fields: {
                    'bitmain_id': {
                        validators: {
                            notEmpty: {
                                message: 'Bitmain is required'
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
                            }
                        }
                    },
                    'address': {
                        validators: {
                            notEmpty: {
                                message: 'Address is required'
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
                    'payment_method': {
                        validators: {
                            notEmpty: {
                                message: 'Payment method is required'
                            }
                        }
                    },
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            },
                            stringLength: {
                                min: 6,
                                message: 'The Password must be greater than 6 characters'
                            },
                            callback: {
                                message: 'Please enter valid password',
                                callback: function(input) {
                                    if (input.value.length > 0) {
                                        return validatePassword();
                                    }
                                }
                            }
                        }
                    },
                    'confirm-password': {
                        validators: {
                            notEmpty: {
                                message: 'The password confirmation is required'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
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

            if ($("#user_id").val()) {
                validator = validator2
            } else {
                validator = validator1
            }

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

                                            if ($("#user_id").val()) {
                                                form.reset();
                                                $(form.querySelectorAll("select")).each(function() {
                                                    $(this).val(null).trigger('change');
                                                })
                                                $(table).DataTable().ajax.reload();
                                            } else {
                                                location.href = "/login";
                                            }

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

            table = document.querySelector('#repair_payment_table');
            table_2 = document.querySelector('#repair_shipping_table');

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
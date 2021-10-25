"use strict";

// Class definition
var CustomerObj = function() {
    var submitButton;
    var cancelButton;
    var closeButton;
    var validator;
    var form;
    var modal;
    var url;

    // Init form inputs
    var handleForm = function() {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form, {
                fields: {
                    'card_name': {
                        validators: {
                            notEmpty: {
                                message: 'Card name is required'
                            },
                            stringLength: {
                                min: 3,
                                message: 'The Card Name must be greater than 3 characters'
                            }
                        }
                    },
                    'card-num': {
                        validators: {
                            notEmpty: {
                                message: 'Card Number is required'
                            },
                            stringLength: {
                                min: 19,
                                message: 'The Card Number must be greater than 19 characters'
                            }
                        }
                    },
                    'card_cvc': {
                        validators: {
                            notEmpty: {
                                message: 'CVC is required'
                            },
                        }
                    },
                    'card-expiry-month': {
                        validators: {
                            notEmpty: {
                                message: 'Expiration Month is required'
                            },
                        }
                    },

                    'card-expiry-year': {
                        validators: {
                            notEmpty: {
                                message: 'Expiration Year is required'
                            },
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

    var handleSubmit = () => {
        // Action buttons
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function(status) {

                    if (status == 'Valid') {
                        if (!$(form).data('cc-on-file')) {
                            e.preventDefault();
                            Stripe.setPublishableKey($(form).data('stripe-publishable-key'));
                            Stripe.createToken({
                                number: $('.card-num').val(),
                                cvc: $('.card-cvc').val(),
                                exp_month: $('.card-expiry-month').val(),
                                exp_year: $('.card-expiry-year').val()
                            }, stripeHandleResponse);
                        }
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

    var handlePayRows = () => {
        // Select all delete buttons
        const paymentMoalButton = document.querySelectorAll('[data-kt-table-filter="pay_modal_button"]');

        paymentMoalButton.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function(e) {
                e.preventDefault();
                $(form.querySelector("[name='id']")).remove();
                const parent = e.target.closest('tr');
                const amonut = parent.querySelectorAll('td')[2].innerText;
                const id = $(this).attr("data-id");

                $(form).append("<input type='hidden' name='id' value=" + id + ">");
                $(form.querySelector("#amount")).text(amonut);
                $(form.querySelector("[name='amount']")).val(amonut);
            })
        });
    }

    var stripeHandleResponse = (status, response) => {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

    return {
        // Public functions
        init: function() {

            modal = new bootstrap.Modal(document.querySelector('#kt_payment_modal'));
            form = document.querySelector('#kt_payment_modal form');
            submitButton = form.querySelector('[data-action="submit"]');
            console.log(submitButton)
            cancelButton = form.querySelector('[data-action="cancel"]');
            closeButton = form.querySelector('[data-action="close"]');

            handleForm();
            handleSubmit();
            closeForm();
            handlePayRows();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    CustomerObj.init();
});

// $(function() {
//     var $form = $(".validation");
//     $('form.validation').bind('submit', function(e) {
//         var $form = $(".validation"),
//             inputVal = ['input[type=email]', 'input[type=password]',
//                 'input[type=text]', 'input[type=file]',
//                 'textarea'
//             ].join(', '),
//             $inputs = $form.find('.required').find(inputVal),
//             $errorStatus = $form.find('div.error'),
//             valid = true;
//         $errorStatus.addClass('hide');

//         $('.has-error').removeClass('has-error');
//         $inputs.each(function(i, el) {
//             var $input = $(el);
//             if ($input.val() === '') {
//                 $input.parent().addClass('has-error');
//                 $errorStatus.removeClass('hide');
//                 e.preventDefault();
//             }
//         });

//         if (!$form.data('cc-on-file')) {
//             e.preventDefault();
//             Stripe.setPublishableKey($form.data('stripe-publishable-key'));
//             Stripe.createToken({
//                 number: $('.card-num').val(),
//                 cvc: $('.card-cvc').val(),
//                 exp_month: $('.card-expiry-month').val(),
//                 exp_year: $('.card-expiry-year').val()
//             }, stripeHandleResponse);
//         }

//     });

//     function stripeHandleResponse(status, response) {
//         if (response.error) {
//             $('.error')
//                 .removeClass('hide')
//                 .find('.alert')
//                 .text(response.error.message);
//         } else {
//             var token = response['id'];
//             $form.find('input[type=text]').empty();
//             $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
//             $form.get(0).submit();
//         }
//     }

// });
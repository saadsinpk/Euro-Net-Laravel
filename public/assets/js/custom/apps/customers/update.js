"use strict";

// Class definition
var KTModalUpdateCustomer = function () {
    var element;
    var submitButton;
    var cancelButton;
    var closeButton;
    var form;
    var modal;
    var validator;
    var url;
    // Init form inputs
    var initForm = function () {

        validator = FormValidation.formValidation(
			form,
			{
				fields: {
                    'first_name': {
						validators: {
							notEmpty: {
								message: 'First name is required'
							},
							stringLength: {
								min: 2,
								message: 'The message must be greater than 2 characters'
							}
						}
					},
					'last_name': {
						validators: {
							notEmpty: {
								message: 'First name is required'
							},
							stringLength: {
								min: 2,
								message: 'The message must be greater than 2 characters'
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
								max:11,
								message: 'The message must be 11 characters'
							}
						}
					},
					'site_id': {
						validators: {
							notEmpty: {
								message: 'Site is required'
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
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            
            e.preventDefault();
            if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid') {
						url = $(form).attr("action");

						var formdata =  new FormData;
						var avatar = form.querySelector("[name='avatar']").files[0];
						var first_name = form.querySelector("[name='first_name']").value;
						var last_name = form.querySelector("[name='last_name']").value;
						var phone = form.querySelector("[name='phone']").value;
						var email = form.querySelector("[name='email']").value;
						var id = form.querySelector("[name='id']").value;
						var site_id = form.querySelector("[name='site_id']").value;

						formdata.append("avatar", avatar);
						formdata.append("first_name", first_name);
						formdata.append("last_name", last_name);
						formdata.append("phone", phone);
						formdata.append("email", email);
						formdata.append("site_id", site_id);
						formdata.append("id", id);

						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url:  url,
							method: "POST",
							data: formdata,
							processData: false,
                            contentType: false,
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
									}).then(function (result) {
										if (result.isConfirmed) {
											// Hide modal
											modal.hide();
		
											// Enable submit button after loading
											submitButton.disabled = false;
                                            window.location.reload();
											// Redirect to Admins list page
										}
									});							
								}, 2000); 
							}
						}).catch(function(error){
							if(error.status == 422) {
								Swal.fire({
									text: "The email has already been taken.",
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								});
							}else {
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
					}else {
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

        cancelButton.addEventListener('click', function (e) {
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
            }).then(function (result) {
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

        closeButton.addEventListener('click', function (e) {
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
            }).then(function (result) {
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
        init: function () {
          	
			modal = new bootstrap.Modal(document.querySelector('#kt_modal_update_customer'));
            form = document.querySelector('#kt_modal_update_customer form');
            submitButton = form.querySelector('[data-modal-action="submit"]');
            cancelButton = form.querySelector('[data-modal-action="cancel"]');
            closeButton = form.querySelector('[data-modal-action="close"]');


            initForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalUpdateCustomer.init();
});
"use strict";

// Class definition
var CustomerObj = function () {
    var submitButton;
    var cancelButton;
    var closeButton;
    var form;
    var modal;
    var url;
    // Init form inputs
    var initForm = function () {

        submitButton.addEventListener('click', function (e) {

			e.preventDefault();

			url = $(form).attr("action")
			var formdata = $(form).serialize();
			console.log(formdata);
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url:  url,
				method: "POST",
				data: formdata,
				dataType: 'JSON',
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
	
	var handleDeleteCustomer = () => {
		// Select all delete buttons
		const deleteButtons = document.querySelectorAll('[data-action="remove_customer"]');

		deleteButtons.forEach(d => {
			// Delete button on click
			d.addEventListener('click', function (e) {
				e.preventDefault();

				// Get admin name
				const Name = $(this).parents(".aside-user-info")[0].querySelector(".customer_name").innerText;
				const id = $(this).attr("data-id")
				// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
				Swal.fire({
					text: "Are you sure you want to remove " + Name + "?",
					icon: "warning",
					showCancelButton: true,
					buttonsStyling: false,
					confirmButtonText: "Yes, remove!",
					cancelButtonText: "No, cancel",
					customClass: {
						confirmButton: "btn fw-bold btn-danger",
						cancelButton: "btn fw-bold btn-active-light-primary"
					}
				}).then(function (result) {
					if (result.value) {
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url:  `/accounts/customer-remove/${id}`,
							method: "get",
							dataType: "JSON",
							success: function() {
								Swal.fire({
									text: "You have remove " + Name + "!.",
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn fw-bold btn-primary",
									}
								}).then(function () {
									 window.location.reload();
								});
							}
						}).catch(function(error){
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
					} else if (result.dismiss === 'cancel') {
						Swal.fire({
							text: Name + " was not deleted.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn fw-bold btn-primary",
							}
						});
					}
				});
			})
		});
	}

	var handleAccountUpdate = () => {
		const form  = document.querySelector("#accountUpdateForm");
		const submitButton = form.querySelector("[type='submit']");
		console.log(form);

		const validator = FormValidation.formValidation(
			form,
			{
				fields: {
					'account_id': {
						validators: {
							notEmpty: {
								message: 'Address is required'
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

		$(submitButton).click(function(e) {
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {

						var formdata = $(form).serialize()
						url = $(form).attr("action");

						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url:  url,
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
									}).then(function (result) {
										if (result.isConfirmed) {
											// Enable submit button after loading
											submitButton.disabled = false;
											window.location.reload();
										}
									});							
								}, 2000); 
							}
						}).catch(function(error){
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
		})
		
	}

	var handlePhoneUpdate = () => {
		const form  = document.querySelector("#phoneUpdateForm");
		const submitButton = form.querySelector("[type='submit']");
		console.log(form);

		const validator = FormValidation.formValidation(
			form,
			{
				fields: {
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

		$(submitButton).click(function(e) {
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {

						var formdata = $(form).serialize()
						url = $(form).attr("action");

						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url:  url,
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
									}).then(function (result) {
										if (result.isConfirmed) {
											// Enable submit button after loading
											submitButton.disabled = false;
											window.location.reload();
										}
									});							
								}, 2000); 
							}
						}).catch(function(error){
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
		})
		
	}

	var handleEmailUpdate = () => {
		const form  = document.querySelector("#emailUpdateForm");
		const submitButton = form.querySelector("[type='submit']");
		console.log(form);

		const validator = FormValidation.formValidation(
			form,
			{
				fields: {
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

		$(submitButton).click(function(e) {
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {

						var formdata = $(form).serialize()
						url = $(form).attr("action");

						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url:  url,
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
									}).then(function (result) {
										if (result.isConfirmed) {
											// Enable submit button after loading
											submitButton.disabled = false;
											window.location.reload();
										}
									});							
								}, 2000); 
							}
						}).catch(function(error){
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
		})
		
	}

	
	var handleTagUpdate = () => {
		const form  = document.querySelector("#tagUpdateForm");
		const submitButton = form.querySelector("[type='submit']");
		console.log(form);

		const validator = FormValidation.formValidation(
			form,
			{
				fields: {
					'tag_id[]': {
						validators: {
							notEmpty: {
								message: 'Tag Name is required'
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

		$(submitButton).click(function(e) {
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {

						var formdata = $(form).serialize()
						url = $(form).attr("action");

						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url:  url,
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
									}).then(function (result) {
										if (result.isConfirmed) {
											// Enable submit button after loading
											submitButton.disabled = false;
											window.location.reload();
										}
									});							
								}, 2000); 
							}
						}).catch(function(error){
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
		})
		
	}

	var handleListUpdate = () => {
		const form  = document.querySelector("#listUpdateForm");
		const submitButton = form.querySelector("[type='submit']");
		console.log(form);

		const validator = FormValidation.formValidation(
			form,
			{
				fields: {
					'list_id[]': {
						validators: {
							notEmpty: {
								message: 'Llist name is required'
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

		$(submitButton).click(function(e) {
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {

						var formdata = $(form).serialize()
						url = $(form).attr("action");

						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url:  url,
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
									}).then(function (result) {
										if (result.isConfirmed) {
											// Enable submit button after loading
											submitButton.disabled = false;
											window.location.reload();
										}
									});							
								}, 2000); 
							}
						}).catch(function(error){
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
		})
		
	}

    return {
        // Public functions
        init: function () {
          	
			// modal = new bootstrap.Modal(document.querySelector('#contact_add_modal'));//add customer obj
            // form = document.querySelector('#contact_add_modal form');
            // submitButton = form.querySelector('[data-modal-action="submit"]');
            // cancelButton = form.querySelector('[data-modal-action="cancel"]');
            // closeButton = form.querySelector('[data-modal-action="close"]');


            // initForm();
			handleAccountUpdate();
			handlePhoneUpdate();
			handleEmailUpdate();
			handleTagUpdate();
			handleListUpdate();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    CustomerObj.init();
});
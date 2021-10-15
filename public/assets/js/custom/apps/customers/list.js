"use strict";

// Class definition
var CustomerObj = function () {
    var submitButton;
    var cancelButton;
	var closeButton;
    var validator;
    var form;
    var modal;

	var datatable;
	var filterList;
	var filterTag;
	var table;
	var url;
	var ids = "";

    // Init form inputs
    var handleForm = function () {																								
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
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
	}
	
	var closeForm = () => {
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

		closeButton.addEventListener('click', function(e){
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
		})
	}

	var handleSubmit = () => {
	// Action buttons
		submitButton.addEventListener('click', function (e) {			
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {

					if (status == 'Valid') {
						var formdata =  new FormData;
						var avatar = form.querySelector("[name='avatar']").files[0];
						var first_name = form.querySelector("[name='first_name']").value;
						var last_name = form.querySelector("[name='last_name']").value;
						var phone = form.querySelector("[name='phone']").value;
						var email = form.querySelector("[name='email']").value;
						url = $(form).attr("action");

						formdata.append("avatar", avatar);
						formdata.append("first_name", first_name);
						formdata.append("last_name", last_name);
						formdata.append("phone", phone);
						formdata.append("email", email);

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
		
											$(form.querySelectorAll("select")).each(function() {
												$(this).val(null).trigger('change');
											})

											// Redirect to Admins list page
                                            $(table).DataTable().ajax.reload();
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
	}
	// Private functions
	var database = function () {
		// Set date data order
		var url = "/contacts/customers"
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url
            },
            columns: [
				{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false
                },
				{
					data: 'avatar',
                    name: 'avatar',
					class: 'd-flex align-items-center justify-content-center'
				},
				{
					data: 'full_name',
					name: 'full_name',
				},
				{
                    data: 'email',
                    name: 'email',
				},
				{
                    data: 'phone',
                    name: 'phone',
				},
				{
                    data: 'tags',
                    name: 'tags',
					class: 'text-nowrap',
				},
				{
					data: 'lists',
					name: 'lists',
					class: 'd-none',
				},
				{
                    data: 'created_at',
                    name: 'created_at',
				},
                {
                    data: 'action',
                    name: 'action',
					class: 'text-end text-nowrap',
                    orderable: false
                },
            ],
            "info": false,
            'order': [],

            'columnDefs': [
				{ orderable: false, targets: 0 }, // Disable ordering on column 0 (checkbox)
				{ orderable: false, targets: 8 }, // Disable ordering on column 7 (actions)    
	        ]
        });

		// Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
		datatable.on('draw', function () {
			ids = "";
			initToggleToolbar();
			handleDeleteRows();
			toggleToolbars();
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
	
	// Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
	var handleSearchDatatable = () => {
		const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
		filterSearch.addEventListener('keyup', function (e) {
			datatable.search(e.target.value).draw();
		});
	}

	// Filter Datatable
	var handleFilterDatatable = () => {
		// Select filter options
		filterTag = $('[data-kt-table-filter="tag"]');
		filterList = $(document.querySelectorAll('[data-kt-table-filter="list"]'));
		// Filter datatable on submit

		let tagValue = filterTag.val();
		let listValue = filterList.val();
		console.log(listValue)
		if (tagValue === 'all') {
			tagValue = '';
		}

		if (listValue === 'all') {
			listValue = '';
		}
		
		const filterString = tagValue + ' ' + listValue;
		datatable.search(filterString).draw();
	}

	var handleFilterClickSearch = () => {
		const filterButton = document.querySelector('[data-kt-table-filter="filter"]');

		filterButton.addEventListener('click', function () {
			handleFilterDatatable();
		});
	} 
	// Delete admin
	var handleDeleteRows = () => {
		// Select all delete buttons
		const deleteButtons = table.querySelectorAll('[data-kt-table-filter="delete_row"]');

		deleteButtons.forEach(d => {
			// Delete button on click
			d.addEventListener('click', function (e) {
				e.preventDefault();

				// Select parent row
				const parent = e.target.closest('tr');

				// Get admin name
				const Name = parent.querySelectorAll('td')[2].innerText;
				const id = parent.querySelectorAll('td')[0].children[0].children[1].value;
				// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
				Swal.fire({
					text: "Are you sure you want to delete " + Name + "?",
					icon: "warning",
					showCancelButton: true,
					buttonsStyling: false,
					confirmButtonText: "Yes, delete!",
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
							url:  `/contacts/customers/delete/${id}`,
							method: "get",
							dataType: "JSON",
							success: function() {
								Swal.fire({
									text: "You have deleted " + Name + "!.",
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn fw-bold btn-primary",
									}
								}).then(function () {
									 // Remove current row
									 datatable.row($(parent)).remove().draw();
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

	// Reset Filter
	var handleResetForm = () => {
		// Select reset button
		const resetButton = document.querySelector('[data-kt-table-filter="reset"]');

		// Reset datatable
		resetButton.addEventListener('click', function () {
			// Reset month
			filterTag.val(null).trigger('change');
			filterList.val(null).trigger('change');

			// Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
			datatable.search('').draw();
		});
	}

	// Init toggle toolbar
	var initToggleToolbar = () => {
		// Toggle selected action toolbar
		// Select all checkboxes
		const checkboxes = table.querySelectorAll('[type="checkbox"]');
		// Select elements
		const deleteSelected = document.querySelector('[data-kt-table-select="delete_selected"]');

		// Toggle delete selected toolbar
		checkboxes.forEach(c => {
			// Checkbox on click event
			c.addEventListener('click', function () {
				setTimeout(function () {
					ids = "";
					toggleToolbars();
				}, 50);
			});
		});

		// Deleted selected rows
		deleteSelected.addEventListener('click', function () {
			// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
			Swal.fire({
				text: "Are you sure you want to delete selected admins?",
				icon: "warning",
				showCancelButton: true,
				buttonsStyling: false,
				confirmButtonText: "Yes, delete!",
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
						url:  `/contacts/customers/delete-rows`,
						data: {ids: ids.substr(1)},
						method: "post",
						dataType: "JSON",
						success: function() {
							Swal.fire({
								text: "You have deleted all selected admins!.",
								icon: "success",
								buttonsStyling: false,
								confirmButtonText: "Ok, got it!",
								customClass: {
									confirmButton: "btn fw-bold btn-primary",
								}
							}).then(function () {
								// Remove all selected admins
								checkboxes.forEach(c => {
									if (c.checked) {
										datatable.row($(c.closest('tbody tr'))).remove().draw();
									}
								});
		
								// Remove header checked box
								const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
								headerCheckbox.checked = false;
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
						text: "Selected admins was not deleted.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn fw-bold btn-primary",
						}
					});
				}
			});
		});
	}

	// Toggle toolbars
	const toggleToolbars = () => {
		// Define variables
		const toolbarBase = document.querySelector('[data-kt-table-toolbar="base"]');
		const toolbarSelected = document.querySelector('[data-kt-table-toolbar="selected"]');
		const selectedCount = document.querySelector('[data-kt-table-select="selected_count"]');

		// Select refreshed checkbox DOM elements 
		const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');
		// Detect checkboxes state & count
		let checkedState = false;
		let count = 0;

		// Count checked boxes
		allCheckboxes.forEach(c => {
			if (c.checked) {
				ids += "," + c.parentNode.children[1].value
				checkedState = true;
				count++;
			}
		});
		// Toggle toolbars
		if (checkedState) {
			selectedCount.innerHTML = count;
			toolbarBase.classList.add('d-none');
			toolbarSelected.classList.remove('d-none');
		} else {
			toolbarBase.classList.remove('d-none');
			toolbarSelected.classList.add('d-none');
		}
	}

    return {
        // Public functions
        init: function () {
			
			table = document.querySelector('#kt_customers_table');
			
			if (!table) {
				return;
			}
			
			modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_customer'));
            form = document.querySelector('#kt_modal_add_customer form');
            submitButton = form.querySelector('[data-modal-action="submit"]');
            cancelButton = form.querySelector('[data-modal-action="cancel"]');
            closeButton = form.querySelector('[data-modal-action="close"]');

            database();
            initToggleToolbar();
            handleSearchDatatable();
            handleFilterClickSearch();
            handleFilterDatatable();
            handleResetForm();
            handleForm();
            handleSubmit();
			closeForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	CustomerObj.init();
});
"use strict";

// Class definition
var KTModalAdmins = function() {
    var submitButton;
    var cancelButton;
    var closeButton;
    var validator;
    var form;
    var modal;

    var datatable;
    var table
    var url
    var formdata
    var ids = "";

    // Init form inputs
    var handleForm = function() {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
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

            // Validate form before submit
            if (validator) {
                validator.validate().then(function(status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        formdata = $('#kt_modal_add_admin_form').serialize();


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
                                            modal.hide();

                                            // Enable submit button after loading
                                            submitButton.disabled = false;

                                            // Redirect to Admins list page
                                            $(table).DataTable().ajax.reload();
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
        // Private functions
    var initadminList = function() {
        // Set date data order
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/admins'
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    class: 'text-end',
                    orderable: false
                },
            ],
            "info": false,
            'order': [],

            'columnDefs': [
                { orderable: false, targets: 0 }, // Disable ordering on column 0 (checkbox)
                { orderable: false, targets: 3 }, // Disable ordering on column 6 (actions)    
            ]
        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on('draw', function() {
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
        const filterSearch = document.querySelector('[data-kt-admin-table-filter="search"]');
        filterSearch.addEventListener('keyup', function(e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Delete admin
    var handleDeleteRows = () => {
            // Select all delete buttons
            const deleteButtons = table.querySelectorAll('[data-kt-table-filter="delete_row"]');

            deleteButtons.forEach(d => {
                // Delete button on click
                d.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Select parent row
                    const parent = e.target.closest('tr');

                    // Get admin name
                    const adminName = parent.querySelectorAll('td')[1].innerText;
                    const id = parent.querySelectorAll('td')[0].children[0].children[1].value;

                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Are you sure you want to delete " + adminName + "?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then(function(result) {
                        if (result.value) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: `/admin/admins/user/delete/${id}`,
                                method: "get",
                                dataType: "JSON",
                                success: function() {
                                    Swal.fire({
                                        text: "You have deleted " + adminName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        // Remove current row
                                        datatable.row($(parent)).remove().draw();
                                    });
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
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: adminName + " was not deleted.",
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
        // Init toggle toolbar
    var initToggleToolbar = () => {
        // Toggle selected action toolbar
        // Select all checkboxes
        const checkboxes = table.querySelectorAll('[type="checkbox"]');
        // Select elements
        const deleteSelected = document.querySelector('[data-kt-admin-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function() {
                setTimeout(function() {
                    ids = "";
                    toggleToolbars();
                }, 50);
            });
        });

        // Deleted selected rows
        deleteSelected.addEventListener('click', function() {
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            console.log(ids);
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
            }).then(function(result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: `/admin/admins/user/delete-rows`,
                        data: { ids: ids.substr(1) },
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
                            }).then(function() {
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
        const toolbarBase = document.querySelector('[data-kt-admin-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-admin-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-admin-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements 
        const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');
        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                ids += "," + c.parentNode.children[1].value
                console.log(ids);
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
        init: function() {
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_admin'));

            table = document.querySelector('#kt_admins_table');

            if (!table) {
                return;
            }

            form = document.querySelector('#kt_modal_add_admin_form');
            submitButton = form.querySelector('#kt_modal_add_admin_submit');
            cancelButton = form.querySelector('#kt_modal_add_admin_cancel');
            closeButton = form.querySelector('#kt_modal_add_admin_close');
            url = $("#kt_modal_add_admin_form").attr("action");
            console.log(submitButton)
            initadminList();
            initToggleToolbar();
            handleSearchDatatable();
            handleForm();
            closeForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTModalAdmins.init();
});
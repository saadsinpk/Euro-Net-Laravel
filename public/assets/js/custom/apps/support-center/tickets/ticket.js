"use strict";

// Class definition
var KTModalNewTicket = function() {
    var submitButton;
    var validator;
    var validator2;
    var validator1;
    var form;
    var modal;

    var datatable;
    var table

    // Init form inputs
    var initForm = function() {
        // Ticket attachments
        // For more info about Dropzone plugin visit: https: //www.dropzonejs.com/#usage
        var myDropzone = new Dropzone("#kt_modal_create_ticket_attachments", {
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
                console.log(response);
                console.log(response.file_name);
                $(form).append("<input type='hidden' name='file_name[]' value='" + response.file_name + "'>");
            },
            error: function(file, response) {
                return false;
            }
        });
    }


    var database = function() {
        // Set date data order
        var url = "/user/ticket-history/"
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
                    data: 'subject',
                    name: 'subject',
                    orderable: false
                },
                {
                    data: 'number',
                    name: 'number',
                },
                {
                    data: 'category_name',
                    name: 'category_name',
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
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator2 = FormValidation.formValidation(
            form, {
                fields: {
                    subject: {
                        validators: {
                            notEmpty: {
                                message: 'Ticket subject is required'
                            }
                        }
                    },
                    category_id: {
                        validators: {
                            notEmpty: {
                                message: 'Category is required'
                            }
                        }
                    },
                    description: {
                        validators: {
                            notEmpty: {
                                message: 'Target description is required'
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

        validator1 = FormValidation.formValidation(
            form, {
                fields: {
                    subject: {
                        validators: {
                            notEmpty: {
                                message: 'Ticket subject is required'
                            }
                        }
                    },
                    category_id: {
                        validators: {
                            notEmpty: {
                                message: 'Category is required'
                            }
                        }
                    },
                    description: {
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
            // Validate form before submit
            console.log($("#user_id").val());

            if ($("#user_id").val()) {
                validator = validator2
            } else {
                validator = validator1
            }

            // Stepper custom navigation
            $(form.querySelector('[name="category_id"]')).on('change', function() {
                // Revalidate the field when an option is chosen
                validator.revalidateField('category_id');
            });

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
                                    // Enable button
                                    submitButton.disabled = false;

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


                                            $(form.querySelectorAll("select")).each(function() {
                                                $(this).val(null).trigger('change');
                                            })

                                            if ($("#user_id").val()) {
                                                location.href = "/user/ticket-view/" + res + ""
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
            table = document.querySelector('#ticket_history_table');

            if ($("#user_id").val()) {
                database();
            }

            form = document.querySelector('#kt_modal_new_ticket_form');
            submitButton = document.getElementById('kt_modal_new_ticket_submit');

            initForm();
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTModalNewTicket.init();
});



$( document ).ready(function() {
    var url=window.location.href;
    var url_hash=url.split('#');
    if(!url_hash[1]) {
        console.log("Test");
    } else {
        url_hash = url_hash[1];
        $('li.nav-item a').removeClass("active");
        $('a[href="#'+url_hash+'"]').addClass("active");
        $(".tab-pane.fade").removeClass("active");
        $(".tab-pane.fade").removeClass("show");
        $("#"+url_hash).addClass("active");
        $("#"+url_hash).addClass("show");
        console.log(url_hash);
    }
});
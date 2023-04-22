"use strict";

var UsersList = function () {
    var table = document.getElementById('table_users');
    var datatable;

    var initUserTable = function () {

        datatable = $(table).DataTable({
            "info": true,
            'order': [[0, 'asc']],
            'processing': true,
            'responsive': true,
            "pageLength": 10,
            "lengthChange": true,
            'columnDefs': [
                { orderable: false, targets: [5, 6] },
            ]
        });

    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleFilterDatatable = () => {
        const filterForm = document.querySelector('[data-user-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-user-table-filter="filter"]');
        const selectOptions = filterForm.querySelectorAll('select');

        filterButton.addEventListener('click', function () {
            var filterString = '';

            selectOptions.forEach((item, index) => {
                if (item.value && item.value !== '') {
                    if (index !== 0) {
                        filterString += ' ';
                    }

                    filterString += item.value;
                }
            });

            datatable.search(filterString).draw();
        });
    }

    var handleResetForm = () => {
        const resetButton = document.querySelector('[data-user-table-filter="reset"]');
        resetButton.addEventListener('click', function () {
            const filterForm = document.querySelector('[data-user-table-filter="form"]');
            const selectOptions = filterForm.querySelectorAll('select');

            selectOptions.forEach(select => {
                $(select).val('').trigger('change');
            });

            datatable.search('').draw();
        });
    }

    var exportUsers = () => {
        const documentTitle = 'Users List';
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle
                },
                {
                    extend: 'csvHtml5',
                    title: documentTitle
                },
                {
                    extend: 'pdfHtml5',
                    title: documentTitle
                }
            ]
        }).container().appendTo($('#datatable_users_export_buttons'));

        const exportButtons = document.querySelectorAll('#datatable_users_export_menu [data-export]');
        exportButtons.forEach(exportButton => {
            exportButton.addEventListener('click', e => {
                e.preventDefault();

                const exportValue = e.target.getAttribute('data-export');
                const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

                target.click();
            });
        });
    }

    var initAddUser = () => {
        const element = document.getElementById('modal_add_user');
        const form = element.querySelector('#modal_add_user_form');
        const modal = new bootstrap.Modal(element);

        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'user_name': {
                        validators: {
                            notEmpty: {
                                message: 'User name is required'
                            }
                        }
                    },
                    'user_email': {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: 'The value is not a valid email address',
                            },
							notEmpty: {
								message: 'Email address is required'
							}
						}
					},
                    'user_password': {
                        validators: {
                            notEmpty: {
                                message: 'User Password is required'
                            }
                        }
                    },
                    'user_role': {
                        validators: {
                            notEmpty: {
                                message: 'User Role is required'
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

        const submitButton = element.querySelector('[data-users-modal-action="submit"]');
        submitButton.addEventListener('click', e => {
            e.preventDefault();

            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        setTimeout(function () {
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;
                            form.submit();
                        }, 1500);
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

    return {
        init: function () {
            if (!table) {
                return;
            }

            initUserTable();
            handleSearchDatatable();
            handleResetForm();
            handleFilterDatatable();
            exportUsers();
            initAddUser();

        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    UsersList.init();
});
"use strict";

var Logs = function () {
    var table = document.getElementById('table_logs');
    var datatable;

    var initUserTable = function () {

        datatable = $(table).DataTable({
            "info": true,
            "order": [2, 'desc'],
            'processing': true,
            'responsive': true,
            "pageLength": 10,
            "lengthChange": true,
            'columnDefs': [
                { orderable: false, targets: [1, 3] },
            ]
        });

    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-logs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleFilterDatatable = () => {
        const filterForm = document.querySelector('[data-logs-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-logs-table-filter="filter"]');
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
        const resetButton = document.querySelector('[data-logs-table-filter="reset"]');
        resetButton.addEventListener('click', function () {
            const filterForm = document.querySelector('[data-logs-table-filter="form"]');
            const selectOptions = filterForm.querySelectorAll('select');

            selectOptions.forEach(select => {
                $(select).val('').trigger('change');
            });

            datatable.search('').draw();
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

        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    Logs.init();
});

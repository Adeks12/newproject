<div class="container-fluid p-0">
    <div class="card">
        <div class="dropdown d-inline-block d-lg-none ms-2">
        <button type="button" class="btn header-item noti-icon waves-effect"
            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="mdi mdi-magnify"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
            aria-labelledby="page-header-search-dropdown">

            <form class="p-3">
                <div class="m-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search ..."
                            aria-label="Recipient's username">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i
                                    class="mdi mdi-magnify"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <div class="card-header">
            <h4 class="card-title">Department Management</h4>
            <p class="card-title-desc">The report contains Departments that have been setup in the system.</p>
        </div>
        <div class="card-body">
            <a class="btn btn-outline-primary mb-3" onclick="loadModal('setup/department_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                <i class="fas fa-plus"></i> Create Department
            </a>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Departments List</h4>
                            <p class="card-title-desc">
                                Manage your organization's departments
                            </p>

                            <div class="col-sm-12 table-responsive">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Dept Name</th>
                                        <th>Dept Code</th>
                                        <th>Dept Head</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- You can leave this empty if you are loading data via AJAX -->
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            </div>
            <!-- end row -->
        </div>
    </div>
</div>

<style>
/* Ensure DataTable search and length controls are aligned and responsive */
.dataTables_wrapper .row.mb-3.align-items-center {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 1rem !important;
}
.dataTables_wrapper .row.mb-3 .col-md-6 {
    flex: 1 1 0;
    min-width: 220px;
    margin-bottom: 0.5rem;
}
.dataTables_wrapper .dataTables_length {
    float: left;
    text-align: left;
    margin-bottom: 1rem;
}
.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    margin-bottom: 1rem;
}
.dataTables_wrapper .dataTables_info {
    float: left;
    margin-top: 0.5rem;
}
.dataTables_wrapper .dataTables_paginate {
    float: right;
    margin-top: 0.5rem;
}
.dataTables_filter {
    text-align: left !important;
    margin-bottom: 0 !important;
}
.dataTables_length {
    text-align: right !important;
    margin-bottom: 0 !important;
}
/* DataTables Bootstrap 4 alignment fix */
.dataTables_wrapper .row {
    margin-bottom: 1rem;
}
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 1rem;
}
.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label {
    display: flex;
    align-items: center;
    margin-bottom: 0;
}
.dataTables_wrapper .dataTables_length select {
    margin: 0 0.5rem;
}
.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5rem;
}
@media (min-width: 768px) {
    .dataTables_wrapper .row:first-child {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
    .dataTables_wrapper .dataTables_length {
        flex: 1 1 0;
        text-align: left;
    }
    .dataTables_wrapper .dataTables_filter {
        flex: 1 1 0;
        text-align: right;
    }
}
@media (max-width: 767.98px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        text-align: left;
    }
}

/* Restore DataTables sorting icons if missing */
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_desc:after {
    opacity: 1 !important;
    display: inline-block !important;
}
</style>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            // Enable responsive and other features as in your template
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: 'utilities.php',
                type: 'POST',
                data: {
                    op: 'Department.departmentList'
                }
            },
            columns: [
                { data: 0, name: 'depmt_id' },
                { data: 1, name: 'depmt_name' },
                { data: 2, name: 'depmt_code' },
                { data: 3, name: 'depmt_head' },
                { data: 4, name: 'depmt_status' },
                { data: 5, name: 'created_at' },
                { data: 6, name: 'actions', orderable: false }
            ],
            oLanguage: {
                sEmptyTable: "No record was found, please try another query",
                sProcessing: "Loading departments..."
            }
        });
    });

    function editDepartment(depmt_id) {
        loadModal('setup/department_setup.php?op=edit&depmt_id=' + depmt_id, 'modal_div');
    }

    function deleteDepartment(depmt_id) {
        if (confirm("Are you sure you want to delete this department?")) {
            $.post('utilities.php', { op: 'Department.deleteDepartment', depmt_id: depmt_id }, function (resp) {
                if (resp.response_code == 0) {
                    alert(resp.response_message);
                    // Refresh the table
                    $('#datatable').DataTable().ajax.reload();
                } else {
                    alert(resp.response_message);
                }
            }, 'json');
        }
    }

    function loadModal(url, target) {
        $("#" + target).html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>');
        $.get(url, function(data) {
            $("#" + target).html(data);
            $('#defaultModalPrimary').modal('show');
        });
    }
</script>
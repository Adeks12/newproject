<div class="container-fluid p-0">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Staff Management</h5>
            <h6 class="card-subtitle text-muted">The report contains Staff that have been setup in the system.</h6>
        </div>
        <div class="card-body">
            <a class="btn btn-outline-primary mb-3" onclick="loadModal('setup/staff_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                <i class="fas fa-plus"></i> Create Staff
            </a>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Staff List</h4>
                            <p class="card-title-desc">
                                Manage your organization's staff
                            </p>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Staff Code</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: 'utilities.php',
                type: 'POST',
                data: {
                    op: 'staff.staffList'
                }
            },
            columns: [
                { data: 0, name: 'id' },
                { data: 1, name: 'first_name' },
                { data: 2, name: 'last_name' },
                { data: 3, name: 'staff_code' },
                { data: 4, name: 'email' },
                { data: 5, name: 'phone_number' },
                { data: 6, name: 'department' },
                { data: 7, name: 'status' },
                { data: 8, name: 'created_at' },
                { data: 9, name: 'actions', orderable: false }
            ],
            oLanguage: {
                sEmptyTable: "No record was found, please try another query",
                sProcessing: "Loading staff..."
            }
        });
    });

    function editstaff(id) {
        loadModal('setup/staff_setup.php?op=edit&staff_id=' + id, 'modal_div');
    }

    function deletestaff(id) {
        if (confirm("Are you sure you want to delete this staff?")) {
            $.post('utilities.php', { op: 'staff.deleteStaff', staff_id: id }, function (resp) {
                if (resp.response_code == 0) {
                    alert(resp.response_message);
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
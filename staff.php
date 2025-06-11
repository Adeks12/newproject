<div class="container-fluid p-0">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Staff Management</h5>
            <h6 class="card-subtitle text-muted">The report contains Staff that have been setup in the system.</h6>
        </div>
        <div class="card-body">
            <a class="btn btn-warning mb-3" onclick="loadModal('setup/staff_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                <i class="fas fa-plus"></i> Create Staff
            </a>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Staff List</h5>
                            <h6 class="card-subtitle text-muted">Manage your organization's staff</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatables-staffs" class="table table-striped w-100">
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

    .dataTables_filter {
        text-align: left !important;
        margin-bottom: 0 !important;
    }

    .dataTables_length {
        text-align: right !important;
        margin-bottom: 0 !important;
    }

    @media(max-width: 600px){
    .dataTables_wrapper .row.mb-3 .col-md-6 {
        min-width: 100%;
        text-align: left !important;
    }

    .dataTables_length,
    .dataTables_filter {
        text-align: left !important;
    }
    }
</style>

<script>
    var table;
    var editor;
    var op = "staff.staffList"; // Operation for DataTable

    $(document).ready(function () {
        table = $("#datatables-staffs").DataTable({
            dom: '<"row mb-3 align-items-center"<"col-md-6"f><"col-md-6 text-end"l>>rt<"row mt-2"<"col-12"p>>',
            processing: true,
            columnDefs: [{
                    orderable: false,
                    targets: 0
                },
                {
                    width: "100px",
                    targets: 6
                }
            ],
            serverSide: true,
            paging: true,
            oLanguage: {
                sEmptyTable: "No record was found, please try another query"
            },
            ajax: {
                url: "utilities.php",
                type: "POST",
                data: function (d, l) {
                    d.op = op;
                    d.li = Math.random();
                }
            }
        });
    });

    function editstaff(staffId) {
        loadModal('setup/staff_setup.php?op=edit&staff_id=' + staffId, 'modal_div');
        $('#defaultModalPrimary').modal('show');
    }

    function deletestaff(staffId) {
        if (confirm('Are you sure you want to delete this staff? This action cannot be undone.')) {
            $.post('utilities.php', {
                op: 'staff.deleteStaff', // Fixed method name to match class
                staff_id: staffId
            }, function (response) {
                if (response.response_code == 0) {
                    alert('Staff deleted successfully');
                    refreshStaffList();
                } else {
                    alert('Error: ' + response.response_message);
                }
            }, 'json').fail(function () {
                alert('An error occurred while deleting the staff');
            });
        }
    }

    function refreshStaffList() {
        $('#datatables-staffs').DataTable().ajax.reload();
    }

    // Global function to refresh table after modal operations
    window.refreshStaffList = refreshStaffList;
</script>
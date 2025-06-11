<div class="container-fluid p-0">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Department Management</h5>
            <h6 class="card-subtitle text-muted">The report contains Departments that have been setup in the system.
            </h6>
        </div>
        <div class="card-body">
            <a class="btn btn-warning mb-3" onclick="loadModal('setup/department_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                <i class="fas fa-plus"></i> Create Department
            </a>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Departments List</h5>
                            <h6 class="card-subtitle text-muted">Manage your organization's departments</h6>
                        </div>
                        <div class="card-body">
                           

                            <table id="datatables-departments" class="table table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Department Name</th>
                                        <th>Department Code</th>
                                        <th>Department Head</th>
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
@media (max-width: 600px) {
    .dataTables_wrapper .row.mb-3 .col-md-6 {
        min-width: 100%;
        text-align: left !important;
    }
    .dataTables_length, .dataTables_filter {
        text-align: left !important;
    }
}
</style>

<script>
    var table;
    var editor;
    var op = "Department.departmentList";

    $(document).ready(function () {
        table = $("#datatables-departments").DataTable({
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
            pageLength: 25,
            oLanguage: {
                sEmptyTable: "No record was found, please try another query",
                sProcessing: "Loading departments..."
            },
            ajax: {
                url: "utilities.php",
                type: "POST",
                data: function (d, l) {
                    d.op = op;
                    d.li = Math.random();
                    // Add search parameter if exists
                    if ($("#searchInput").val()) {
                        d.search = {
                            value: $("#searchInput").val()
                        };
                    }
                },
                error: function (xhr, error, thrown) {
                    console.log("DataTable Error:", error, thrown);
                    alert("Error loading data. Please refresh the page.");
                }
            },
            columns: [{
                    data: 0,
                    name: 'depmt_id'
                },
                {
                    data: 1,
                    name: 'depmt_name'
                },
                {
                    data: 2,
                    name: 'depmt_code'
                },
                {
                    data: 3,
                    name: 'depmt_head'
                },
                {
                    data: 4,
                    name: 'depmt_status'
                },
                {
                    data: 5,
                    name: 'created_at'
                },
                {
                    data: 6,
                    name: 'actions',
                    orderable: false
                }
            ]
        });

        // Search functionality
        $("#searchBtn").click(function () {
            table.ajax.reload();
        });

        $("#clearBtn").click(function () {
            $("#searchInput").val('');
            table.ajax.reload();
        });

        $("#searchInput").keypress(function (e) {
            if (e.which == 13) { // Enter key
                table.ajax.reload();
            }
        });
    });

    function editDepartment(departmentId) {
        loadModal('setup/department_setup.php?op=edit&depmt_id=' + departmentId, 'modal_div');
        $('#defaultModalPrimary').modal('show');
    }

    function deleteDepartment(departmentId) {
        if (confirm('Are you sure you want to delete this department? This action cannot be undone.')) {
            $.post('utilities.php', {
                op: 'Department.deleteDepartment',
                depmt_id: departmentId
            }, function (response) {
                if (response.response_code == 0) {
                    alert('Department deleted successfully');
                    refreshDepartmentList();
                } else {
                    alert('Error: ' + response.response_message);
                }
            }, 'json').fail(function () {
                alert('An error occurred while deleting the department');
            });
        }
    }

    function refreshDepartmentList() {
        $('#datatables-departments').DataTable().ajax.reload();
    }

    // Global function to refresh table after modal operations
    window.refreshDepartmentList = refreshDepartmentList;
</script>
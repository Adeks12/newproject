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
                 Create Department
            </a>

            <a class="btn btn-outline-primary mb-3" onclick="loadModal('setup/departmentHead_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                 Setup Department Head
            </a>

            <div class="row">
                
                        <div class="col-sm-12 table-responsive">

                            <table id="datatable" class="table table-striped">
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
               
            <!-- end row -->
        </div>
    </div>




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

    function refreshDepartmentList() {
        $('#datatable').DataTable().ajax.reload(null, false);
    }
</script>
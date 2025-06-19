
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Staff Management</h5>
            <h6 class="card-subtitle text-muted">The report contains Staff that have been setup in the system.</h6>
        </div>
        <div class="card-body">
            <a class="btn btn-outline-primary mb-3" onclick="loadModal('setup/staff_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                </i> Create Staff
            </a>

            <div class="row">
                <div class="col-sm-12 table-responsive">
                    
                            <table id="datatable" class="table table-striped"
                                style="width: 100%;">
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
<!--  -->

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            responsive: false,
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
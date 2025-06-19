    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Inventory Management</h5>
            <h6 class="card-subtitle text-muted">This report contains all inventory items in the system.</h6>
        </div>
        <div class="card-body">
            <a class="btn btn-outline-primary mb-3" onclick="loadModal('setup/inventory_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                <i class="fas fa-plus"></i> Create Inventory Item
            </a>

            <div class="row">

                <div class="col-sm-12 table-responsive">

                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Code</th>
                                        <th>Condition</th>
                                        <th>Color</th>
                                        <th>Category</th>
                                        <th>Allocation Status</th>
                                        <th>Usage Status</th>
                                        <th>Allocated Officer</th>
                                        <th>Allocated Date</th>
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
                    op: 'inventory.inventoryList'
                }
            },
            columns: [
                { data: 0, name: 'id' },
                { data: 1, name: 'item_code' },
                { data: 2, name: 'condition' },
                { data: 3, name: 'color' },
                { data: 4, name: 'category' },
                { data: 5, name: 'allocation_status' },
                { data: 6, name: 'usage_status' },
                { data: 7, name: 'allocated_officer' },
                { data: 8, name: 'allocated_date' },
                { data: 9, name: 'created_at' },
                { data: 10, name: 'actions', orderable: false }
            ],
            oLanguage: {
                sEmptyTable: "No record was found, please try another query",
                sProcessing: "Loading inventory..."
            }
        });
    });

    function editInventory(id) {
        loadModal('setup/inventory_setup.php?op=edit&item_id=' + id, 'modal_div');
    }

    function deleteInventory(id) {
        if (confirm("Are you sure you want to delete this inventory item?")) {
            $.post('utilities.php', { op: 'inventory.deleteInventory', item_id: id }, function (resp) {
                if (resp.response_code == 0) {
                    alert(resp.response_message);
                    $('#datatable').DataTable().ajax.reload();
                } else {
                    alert(resp.response_message);
                }
            }, 'json');
        }
    }

    function allocateInventory(id) {
        loadModal('setup/inventory_setup.php?op=allocate&item_id=' + id, 'modal_div');
    }

    function loadModal(url, target) {
        $("#" + target).html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>');
        $.get(url, function(data) {
            $("#" + target).html(data);
            $('#defaultModalPrimary').modal('show');
        });
    }
</script>
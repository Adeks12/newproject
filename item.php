<div class="card">
        <div class="card-header">
            <h5 class="card-title">Item Management</h5>
            <h6 class="card-subtitle text-muted">The report contains Items that have been setup in the system.</h6>
        </div>
        <div class="card-body">
            <a class="btn btn-outline-primary mb-3" onclick="loadModal('setup/item_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                Create Item
            </a>

            <div class="row">
                <div class="col-sm-12 table-responsive">
                   
                            <table id="datatable" class="table table-striped">
                                
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Item Cat Name</th>
                                        <th>Condition</th>
                                        <th>Color</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Purchase Date</th>
                                        <th>warranty </th>
                                        <th>Location</th>
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



<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            // responsive: true,
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
                { data: 2, name: 'item_name' },
                { data: 3, name: 'item_c_name' },
                { data: 4, name: 'condition' },
                { data: 5, name: 'color' },
                { data: 6, name: 'quantity' },
                { data: 7, name: 'status' },
                { data: 8, name: 'purchase_date' },
                { data: 9, name: 'warranty' },
                { data: 10, name: 'location' },
                { data: 11, name: 'created_at' },
                { data: 12, name: 'actions', orderable: false }
            ],
            oLanguage: {
                sEmptyTable: "No record was found, please try another query",
                sProcessing: "Loading item categories..."
            }
        });
    });

    function editItem(id) {
        loadModal('setup/item_setup.php?op=edit&item_id=' + id, 'modal_div');
    }

    function deleteItem(id) {
        if (confirm("Are you sure you want to delete this item category?")) {
            $.post('utilities.php', { op: 'items.deleteItem', item_id: id }, function (resp) {
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
<div class="container-fluid p-0">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Item Category Management</h5>
            <h6 class="card-subtitle text-muted">The report contains Item Categories that have been setup in the system.</h6>
        </div>
        <div class="card-body">
            <a class="btn btn-outline-primary mb-3" onclick="loadModal('setup/item_cat_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                <i class="fas fa-plus"></i> Create Item Category
            </a>

            <div class="row">
                <div class="col-sm-12 table-responsive">
                   
                            <table id="datatable" class="table table-striped">
                                
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Code</th>
                                        <th>Category Name</th>
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
                    op: 'item_cat.item_catList'
                }
            },
            columns: [
                { data: 0, name: 'id' },
                { data: 1, name: 'item_code' },
                { data: 2, name: 'item_cat_name' },
                { data: 3, name: 'status' },
                { data: 4, name: 'created_at' },
                { data: 5, name: 'actions', orderable: false }
            ],
            oLanguage: {
                sEmptyTable: "No record was found, please try another query",
                sProcessing: "Loading item categories..."
            }
        });
    });

    function edititem_cat(item_cat_id) {
        loadModal('setup/item_cat_setup.php?op=edit&item_cat_id=' + item_cat_id, 'modal_div');
    }

    function deleteitem_cat(item_cat_id) {
        if (confirm("Are you sure you want to delete this item category?")) {
            $.post('utilities.php', { op: 'item_cat.deleteitem_cat', item_cat_id: item_cat_id }, function (resp) {
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
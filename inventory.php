<div class="container-fluid p-0">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Inventory Management</h5>
            <h6 class="card-subtitle text-muted">This report contains all inventory items in the system.</h6>
        </div>
        <div class="card-body">
            <a class="btn btn-warning mb-3" onclick="loadModal('setup/inventory_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                <i class="fas fa-plus"></i> Create Inventory Item
            </a>

            <div class="mb-3 row">
                <div class="col-md-4">
                    <label for="catFilter" class="form-label">Filter by Category:</label>
                    <select id="catFilter" class="form-select">
                        <option value="all">All Categories</option>
                        <!-- Categories will be loaded here by JS -->
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="allocationFilter" class="form-label">Filter by Allocation Status:</label>
                    <select id="allocationFilter" class="form-select">
                        <option value="all">All Statuses</option>
                        <option value="Available">Available</option>
                        <option value="Allocated">Allocated</option>
                        <option value="Reserved">Reserved</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Inventory List</h5>
                            <h6 class="card-subtitle text-muted">Manage your organization's inventory items</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="datatables-inventory" class="table table-striped w-100">
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

    @media(max-width:600px){
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
    var inventoryTable;
    var op = "inventory.inventoryList";

    $(document).ready(function () {
        // Load categories for filter
        $.post('utilities.php', {
            op: 'item_cat.getAllitem_cats'
        }, function (resp) {
            if (resp && resp.response_code == 0 && resp.data && Array.isArray(resp.data)) {
                resp.data.forEach(function (cat) {
                    $('#catFilter').append(
                        $('<option>', {
                            value: cat.id,
                            text: cat.item_cat_name
                        })
                    );
                });
            }
        }, 'json');

        // Initialize DataTable
        inventoryTable = $("#datatables-inventory").DataTable({
            dom: '<"row mb-3 align-items-center"<"col-md-6"f><"col-md-6 text-end"l>>rt<"row mt-2"<"col-12"p>>',
            processing: true,
            serverSide: true,
            paging: true,
            oLanguage: {
                sEmptyTable: "No record was found, please try another query"
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 10]
                },
                {
                    width: "120px",
                    targets: 10
                }
            ],
            ajax: {
                url: "utilities.php",
                type: "POST",
                data: function (d) {
                    d.op = op;
                    d.li = Math.random();
                    d.item_cat_id = $('#catFilter').val();
                    d.allocation_status = $('#allocationFilter').val();
                    return d;
                },
                dataSrc: function (json) {
                    return json.data || [];
                },
                error: function (xhr, error, code) {
                    alert('Error loading data: ' + error);
                }
            }
        });

        // Reload table on filter change
        $('#catFilter, #allocationFilter').on('change', function () {
            inventoryTable.ajax.reload();
        });
    });

    function editInventory(itemId) {
        loadModal('setup/inventory_setup.php?op=edit&item_id=' + itemId, 'modal_div');
        $('#defaultModalPrimary').modal('show');
    }

    function deleteInventory(itemId) {
        if (confirm('Are you sure you want to delete this inventory item? This action cannot be undone.')) {
            $.post('utilities.php', {
                op: 'inventory.deleteInventory',
                item_id: itemId
            }, function (response) {
                if (response.response_code == 0) {
                    alert('Inventory item deleted successfully');
                    refreshInventoryList();
                } else {
                    alert('Error: ' + response.response_message);
                }
            }, 'json').fail(function () {
                alert('An error occurred while deleting the inventory item');
            });
        }
    }

    function allocateInventory(itemId) {
        // Open the modal in allocate mode
        loadModal('setup/inventory_setup.php?op=allocate&item_id=' + itemId, 'modal_div');
        $('#defaultModalPrimary').modal('show');
    }

    function refreshInventoryList() {
        if (inventoryTable) {
            inventoryTable.ajax.reload();
        }
    }
    window.refreshInventoryList = refreshInventoryList;
</script>
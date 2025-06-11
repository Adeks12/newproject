<div class="container-fluid p-0">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Item Category Management</h5>
            <h6 class="card-subtitle text-muted">The report contains Item Categories that have been setup in the system.
            </h6>
        </div>
        <div class="card-body">
            <a class="btn btn-warning mb-3" onclick="loadModal('setup/item_cat_setup.php','modal_div')"
                href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">
                <i class="fas fa-plus"></i> Create Item Category
            </a>

            <div class="mb-3">
                <label for="parentCatFilter" class="form-label">Filter by Main Category:</label>
                <select id="parentCatFilter" class="form-select" style="width:auto; display:inline-block;">
                    <option value="all">All Categories</option>
                    <!-- Main categories will be loaded here by JS -->
                </select>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Item Category List</h5>
                            <h6 class="card-subtitle text-muted">Manage your organization's item categories</h6>
                        </div>
                        <div class="card-body">
                            <!-- Controls Row: Search & Pagination above table -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6">
                                    <div id="itemCatsTable_filter" class="dataTables_filter"></div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div id="itemCatsTable_length" class="dataTables_length"></div>
                                </div>
                            </div>
                            <table id="datatables-item-cats" class="table table-striped w-100">
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
                            <!-- Pagination below table, but you can move it if you want -->
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div id="itemCatsTable_paginate" class="dataTables_paginate"></div>
                                </div>
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
    var op = "item_cat.item_catList"; // Operation for DataTable

    $(document).ready(function () {
        // Add debugging to check if jQuery is loaded
        console.log('jQuery loaded:', typeof $ !== 'undefined');
        console.log('Loading item categories...');

        // Load main categories for dropdown
        $.post('utilities.php', {
            op: 'item_cat.getAllitem_cats',
            only_main: 1
        }, function (resp) {
            console.log('Main categories response:', resp);
            if (resp && resp.response_code == 0 && resp.data && Array.isArray(resp.data)) {
                resp.data.forEach(function (cat) {
                    $('#parentCatFilter').append(
                        $('<option>', {
                            value: cat.id,
                            text: cat.item_cat_name
                        })
                    );
                });
            } else {
                console.error('Failed to load main categories:', resp);
            }
        }, 'json').fail(function (xhr, status, error) {
            console.error('Error loading main categories:', error, xhr.responseText);
        });

        // Initialize DataTable with dom option for controls above table
        table = $("#datatables-item-cats").DataTable({
            dom: '<"row mb-3 align-items-center"<"col-md-6"f><"col-md-6 text-end"l>>rt<"row mt-2"<"col-12"p>>',
            processing: true,
            columnDefs: [
                { orderable: false, targets: 0 },
                { width: "100px", targets: 3 }
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
                    d.parent_cat_id = $('#parentCatFilter').val();
                    return d;
                },
                dataSrc: function (json) {
                    return json.data || [];
                }
            }
        });

        // On dropdown change, reload table
        $('#parentCatFilter').on('change', function () {
            console.log('Filter changed to:', $(this).val());
            table.ajax.reload();
        });
    });

    function edititem_cat(itemCatId) {
        console.log('Editing item category:', itemCatId);
        loadModal('setup/item_cat_setup.php?op=edit&item_cat_id=' + itemCatId, 'modal_div');
        $('#defaultModalPrimary').modal('show');
    }

    function deleteitem_cat(itemCatId) {
        console.log('Deleting item category:', itemCatId);
        if (confirm('Are you sure you want to delete this item category? This action cannot be undone.')) {
            $.post('utilities.php', {
                op: 'item_cat.deleteitem_cat',
                item_cat_id: itemCatId
            }, function (response) {
                console.log('Delete response:', response);
                if (response.response_code == 0) {
                    alert('Item category deleted successfully');
                    refreshItemCatList();
                } else {
                    alert('Error: ' + response.response_message);
                }
            }, 'json').fail(function (xhr, status, error) {
                console.error('Delete error:', error, xhr.responseText);
                alert('An error occurred while deleting the item category');
            });
        }
    }

    function refreshItemCatList() {
        console.log('Refreshing item category list...');
        if (table) {
            table.ajax.reload();
        }
    }

    // Global function to refresh table after modal operations
    window.refreshItemCatList = refreshItemCatList;
</script>
<div class="container">
    <h2>Item</h2>
    <hr>

    <div class="row">
        <div class="col-md-12">
        <?php
            echo anchor('item/tambah', 'Tambah', 'class="btn btn-primary"');
            //echo '&nbsp;&nbsp;&nbsp;&nbsp;';
            //echo anchor('bin/tambah', 'Bin Tambah', 'class="btn btn-primary"');
        ?>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">

          <table class="table table-striped table-bordered table-hover table-condensed"
                    id="table"
                    data-toggle="table"
                    data-side-pagination="server"
                    data-url="<?php echo base_url('index.php/json_data/item_master'); ?>"
                    data-page-size="25"
                    data-page-list="[25, 50, 100]"
                    data-show-export="true"
                    data-search="true"
                    data-id-table='advancedTable'
                    data-show-columns="true"
                    data-filter-control="true"
                    data-pagination="true"
                    data-sort-name="item_code"
                    data-sort-order="asc">
            <thead>
                <tr>
                    <th data-formatter="runningFormatterServerSide" data-field="no">No</th>
                    <th data-field="item_code" data-sortable="true">Item Code</th>
                    <th data-field="description" data-sortable="true">Description</th>
                    <th data-field="item_type" data-sortable="true" data-filter-control="select">Item Type</th>
                    <th data-field="category" data-sortable="true" data-filter-control="select">Category</th>
                    <th data-field="uom" data-sortable="true">UoM</th>
                    <th data-field="enable" data-sortable="true">Aktif</th>
                    <th data-field="qty_eStockCard" data-formatter="numberFormatter" data-align="right" data-sortable="true">Qty</th>
                    <th data-formatter="itemCRUDLinkFormatter">Action</th>
                </tr>
                </thead>
            </table>


        </div>
    </div>



</div> <!-- /container -->

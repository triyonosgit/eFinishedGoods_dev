<div class="container">
    <h2>Item</h2>
    <hr>

    <div class="row">
        <div class="col-md-12">

          <table class="table table-striped table-bordered table-hover table-condensed"
                  id="table"
                  data-toggle="table"
                  data-side-pagination="server"
                  data-url="<?php echo base_url('index.php/json_data/item_master'); ?>"
                  data-page-size="25"
                  data-page-list="[10, 25, 50, 100, All]"
                  data-show-export="true"
                  data-search="true"
                  data-show-columns="true"
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
                    <th data-field="item_codeold" data-sortable="true">Kd. Item Lama</th>
                    <!--<th data-field="qty_FINA" data-align="right" data-sortable="true">Qty FINA</th>-->
                    <th data-formatter="itemDetailLinkFormatter">Action</th>
                </tr>
                </thead>
            </table>

        </div>
    </div>

</div> <!-- /container -->

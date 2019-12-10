<div class="container">
    <h2>Bin</h2>
    <hr>

    <?php if (!empty($bin) && is_array($bin)): ?>
    <div class="row">
        <div class="col-md-12">

            <table class="table table-striped table-bordered table-hover table-condensed"
                    id="binSelectTable4"
                    data-toggle="table"
                    data-pagination="true"
                    data-search="true"
                    data-advanced-search="true"
                    data-id-table='advancedTable'
                    data-show-columns="true"
                    data-sort-name="bin_code"
                    data-sort-order="asc">
                <thead>
                <tr>
                    <th data-field="bin_code" data-sortable="true">Kode Bin</th>
                    <th data-field="qty_oh" data-sortable="true">Qty</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($bin as $row): ?>

                    <tr>
                        <td><?php echo $row->bin_code ?></td>
                        <td><?php echo $row->qty_oh ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>

    <?php else: ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo $bin ?>
            </div>
        </div>
    </div>
    <?php endif ?>
</div> <!-- /container -->

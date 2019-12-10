<div class="container">
    <h2>Item Detail</h2>
    <hr>

    <?php if (!empty($item) && is_array($item)): ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($item as $row): ?>
                        <tr>
                            <td><?php echo $row->item_code ?></td>
                            <td><?php echo $row->description ?></td>
                        </tr>
                        <?php break; ?>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover table-condensed"
                    id="table"
                    data-toggle="table"
                    data-pagination="true"
                    data-show-export="true"
                    data-search="true"
                    data-advanced-search="true"
                    data-id-table='advancedTable'
                    data-show-columns="true"
                    data-sort-name="bin_code"
                    data-sort-order="asc">
                <thead>
                <tr>
                    <th data-formatter="runningFormatter" data-field="no">No</th>
                    <th data-field="bin_code" data-sortable="true">Bin Code</th>
                    <th data-field="uom" data-sortable="true">UoM</th>
                    <th data-field="qty" data-align="right" data-sortable="true">Qty</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($item as $row): ?>
                    <?php
                    // Link edit, hapus, cetak
                    //$link_detail = anchor('item/detail/'.$row->id, '<span class="glyphicon glyphicon-list-alt"></span>', array('title' => 'Item Detail'));
                    //$link_hapus = anchor('item/hapus/'.$row->id,'<span class="glyphicon glyphicon-trash"></span>', array('title' => 'Hapus', 'data-confirm' => 'Anda yakin akan menghapus data ini?'));
                    //$link_hapus = anchor('warehouse/hapus/'.$row->id.'/'.$row->wh_code,'<span class="glyphicon glyphicon-trash"></span>', array('title' => 'Hapus', 'data-confirm' => 'Anda yakin akan menghapus data ini?'));
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $row->bin_code ?></td>
                        <td><?php echo $row->uom ?></td>
                        <td align="right"><?php echo number_format($row->qty,2,",",".") ?></td>
                        <!--<td><?php echo $link_detail.'&nbsp;&nbsp;&nbsp;&nbsp;' ?></td>-->
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
                <?php echo $item ?>
            </div>
        </div>
    </div>
    <?php endif ?>
</div> <!-- /container -->

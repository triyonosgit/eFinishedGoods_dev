<div class="container">
    <h2>Rack</h2>
    <hr>



    <?php if (!empty($rack) && is_array($rack)): ?>
    <div class="row">
        <div class="col-md-12">
            <?php if ($fromOrto == 'from'): ?>
                <table class="table table-striped table-bordered table-hover table-condensed"
                        id="rackTransferToTable"
                        data-toggle="table"
                        data-pagination="true"
                        data-search="true"
                        data-advanced-search="true"
                        data-id-table='advancedTable'
                        data-show-columns="true"
                        data-sort-name="rack_code"
                        data-sort-order="asc">
            <?php endif; ?>

            <?php if ($fromOrto == 'to'): ?>
                <table class="table table-striped table-bordered table-hover table-condensed"
                        id="rackTransferToTable2"
                        data-toggle="table"
                        data-pagination="true"
                        data-search="true"
                        data-advanced-search="true"
                        data-id-table='advancedTable'
                        data-show-columns="true"
                        data-sort-name="rack_code"
                        data-sort-order="asc">
            <?php endif; ?>
                    <thead>
                        <tr>
                            <th data-formatter="runningFormatter" data-field="no">No</th>
                            <th data-field="rack_code" data-sortable="true">Rack Code</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($rack as $row): ?>
                        <tr>
                            <td></td>
                            <td><?php echo $row->rack_code ?></td>
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
                <?php echo $rack ?>
            </div>
        </div>
    </div>
    <?php endif ?>



</div> <!-- /container -->

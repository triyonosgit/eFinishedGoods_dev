<div class="container">
    <h2>Bin</h2>
    <hr>

    <div class="row">
        <div class="col-md-12">
        <?php
            echo anchor('bin/tambah', 'Tambah', 'class="btn btn-primary"');
            //echo '&nbsp;&nbsp;&nbsp;&nbsp;';
            //echo anchor('bin/tambah', 'Bin Tambah', 'class="btn btn-primary"');
        ?>
        </div>
    </div>
    <br>

    <?php if (!empty($bin) && is_array($bin)): ?>
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
                    data-sort-name="uom"
                    data-sort-order="asc">
                <thead>
                <tr>
                    <th data-formatter="runningFormatter" data-field="no">No</th>
                    <th data-field="bin_code" data-sortable="true">Bin Code</th>
                    <th data-field="block" data-sortable="true">Block</th>
                    <th data-field="column" data-sortable="true">Column</th>
                    <th data-field="level" data-sortable="true">Level</th>
                    <th data-field="description" data-sortable="true">Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($bin as $row): ?>
                    <?php
                    // Link edit, hapus, cetak
                    $link_edit = anchor('bin/edit/'.$row->id, '<span class="glyphicon glyphicon-edit"></span>', array('title' => 'Edit'));
                    $link_hapus = anchor('bin/hapus/'.$row->id,'<span class="glyphicon glyphicon-trash"></span>', array('title' => 'Hapus', 'data-confirm' => 'Anda yakin akan menghapus data ini?'));
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $row->bin_code ?></td>
                        <td><?php echo $row->block ?></td>
                        <td><?php echo $row->column ?></td>
                        <td><?php echo $row->level ?></td>
                        <td><?php echo $row->description ?></td>
                        <!--<td><?php echo $link_hapus ?></td>-->
                        <td><?php echo $link_edit.'&nbsp;&nbsp;&nbsp;&nbsp;'.$link_hapus ?></td>
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

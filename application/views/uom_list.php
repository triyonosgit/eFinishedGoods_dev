<div class="container">
    <h3>Unit of Measure</h3>
    <hr>

    <div class="row"> 
        <div class="col-md-12">   
        <?php
            echo anchor('uom/tambah', 'Tambah', 'class="btn btn-primary"');
            //echo '&nbsp;&nbsp;&nbsp;&nbsp;';
            //echo anchor('bin/tambah', 'Bin Tambah', 'class="btn btn-primary"');
        ?>
        </div>
    </div>
    <br>
    <?php if (!empty($uom) && is_array($uom)): ?>
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
                    <th data-field="uom" data-sortable="true">UoM</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($uom as $row): ?>
                    <?php
                    // Link edit, hapus, cetak
                    $link_edit = anchor('uom/edit/'.$row->id, '<span class="glyphicon glyphicon-edit"></span>', array('title' => 'Edit'));
                    $link_hapus = anchor('uom/hapus/'.$row->id,'<span class="glyphicon glyphicon-trash"></span>', array('title' => 'Hapus', 'data-confirm' => 'Anda yakin akan menghapus data ini?'));
                    ?>
                    <tr>
                        <td></td>
                        <!--<td><?php echo ++$offset ?></td>-->
                        <td><?php echo $row->uom ?></td>
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
                <?php echo $uom ?>
            </div>
        </div>
    </div>
    <?php endif ?>
</div> <!-- /container -->
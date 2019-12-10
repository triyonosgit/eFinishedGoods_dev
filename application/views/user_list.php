<div class="container">
    <h2>User</h2>
    <hr>
    <?php
        echo anchor('user/tambah', 'Tambah', 'class="btn btn-primary"');
    ?>
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
                      data-sort-name="nama"
                      data-sort-order="asc">
                <thead>
                <tr>
                    <th data-formatter="runningFormatter" data-field="no">No</th>
                    <th data-field="username" data-sortable="true">Username</th>
                    <th data-field="nama" data-sortable="true">Nama</th>
                    <th data-field="level" data-sortable="true">Level</th>
                    <th data-field="status" data-sortable="true">Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($user as $row): ?>
                    <?php
                    // Link edit, hapus, cetak
                    $link_edit = anchor('user/edit/'.$row->id, '<span class="glyphicon glyphicon-edit"></span>', array('title' => 'Edit'));
                    //$link_hapus = anchor('user/hapus/'.$row->id,'<span class="glyphicon glyphicon-trash"></span>', array('title' => 'Hapus', 'data-confirm' => 'Anda yakin akan menghapus data ini?'));
                    $link_status = anchor('user/status/'.$row->id,'<span class="glyphicon glyphicon-ban-circle"></span>', array('title' => 'Ubah Status ', 'data-confirm' => 'Anda yakin akan mengubah status user?'));
                    $link_password = anchor('password/reset/'.$row->id,'<span class="glyphicon glyphicon-check"></span>', array('title' => 'Reset Password '));
                    if (($row->enable) == 1) {
                        $status = 'Aktif';
                    }
                    else {
                        $status = 'Tidak Aktif';
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $row->username ?></td>
                        <td><?php echo $row->nama ?></td>
                        <td><?php echo $row->level ?></td>
                        <td><?php echo $status?></td>
                        <td><?php echo $link_edit.'&nbsp;&nbsp;&nbsp;&nbsp;'.$link_status.'&nbsp;&nbsp;&nbsp;&nbsp;'.$link_password?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>


</div> <!-- /container -->

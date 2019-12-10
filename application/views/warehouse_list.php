<?php
// Nomor urut data di tabel.
$per_page = 2;

// Posisi nomor halaman (untuk paging) jika user login / tidak.
$login_status = $this->session->userdata('login_status');
$user_level = $this->session->userdata('user_level');
$page = $this->uri->segment(3);

/*
if ($login_status ==  true && $user_level == 'peserta') {
//if ($login_status ==  true) {
    $page = $this->uri->segment(4);
} else {
    $page = $this->uri->segment(3);
}
*/


// Nomor urut data di tabel.
// Ini karena library pagination menggunakan option 'use_page_numbers' => true.
if (empty($page)) {
    $offset = 0;
} else {
    $offset = ($page * $per_page - $per_page);
}
?>

<div class="container">
    <h2>Warehouse</h2>
    <hr>

    <!-- Paging dan form pencarian -->
    <div class="row navigasi_cari">
        <!-- Paging -->
        <div class="col-xs-12 col-md-6">
            <?php echo (!empty($paging)) ? $paging : ''?>
        </div>
        <!-- /Paging -->

        <!-- Form Pencarian -->
        <div class="col-xs-12 col-md-5 pull-right">
            <form method="get" action="<?php echo $form_action;?>" role="form" class="form-horizontal">
                <div class="input-group">
                    <input type="text" name="kata_kunci" class="form-control" placeholder="Masukkan Warehouse Code, Description, atau Location" id="kata_kunci" value="<?php echo $this->input->get('kata_kunci')?>">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /Form Pencarian -->
    </div>
    <!-- /Paging dan form pencarian -->

    <?php if (!empty($warehouse) && is_array($warehouse)): ?>
    <div class="row">
        <div class="col-md-12">

            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Warehouse Code</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($warehouse as $row): ?>
                    <?php
                    // Link edit, hapus, cetak
                    $link_edit = anchor('warehouse/edit/'.$row->id, '<span class="glyphicon glyphicon-edit"></span>', array('title' => 'Edit'));
                    $link_hapus = anchor('warehouse/hapus/'.$row->id,'<span class="glyphicon glyphicon-trash"></span>', array('title' => 'Hapus', 'data-confirm' => 'Anda yakin akan menghapus data ini?'));
                    //$link_hapus = anchor('warehouse/hapus/'.$row->id.'/'.$row->wh_code,'<span class="glyphicon glyphicon-trash"></span>', array('title' => 'Hapus', 'data-confirm' => 'Anda yakin akan menghapus data ini?'));
                    ?>
                    <tr>
                        <td><?php echo ++$offset ?></td>
                        <td><?php echo $row->wh_code ?></td>
                        <td><?php echo $row->description ?></td>
                        <td><?php echo $row->location ?></td>
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
                <?php echo $warehouse ?>
            </div>
        </div>
    </div>
    <?php endif ?>

    <?php
        echo anchor('warehouse/tambah', 'Tambah', 'class="btn btn-primary"');
    ?>

</div> <!-- /container -->
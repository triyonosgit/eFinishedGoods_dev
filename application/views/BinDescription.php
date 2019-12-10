<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>asset/bootstrap_3_2_0/css/bootstrap.min.css" rel="stylesheet">

<!-- <div class="container"> -->

<body class="align-content-center">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-header text-center">Bin Iinformation</h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="bg-info">
                            <th>#</th>
                            <th>Bin Code</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($BinDesc as $id) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $id['bin_code'] ?></td>
                                <td><?= $id['description'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<!-- </div> -->



<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>asset/bootstrap_3_2_0/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#example').DataTable({
            dom: 'Bfrtip',
            "searching": false,
            "columnDefs": [],
            "order": [
                [0, 'asc']
            ],
            "displayLength": 20,
            buttons: [
                'copyHtml5',
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'BIN description per-' + '<?= date('Y-m-d') ?>',
                    fontSize: 8,
                    orientation: 'Potrait',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                }
            ],

        });
    });
</script>
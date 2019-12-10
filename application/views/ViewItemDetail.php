<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<!-- <div class="container"> -->
<div class="row">
    <div class="col-sm-12">
        <h3 class="page-header">ITEM DETAIL</h3>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr class="bg-info">
                        <th><b>Kode_Item</b></th>
                        <th><b>Description</b></th>
                        <th><b>Category</b></th>
                        <th><b>Bin</b></th>
                        <th><b>Uom</b></th>
                        <th><b>Qty</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ItemDetail as $id) : ?>
                        <tr>
                            <td><?= $id['item_code'] ?></td>
                            <td><?= $id['description'] ?></td>
                            <td><?= $id['category'] ?></td>
                            <td><?= $id['bin_code'] ?></td>
                            <td><?= $id['uom'] ?></td>
                            <td><?= $id['qty'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th><b>Kode_Item</b></th>
                        <th><b>Description</b></th>
                        <th><b>Category</b></th>
                        <th><b>Bin</b></th>
                        <th><b>Uom</b></th>
                        <th><b>Qty</b></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- </div> -->



<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/buttons.html5.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });
        var table = $('#example').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [],
            "order": [
                [0, 'asc']
            ],
            "displayLength": 20,
            buttons: [
                'copyHtml5',
                {
                    extend: 'excel',
                    title: 'Item Detail ' + '<?= date('Y-m-d') ?>'
                },
                'csvHtml5',

                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Item Detail ' + '<?= date('Y-m-d') ?>',
                    fontSize: 8,
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ],

        });

        table.columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change clear', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
    });
</script>
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<!-- <div class="container"> -->
<div class="row">
    <div class="col-sm-12">
        <h3 class="page-header">ITEM HISTORY</h3>

        <form method="POST" id="filter_panel" action="GetItemHistory">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">TANGGAL TRANSAKSI</label>
                <div class="col-sm-2">
                    <div class="input-group date">
                        <input type="text" id="datepicker1" class="form-control" name="datepicker1">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <label for="sd" class="col-sm-1 col-form-label">&nbsp;&nbsp;&nbsp;s/d</label>
                <div class="col-sm-2">
                    <div class="input-group date">
                        <input type="text" id="datepicker2" class="form-control" name="datepicker2">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-2">
                    <button type="submit" id="btnProcess" class="btn btn-primary"> Proses </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table id="TableIH" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Trans Type</th>
                    <th>Bin Code</th>
                    <th>Description</th>
                    <th>Uom</th>
                    <th>Old QTy</th>
                    <th>Qty</th>
                    <th>New Qty</th>
                    <th>Reference</th>
                    <th>Vendor</th>
                    <th>From Bin</th>
                    <th>To Bin</th>
                    <th>Created BY</th>
                    <th>Created Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ItemHistory as $ih) : ?>
                    <tr>
                        <td><?= $ih['created_att'] ?></td>
                        <td align="center"><?= $ih['trans_type'] ?></td>
                        <td><?= $ih['bin_code'] ?></td>
                        <td><?= $ih['description'] ?></td>
                        <td><?= $ih['uom'] ?></td>
                        <td><?= $ih['old_qty'] ?></td>
                        <td><?= $ih['qty'] ?></td>
                        <td><?= $ih['new_qty'] ?></td>
                        <td><?= $ih['reference'] ?></td>
                        <td><?= $ih['vendor'] ?></td>
                        <td><?= $ih['from_bin_code'] ?></td>
                        <td><?= $ih['to_bin_code'] ?></td>
                        <td><?= $ih['created_by'] ?></td>
                        <td><?= $ih['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        var dtfrselectedYN = '<?php echo $dtfrselectedYN; ?>';
        var dttoselectedYN = '<?php echo $dttoselectedYN; ?>';
        var frdate = '<?php echo $frdate; ?>';
        var todate = '<?php echo $todate; ?>';

        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }

        var todayYmd = yyyy + '-' + mm + '-' + dd;

        $("#datepicker1").datepicker({
            format: 'yyyy-mm-dd',
            //"setDate": new Date(),
            autoclose: true,
            todayHighlight: true,
        });

        $("#datepicker2").datepicker({
            format: 'yyyy-mm-dd',
            //"setDate": new Date(),
            autoclose: true,
            todayHighlight: true,
        });

        if (dtfrselectedYN == 'Y') {
            $("#datepicker1").val(frdate);
        } else {
            $("#datepicker1").val(todayYmd);
        }

        if (dttoselectedYN == 'Y') {
            $("#datepicker2").val(todate);
        } else {
            $("#datepicker2").val(todayYmd);
        }

        $('#datepicker1').datepicker().on('changeDate', function(ev) {
            // $("#datepicker2").val(ev.format());
        });

        $('#datepicker2').datepicker().on('changeDate', function(ev) {
            if (ev.format() < $("#datepicker1").val()) {
                $("#datepicker1").val(ev.format());
            }
        });


        var table = $('#TableIH').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [],
            "order": [
                [0, 'asc']
            ],
            "displayLength": 25,
            buttons: [
                'copyHtml5',
                {
                    extend: 'excel',
                    title: 'Item History ' + frdate + ' sd ' + todate
                },
                'csvHtml5',

                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Item History ' + frdate + ' sd ' + todate,
                    fontSize: 8,
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                    }
                }
            ],

        });
    });
</script>
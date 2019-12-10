<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<div class="container">
    <div class="row">
        <h3 class="page-header">Summary Transaksi per Tanggal </h3>

        <form method="POST" id="filter_panel" action="getTransByDate">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Transaksi</label>
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

    <div class="row">
        <table id="smrytranstbl" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                 <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Kode Item</th>
                    <th>Deskripsi</th>
                    <th>UoM</th>
                    <th>Bin</th>
                    <th>Saldo Awal</th>
                    <th>Qty Masuk</th>
                    <th>Qty Keluar</th>
                    <th>Saldo Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach($smryrecord as $t): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td align="center"><?php echo $t->tanggal; ?></td>
                    <td><?php echo $t->item_code; ?></td>
                    <td><?php echo $t->description; ?></td>
                    <td align="center"><?php echo $t->uom; ?></td>
                    <td align="center"><?php echo $t->bin_code; ?></td>
                    <td align="right"><?php echo $t->saldo_awal; ?></td>
                    <td align="right"><?php echo $t->qty_masuk; ?></td>
                    <td align="right"><?php echo $t->qty_keluar; ?></td>
                    <td align="right"><?php echo $t->saldo_akhir; ?></td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>



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
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        var dtfrselectedYN = '<?php echo $dtfrselectedYN; ?>';
        var dttoselectedYN = '<?php echo $dttoselectedYN; ?>';
        var frdate = '<?php echo $frdate; ?>';
        var todate = '<?php echo $todate; ?>';

        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }

        var todayYmd = yyyy+'-'+mm+'-'+dd;

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

        $('#datepicker1').datepicker().on('changeDate', function (ev) {
            $("#datepicker2").val(ev.format());
        });

        $('#datepicker2').datepicker().on('changeDate', function (ev) {
            if (ev.format() < $("#datepicker1").val()) {
                $("#datepicker1").val(ev.format());
            }
        });


        var table = $('#smrytranstbl').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 25,
            buttons: [
                'copyHtml5',
                { extend: 'excel',
				  title: 'Summary Transaksi '+frdate+' sd '+todate },
                'csvHtml5',

                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Summary Issued Items',
                    fontSize: 8,
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 5, 6 ]
                    }
                }
            ],

        } );
    });
</script>

<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<!-- <div class="container"> -->
<div class="row">
    <div class="col-sm-12">
        <h3 class="page-header">BST per Tanggal </h3>

        <form method="POST" id="filter_panel" action="getBstByDate">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal BST</label>
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
                    <button type="submit" value="keyword" id="btnProcess" class="btn btn-primary"> Proses </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table id="smrytranstbl" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor BST</th>
                    <th>Tgl. Input</th>
                    <th>User Prd.</th>
                    <th>Status</th>
                    <th>Kode Item</th>
                    <th>Deskripsi</th>
                    <th>Qty</th>
                    <th>UoM</th>
                    <th>Nomor SPK</th>
                    <th>Nomor WO</th>
                    <th>Nomor Pack QC</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($listbst as $t) : ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td align="center"><?php echo $t->hvr_nbr; ?></td>
                        <td align="center"><?php echo $t->hvr_adddt; ?></td>
                        <td><?php echo $t->hvr_useradd; ?></td>
                        <td><?php echo $t->code_cmmt; ?></td>
                        <td><?php echo $t->hod_item; ?></td>
                        <td><?php echo $t->hod_desc; ?></td>
                        <td align="right"><?php echo $t->hod_qty; ?></td>
                        <td align="center"><?php echo $t->hod_uom; ?></td>
                        <td><?php echo $t->hod_spk; ?></td>
                        <td><?php echo $t->hod_wo; ?></td>
                        <td><?php echo $t->hod_packnbr; ?></td>
                        <td><?php echo $t->hod_rmks; ?></td>
                    </tr>
                    <?php $i++; ?>
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


        var table = $('#smrytranstbl').DataTable({
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
                    title: 'Laporan BST ' + frdate + ' sd ' + todate
                },
                'csvHtml5',

                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Summary Issued Items',
                    fontSize: 8,
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 5, 6]
                    }
                }
            ],

        });
    });
</script>
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<div class="container">
    <div class="row">
        <h3 class="page-header">Issued Items </h3>

        <form method="POST" id="filter_panel" action="getIssuedItems">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Issued</label>
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


        <ul class="nav nav-tabs">
            <li class="active"><a href="#1" data-toggle="tab">Detail</a></li>
            <li><a href="#2" data-toggle="tab">Summary</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="1">
                <br>

                <table id="dtlissitems" class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                         <tr>
                            <th>Date</th>
                            <th>Reference</th>
                            <th>Item Code</th>
                            <th>Description</th>
                            <th>Item Type</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Uom</th>
                            <th>Vendor</th>
                            <th>Updated at</th>
                            <th>Udated by</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dtlrecord as $t): ?>
                        <tr>
                            <td><?php echo $t->transdate; ?></td>
                            <td><?php echo $t->reference; ?></td>
                            <td><?php echo $t->item_code; ?></td>
                            <td><?php echo $t->description; ?></td>
                            <td><?php echo $t->item_type; ?></td>
                            <td><?php echo $t->category; ?></td>
                            <td align="right"><?php echo $t->qty; ?></td>
                            <td align="center"><?php echo $t->uom; ?></td>
                            <td><?php echo $t->vendor; ?></td>
                            <td><?php echo $t->updated_at; ?></td>
                            <td><?php echo $t->updated_by; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="2">
                <br>

                <table id="smryissitems" class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                         <tr>
                            <th>Date</th>
                            <th>Item Code</th>
                            <th>Description</th>
                            <th>Item Type</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Uom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($smryrecord as $t): ?>
                        <tr>
                            <td><?php echo $t->transdate; ?></td>
                            <td><?php echo $t->item_code; ?></td>
                            <td><?php echo $t->description; ?></td>
                            <td><?php echo $t->item_type; ?></td>
                            <td><?php echo $t->category; ?></td>
                            <td align="right"><?php echo $t->tot_qty; ?></td>
                            <td align="center"><?php echo $t->uom; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
			</div>
		</div>
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

        // $('#btnProcess').on('click', function() {
        //     alert('alhamdulillah');
        // });

        var groupColumn = 0;
        var table = $('#dtlissitems').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
            ],
            "order": [[ groupColumn, 'asc' ]],
            "displayLength": 25,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Detail Issued Items',
                    fontSize: 8,
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                    }
                }
            ],
            
        });


        var table2 = $('#smryissitems').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 25,
            buttons: [
                'copyHtml5',
                'excelHtml5',
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


<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<div class="container">
    <div class="row">
        <h3 id="rpttitle" class="page-header"></h3>

        <form method="POST" id="filter_panel" action="getItemQtyOH">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label">Bin Code</label>
                <div class="col-sm-2">
                    <div class="form-inline">
                        <input type="text" name="bin_code" value="" id="bin_code" class="form-control" maxlength="6" readonly="true" style="width: 110px" />
                        <button name="btnSrcBin" type="button" id="btnSrcBin" onclick="selBin3()" >
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label"></label>
                <div class="col-sm-2">
                    <button type="submit" id="btnProcess" class="btn btn-primary"> Proses </button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <table id="itemtable" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                 <tr>
                    <th>#</th>
                    <th>Kode Item</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>UoM</th>
                    <th>Bin</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach($listitem as $t): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $t->item_code; ?></td>
                    <td><?php echo $t->description; ?></td>
                    <td><?php echo $t->category; ?></td>
                    <td align="center"><?php echo $t->uom; ?></td>
                    <td align="center"><?php echo $t->bin_code; ?></td>
                    <td align="right"><?php echo $t->qty; ?></td>
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
        var isbinselect = '<?php echo $isbinselect; ?>';
        var selbin = '<?php echo $selbin; ?>';

        function js_yyyy_mm_dd_hh_mm_ss () {
            now = new Date();
            year = "" + now.getFullYear();
            month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
            day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
            hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
            minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
            second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
            return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
        }

        $('#rpttitle').text('Saldo Item per Bin pada '+ js_yyyy_mm_dd_hh_mm_ss());

        if (isbinselect == 'Y') {
            $("#bin_code").val(selbin);
        } else {
            $("#bin_code").val('ALL');
        }

        var table = $('#itemtable').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 25,
            buttons: [
                'copyHtml5',
                { extend: 'excel',
                  title: 'Saldo Item per Bin pada '+js_yyyy_mm_dd_hh_mm_ss() },
                'csvHtml5',

                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Saldo item per Bin pada '+js_yyyy_mm_dd_hh_mm_ss(),
                    fontSize: 8,
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    }
                }
            ],

        } );
    });


    // eat 20190517
    function selBin3() {
        // alert('test');
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var w = 1000;
        var h = 500;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var params = 'width='+w+', height='+h+', scrollbars=yes';
        params += ', top='+top+', left='+left+'';
        //var newWindow = window.open("../bin/select", '', params);
        
        var newWindow = window.open("../bin/select3", '', params);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }
</script>

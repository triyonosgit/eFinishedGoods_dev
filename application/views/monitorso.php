<?php
$base_url = base_url();
?>

<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<style>
    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
</style>


<div class="row">
    <div align="center">
        <h3>Monitoring Stock Opname [ <?php echo $stonbr; ?> ]</h3>
    </div>
    
    <form method="POST" id="filter_panel" action="monitorso">
        <div class="col-sm-12">
            <div class="col-sm-1">
                <label>Rack</label>
            </div>

            <div class="col-sm-4">
                <div class="form-group has-feedback ">      

                    <div class="form-inline">
                        <?php if ($frrack == '000000'): ?>
                            <input type="text" name="fr_rack_code" value="" id="fr_rack_code" class="form-control" placeholder="Rack" maxlength="6" readonly="true" style="width: 110px" />
                        <?php else: ?>
                            <input type="text" name="fr_rack_code" value="<?php echo $frrack; ?>" id="fr_rack_code" class="form-control" placeholder="Rack" maxlength="6" readonly="true" style="width: 110px" />
                        <?php endif; ?>
                            <button name="btn_frrack" type="button" id="btn_frrack" onclick="selectRack('index')" >
                                <span class="glyphicon glyphicon-search"></span>
                            </button>

                            &nbsp;&nbsp;&nbsp;sd&nbsp;&nbsp;&nbsp;

                        <?php if ($torack == 'ZZZZZZ'): ?>
                            <input type="text" name="to_rack_code" value="" id="to_rack_code" class="form-control" placeholder="Rack" maxlength="6" readonly="true" style="width: 110px" />
                        <?php else: ?>
                            <input type="text" name="to_rack_code" value="<?php echo $torack; ?>" id="to_rack_code" class="form-control" placeholder="Rack" maxlength="6" readonly="true" style="width: 110px" />
                        <?php endif; ?>
                            <button name="btn_torack" type="button" id="btn_torack" onclick="selectRack2('index', $('#fr_rack_code').val())" >
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-sm-12">
            <div class="col-sm-1">
                <label></label>
            </div>

            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary" style='width: 110px'> Proses </button>
            </div>
        </div>
    </form>
</div>
<hr>

<table id="binitems" class="table table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Rack</th>
            <th>Bin</th>
            <th>Item Cd</th>
            <th>Description</th>
            <th>Category</th>
            <th>UoM</th>
            <th>Qty eStock</th>
            <th>Qty Fisik</th>
            <th>Qty to Adj</th>
            <th>Qty NG</th>
            <th>Keterangan</th>
            <th>User</th>
            <th>Tgl. Update</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($tabelrecord as $t): ?>
        <tr>
            <td><?php echo $t->rack; ?></td>
            <td><?php echo $t->bin_code; ?></td>
            <td><?php echo $t->item_code; ?></td>
            <td><?php echo $t->description; ?></td>
            <td><?php echo $t->category; ?></td>
            <td><?php echo $t->uom; ?></td>
            <td align="right"><?php echo $t->sto_qty; ?></td>
            <td align="right"><?php echo $t->sto_qtyreal; ?></td>
        <?php if ($t->qty_to_adj > 0): ?>
            <td align="right"><?php echo '+ '. $t->qty_to_adj; ?></td>
        <?php else: ?>
            <td align="right"><?php echo $t->qty_to_adj; ?></td>
        <?php endif; ?>
            <td align="right"><?php echo $t->sto_qtyng; ?></td>
            <td><?php echo $t->sto_rmks; ?></td>
            <td><?php echo $t->sto_updatedby; ?></td>
            <td><?php echo $t->sto_updateddt; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/buttons.html5.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // $('#binitems').DataTable();

        var groupColumn = 0;
        var table = $('#binitems').DataTable({
            dom: 'Bfrtip',
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
            "order": [[ groupColumn, 'asc' ]],
            "displayLength": 25,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
    
                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="12">'+group+'</td></tr>'
                        );
    
                        last = group;
                    }
                } );
            },
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if ( parseInt(aData[8]) != 0 && aData[11] != '' )
                {
                    $('td', nRow).css('background-color', 'Yellow');
                }
            },
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Hasil Input Stock Opname',
                    fontSize: 8,
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 5, 6, 7, 8, 9, 10, 11 ]
                    }
                }
            ],
            
        } );
    
        // Order by the grouping
        $('#binitems tbody').on( 'click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
                table.order( [ groupColumn, 'desc' ] ).draw();
            }
            else {
                table.order( [ groupColumn, 'asc' ] ).draw();
            }
        } );

        $('#btnPdf').on('click', function() {
            //alert($('#fr_rack_code').val() + $('#to_rack_code').val()); die();
            if ($('#fr_rack_code').val() == '') {
                alert('Rack harus dipilih terlebih dahulu !');
            } else {
                printPdf($('#fr_rack_code').val(), $('#to_rack_code').val());
            }
        });

         function printPdf(fr, to) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/prnsoitem/paramPdf' ?>",
                data: {
                   frrack: fr,
                   torack: to
                },
                success: function(response) {
                    var win = window.open('<?= $base_url . 'index.php/prnsoitem/printPdfSOitem?fr=' ?>'+response.frrack+'&to='+response.torack, '', 'height=820,width=1100,scrollbars=yes'); 
                },
                error: function() {
                    alert("Error");
                    //$('.loading').show();
                }
            });
        }

        $('#btnExcel').on('click', function() {
			
			
		});


    } );
</script>
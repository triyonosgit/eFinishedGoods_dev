<?php
$base_url = base_url();
?>

<link href="<?php echo base_url('asset/dataTables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<style>
    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
</style>

<div class='container'>
	<div class="row">
		<h3>Cetak Daftar Item Stock Opname - [ Nomor : <?php echo $stonbr; ?> ]</h3>
		<hr>
		
        <form method="POST" id="filter_panel" action="prnsoitem">
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

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="pull-right"> 
                <button type="button" id="btnPdf" class="btn btn-danger">Print PDF</button>
            </div>
        </div>
        <br><br>

        <table id="binitems" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Rack</th>
                    <th>Bin</th>
                    <th>Item Cd</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>UoM</th>
                    <th>Qty</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Rack</th>
                    <th>Bin</th>
                    <th>Item Cd</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>UoM</th>
                    <th>Qty</th>
                </tr>
            </tfoot>

            <tbody>
                <?php foreach($tabelrecord as $t): ?>
                <tr>
                    <td><?php echo $t->rack; ?></td>
                    <td><?php echo $t->bin_code; ?></td>
                    <td><?php echo $t->item_code; ?></td>
                    <td><?php echo $t->description; ?></td>
                    <td><?php echo $t->category; ?></td>
                    <td><?php echo $t->uom; ?></td>
                    <td align="right"><?php echo $t->qty; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url('asset/dataTables/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/dataTables/js/dataTables.bootstrap.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // $('#binitems').DataTable();

        var groupColumn = 0;
        var table = $('#binitems').DataTable({
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
                            '<tr class="group"><td colspan="6">'+group+'</td></tr>'
                        );
    
                        last = group;
                    }
                } );
            }
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
                printPdf('<?php print($stonbr); ?>',  $('#fr_rack_code').val(), $('#to_rack_code').val());
            }
        });

         function printPdf(nbr, fr, to) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/prnsoitem/paramPdf' ?>",
                data: {
                   stonbr: nbr,
                   frrack: fr,
                   torack: to
                },
                success: function(response) {
                    var win = window.open('<?= $base_url . 'index.php/prnsoitem/printPdfSOitem?nbr=' ?>'+response.stonbr+'&fr='+response.frrack+'&to='+response.torack, '', 'height=820,width=1100,scrollbars=yes'); 
                },
                error: function() {
                    alert("Error");
                    //$('.loading').show();
                }
            });
        }


    } );
</script>
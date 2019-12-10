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

<div class='container'>
    <h3>Closing Stock Opname - [ <?php echo $stonbr; ?> ]</h3>
    <hr>

    <div class="row">
        <div class="col-md-4">
            <button type="button" id="btnAdjust" class="btn btn-danger btn-block">Adjust and Close Stock Opname</button>
        </div>
         
    </div>
    <br><br>

    <div class="col-md-12">
        <table id="diffitems" class="display" cellspacing="0" width="100%">
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
                    <th>Qty to Adjust</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($diffrecord as $t): ?>
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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="modal fade" id="confirm_adj" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"></h3>
                    </div>
                    <div class="modal-body form">
                        Apakah anda yakin akan melakukan adjusment dan meng-close stock opname ini?
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" id="btnProcess" class="btn btn-primary">Proses</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
    
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>asset/jquery-loading-overlay-2.1.6/dist/loadingoverlay.min.js"></script>
<!-- <script type="text/javascript" language="javascript" src="<?php // echo base_url(); ?>assets/js/jquery-3.3.1.js"></script> -->
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var groupColumn = 0;
        var table = $('#diffitems').DataTable({
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
                            '<tr class="group"><td colspan="9">'+group+'</td></tr>'
                        );
    
                        last = group;
                    }
                } );
            }
        });

        // Order by the grouping
        $('#diffitems tbody').on( 'click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
                table.order( [ groupColumn, 'desc' ] ).draw();
            }
            else {
                table.order( [ groupColumn, 'asc' ] ).draw();
            }
        } );

        $('#btnProcess').on('click', function() {
            $.LoadingOverlay("show");

            adjStock();
        });

        $('#btnAdjust').click(function(e) {
			e.preventDefault();
			
			$('#confirm_adj').modal('show'); 
			$('.modal-title').text('Konfirmasi Adjust dan Closing Stock Opname'); 
		});

        function adjStock() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/adjqtyso/adjStock' ?>",
                data: {
                    
                },
                success: function(response) {
                    $.LoadingOverlay("hide");
                    $('#confirm_adj').modal('hide'); 

                    alert(response.successMessage);
                },
                error: function() {
                    alert("Error");
                    $.LoadingOverlay("hide");
                }
            });
        }

    } );
</script>
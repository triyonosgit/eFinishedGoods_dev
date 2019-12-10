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
    <h3>Generate Data Stock Opname</h3>
    <hr>

    <div class="row">
        <div class="col-md-4">
            <button type="button" id="btnGenerate" class="btn btn-primary btn-block">Generate</button>
        </div>
    </div>
    <br><br>

    <div class="col-md-10">
        <table id="stoheader" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>SO Number</th>
                    <th>Start Date</th>
                    <th>Finish Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; ?>
                <?php foreach($tabelrecord as $t): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $t->sto_nbr; ?></td>
                    <td><?php echo $t->sto_strdate; ?></td>
                    <td><?php echo $t->sto_findate; ?></td>
                    <td><?php echo $t->sto_status; ?></td>

                    <?php $i++; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>asset/jquery-loading-overlay-2.1.6/dist/loadingoverlay.min.js"></script>
<!-- <script type="text/javascript" language="javascript" src="<?php // echo base_url(); ?>assets/js/jquery-3.3.1.js"></script> -->
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#stoheader').DataTable({

        });

        $('#btnGenerate').on('click', function() {
            //dnldData();
            isAnyOpenSO();
        });
        
        function isAnyOpenSO() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/generateso/isAnyOpenSO' ?>",
                data: {
                },
                success: function(response) {
                    if (response.result === 'ada') {
                        alert('Stock Opname terakhir belum close, tidak bisa generate!');
                    } else {
                        $.LoadingOverlay("show");
                        dnldData();
                    }
                },
                error: function() {
                    alert("Error");
                    //$('.loading').show();
                }
            });
        }

        function dnldData() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/generateso/dnldData' ?>",
                data: {
                    
                },
                beforeSend: function() {
                    //$('.loading').show();
                },
                success: function(response) {
                    $.LoadingOverlay("hide");

                    alert(response.successMessage);
                    location.reload(true);
                },
                error: function() {
                    alert("Error");
                    //$('.loading').show();
                    $.LoadingOverlay("hide");
                }
            });
        }

    } );
</script>
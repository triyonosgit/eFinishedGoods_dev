<?php
$base_url = base_url();
?>



<div class='container'>
    <h3>Utility Ganti Kode Item</h3>
    <hr>

    <div class="row">
        <div class="col-md-4">
            <button type="button" id="btnExecute" class="btn btn-primary btn-block">Ganti Kode Item</button>
        </div>
    </div>
    <br><br>

    
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>asset/jquery-loading-overlay-2.1.6/dist/loadingoverlay.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#btnExecute').on('click', function() {
            //dnldData();
            // alert('test');
			
			$.LoadingOverlay("show");
			
			execChgItmNbr();
         });
		
		function execChgItmNbr() {
			
			
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/chgitmnbr/execChgItmNbr' ?>",
                data: {
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
		
	});
</script>
    

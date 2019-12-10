<?php
$base_url = base_url();
?>
<link href="<?php echo base_url(); ?>assets/datatables/dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

<style>
    .align-right{text-align:right;}
    .align-center{text-align:center;}
</style>

<style>
.vl {
  border-right: 3px solid green;
  height: 200px;
}
</style>

<div class="container">
    <h3>Proses Submit Bukti Serah Terima - <?php echo $nbr; ?></h3>
    <hr>

    <form>
        <div class="form-group row">
            <label class="col-sm-2">Nomor BST</label>
            <div class="col-sm-2">
                <span><?php echo $nbr; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Parent Item</label>
            <!-- <div class="form-inline">
                <div class="col-sm-10">
                    <input type="text" id="item_code" name="item_code" class="form-control" readonly="true" style="width: 160px" />
                    <button name="btn_torack" type="button" id="item_code" onclick="selectItem()" >
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    <input type="text" id="description" name="description" class="form-control" readonly="true" style="width: 500px" />
                </div>
            </div> -->
            <div class="col-sm-10">
                <input type="hidden" id="item_code" value="<?php echo $parcode; ?>">
                <span><?php echo $parcode.' - '.$pardesc; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Nomor SPK</label>
            <div class="col-sm-4">
                <span id="nomorspk"><?php echo $spknbr; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Nomor WO</label>
            <div class="col-sm-4">
                <span id="nomorwo"><?php echo $wonbr; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Nomor Pack QC</label>
            <div class="col-sm-4">
                <span id="nomorpack"><?php echo $packnbr; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Keterangan</label>
            <div class="col-sm-10">
                <span id="rmks"><?php echo $rmks; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Qty</label>
            <div class="col-sm-4">
                <input type="hidden" id="hidqty" value="<?php echo $qty; ?>">
                <span><?php echo $qty.' '.$uom; ?></span>
            </div>
        </div>
    </form>
        <hr />
        <p>Alokasi Bin</p>

    <div class="col-sm-12">
        <div class="col-sm-6" >
            <div class="vl">
                <form>
                    <div class="form-group row">
                        <label class="col-sm-3"> Bin</label>
                        <div class="form-inline">
                            <div class="col-sm-4">
                                <input type="text" id="bin_code" name="bin_code" class="form-control" readonly="true" style="width: 110px" />
                                <button name="btn_selbin" type="button" id="btn_selbin" onclick="selectBin4()" >
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Qty On Hand</label>
                        <div class="col-sm-4">
                            <input type="text" id="qty_oh" style="text-align: right; width: 80px;" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Qty Alokasi</label>
                        <div class="col-sm-4">
                            <input type="text" id="qty_allocate" value="<?php echo $qty; ?>" style="text-align: right; width: 80px;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3"> </label>
                        <div class="col-sm-3">
                            <button type="button" id="btnAllocate" class="btn-primary" style="width: 80px;"> >> </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-sm-6">
            <table id="bstitemstbl" class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode Bin</th>
                        <th>Qty OH</th>
                        <th>Qty Rcv</th>
                    </tr>
                </thead>
                <tbody id="rowitemallocate">

                </tbody>
            </table>

            <div class="col-sm-2" align="left">
                <button type="button" id="btnReset" class="btn-warning">Reset</button>
            </div>
            <div class="col-sm-2">

            </div>
            <div class="col-sm-2" align="right">
                <button type="button" id="btnProcess" class="btn-success">Proses</button>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
	$(document).ready(function() {
        var bstnbr = '<?php Print($nbr); ?>';
        var cntbinnotselect;
        var qtyalloc = 0;
        var qtytotal = 0;
        var qtysisa = 0;
        var qtyrcv = <?php Print($qty); ?>;
        var uomrcv = '<?php Print($uom); ?>';
        var tr = $('#rowitemallocate');

        clearTblAllocate();

        function clearTblAllocate() {
            tr.empty();
             qtyalloc = 0;
        }

        $('select').on('change', function (e) {
            var valueSelected = this.value;

            var arr = valueSelected.split("|");

            // alert(arr[0], arr[1]);
            getQtyOHItmBin(arr[0], arr[1] );
        });

        function getQtyOHItmBin(b, i) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/bstsubmit/getQtyOHItmBin' ?>",
                data: {
                    bin: b,
                    itm: i
                },
                success: function(response) {
                    // alert( response.binselected);
                    $('#hid'+response.itembin).val(response.binselected);
                    $('#txt'+response.itembin).text(response.qtyoh);
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        $('#btnReset').click(function() {
            location.reload();
        });

        $('#btnProcess').click(function() {
            if (qtytotal == 0) {
                alert('Alokasi bin belum dilakukan !');
            } else {
                if (qtysisa <= 0) {
                    if (confirm('Apakah alokasi bin untuk BST '+bstnbr+' sudah benar ?')) {
                        submitBST(bstnbr);
                    }
                } else {
                    alert('Masih ada '+qtysisa+' '+uomrcv+' lagi yang belum dialokasi bin !!');
                }
            }

        });

        function chkAllBinSelected() {
            cntbinnotselect = 0;
            $('#bstitemstbl tr').each(function(row, tr){
                if ($(tr).find('td:eq(8) input').val() == '-') {
                    cntbinnotselect++;
                }
            });

            return cntbinnotselect;
        }

        $('#btnAllocate').click(function() {
            qtyalloc = parseInt($('#qty_allocate').val());

            if ((qtyalloc > 0 && qtyalloc != '') && $('#qty_oh').val() != '') {
                if (qtyalloc <= qtyrcv) {
                    qtytotal = qtytotal + qtyalloc;
                    qtysisa = qtyrcv - qtytotal;

                    console.log('qty allocate = '+qtyalloc);
                    console.log('qty receive = '+qtyrcv);
                    console.log('qty total = '+qtytotal);
                    console.log('qty sisa = '+qtysisa);

                    if (qtysisa >= 0) {
                        tr.append('<tr>'+
                                        '<td align="center">'+$('#bin_code').val()+'</td>'+
                                        '<td align="center">'+$('#qty_oh').val()+'</td>'+
                                        '<td align="center">'+$('#qty_allocate').val()+'</td>'+
                                   '</tr>'
                                    );

                        $('#bin_code').val('');
                        $('#qty_oh').val('');
                        $('#qty_allocate').val(qtysisa);
                    } else {
                        alert('Total qty alokasi tidak boleh lebih dari qty receive');
                        $('#qty_allocate').val(0);
                    }
                } else {
                    alert('Total qty alokasi tidak boleh lebih dari qty receive');

                    $('#qty_allocate').val(qtyrcv);
                }
            }
        });

        function submitBST(n) {
            var TableData = new Array();

            $('#bstitemstbl tr').each(function(row, tr){
                TableData[row]={
                    "itemcode" : $('#item_code').val(),
                    "bincode" : $(tr).find('td:eq(0)').text(),
                    "qtyrcvd" : $(tr).find('td:eq(2)').text(),
                    "spknbr" : $('#nomorspk').text(),
                    "wonbr" : $('#nomorwo').text(),
                    "packnbr" : $('#nomorpack').text()
                }
            });
            TableData.shift();  // first row will be empty - so remove
            // console.log(TableData);

            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/bstsubmit/submitBST' ?>",
                data: {
                    nbr: bstnbr,
                    pTableData: TableData
                },
                success: function(response) {
                    // location.reload(true);
                    window.location.href = "<?= $base_url . 'index.php/bstsubmit' ?>";
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        $("#qty_allocate").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A, Command+A
				(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
				 // Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});

	});

</script>

<?php
$base_url = base_url();
?>

<link href="<?php echo base_url(); ?>assets/datatables/dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

<style>

    .align-right{text-align:right;}
    .align-center{text-align:center;}
</style>


<div class="container">
    <h3>Tambah Bukti Serah Terima</h3>
    <hr>

    <form id="frmAddBst">
        <div class="form-group row">
            <label class="col-sm-2">Nomor BST</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" readonly id="txtbstnbr" name="txtbstnbr" style="width: 90px" >
                <input type="hidden" id="trans_type" name="trans_type" value="BST"> <!-- ini cuma nyesuain dengan lookup yg udah ada -->
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Parent Code</label>
            <div class="form-inline">
                <div class="col-sm-10">
                    <input type="text" id="item_code" name="item_code" class="form-control" readonly="true" style="width: 160px" />
                    <button name="btn_torack" type="button" id="item_code" onclick="selectItem()" >
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    <input type="text" id="description" name="description" class="form-control" readonly="true" style="width: 500px" />
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Qty</label>
            <div class="form-inline">
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtqty" name="txtqty" style="width: 80px; text-align: right;" >
                    &nbsp;<span id="uom" name="uom"></span>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Nomor SPK</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtspk" name="txtspk" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Nomor WO</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtwo" name="txtwo" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Nomor Pack QC</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txtpacknbr" name="txtpacknbr" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Keterangan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txtrmks" name="txtrmks" >
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2"> </label>
            <div class="col-sm-3">
                <button type="button" id="btnTmpAdd" name="button">Tambah</button>
            </div>
        </div>
    </form>

    <table id="tmpitems" class="table table-striped table-hover" width="100%">
        <thead>
            <tr>
                <th style="display: none">bstnbr</th>
                <th>Kode Item</th>
                <th>Deskripsi</th>
                <th>UoM</th>
                <th>Qty</th>
                <th>SPK</th>
                <th>WO</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tritems">

        </tbody>
    </table>
    <div class="alert alert-warning" id="tmpinfo">

    </div>

    <br />
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <button type="button" id="btnDone" class="btn btn-success btn-block" data-toggle="modal" data-target="#confirmModal"><i class="glyphicon glyphicon-ok"></i> &nbsp; Selesai </button>
    </div>
    <div class="col-md-4">
    </div>

    <div class="modal fade" id="confirmModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="fa fa-clipboard fa-1x"></span> Konfirmasi Selesai Input BST</h4>
                </div>
                <div class="modal-body">
                    <p>Apakah data BST yang anda input sudah benar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal"> Tidak </button>
                    <button type="button" id="btnSubmitBst" class="btn btn-primary"> Ya </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="fa fa-clipboard fa-1x"></span> Edit Item BST</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="" id="frmUpdQty">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-lg-2" style="text-align: right">Kode Item</label>
                                <div class="col-md-8 form-inline">
                                    <input type="hidden" id="tmpid">
                                    <input type="text" id="item_code2" name="item_code2" class="form-control" readonly="true" style="width: 180px" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-lg-2" style="text-align: right">Deskripsi</label>
                                <div class="col-md-10">
                                    <input type="text" id="description2" name="description2" class="form-control" readonly="true" style="width: 96%" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-lg-2" style="text-align: right">Qty
                                    <span class="required"> * </span>
                                </label>
                                <div class="form-inline">
                                    <div class="col-md-10">
                                        <input type="text" id="txtqty2" name="txtqty2" class="form-control" style="width: 100px; text-align: right;" />
                                        &nbsp;<span id="uom2" name="uom2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-lg-2" style="text-align: right">SPK</label>
                                <div class="col-md-3">
                                    <input type="text" id="txtspk2" name="txtspk2" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-lg-2" style="text-align: right">WO</label>
                                <div class="col-md-3">
                                    <input type="text" id="txtwo2" name="txtwo2" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-lg-2" style="text-align: right">Pack</label>
                                <div class="col-md-10">
                                    <input type="text" id="txtpacknbr2" name="txtpacknbr2" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-lg-2" style="text-align: right">Keterangan</label>
                                <div class="col-md-10">
                                    <input type="text" id="txtrmks2" name="txtrmks2" class="form-control" />
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal"> Batal </button>
                    <button type="button" id="btnUpdTmpItm" class="btn btn-primary"> Simpan </button>
                </div>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatables/datatables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatables/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
        clearForm();
        getNewBstNbr();
        delTmpBstItem();

        var sel1itemYN = 'N';

        function getNewBstNbr() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/getNewBstNbr' ?>",
                data: {
                },
                success: function(response) {
                    $('#txtbstnbr').val(response.nomorbst);
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        function delTmpBstItem() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/delTmpBstItem' ?>",
                data: {
                },
                success: function(response) {
                    chkNotEmptyItm();
                    loadTmpBstItem();

                    sel1itemYN = 'N';
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        function loadTmpBstItem() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/loadTmpBstItem' ?>",
                data: {
                },
                success: function(response) {
                    var tr = $("#tritems");
                    var divinfo = $("#tmpinfo");
                    tr.empty();
                    divinfo.empty();

                    $.each(response.data, function(index, item) {
                        str_desc = item[2].replace(/ /g, '_');
                        tr.append(  '<tr>'+
                                        '<td style="display: none">'+item[0]+'</td>'+
                                        '<td>'+item[1]+'</td>'+
                                        '<td>'+item[2]+'</td>'+
                                        '<td>'+item[3]+'</td>'+
                                        '<td>'+item[4]+'</td>'+
                                        '<td>'+item[5]+'</td>'+
                                        '<td>'+item[6]+'</td>'+
                                        '<td>'+
                                            '<button type="button" id="'+item[1]+'" class="btn-xs btn-info"><i class="glyphicon glyphicon-pencil"></i></button>&nbsp;'+
                                            '<button type="button" id="'+item[1]+'" data-info='+str_desc+' class="btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>'+
                                        '</td>'+
                                    '</tr>');

                        divinfo.append( '<h4>Nomor Pack QC</h4>'+
                                        '<p>'+item[7]+'</p><br>'+
                                        '<h4>Keterangan</h4>'+
                                        '<p>'+item[8]+'</p>');
                    });
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        function chkNotEmptyItm() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/chkNotEmptyItm' ?>",
                data: {
                    nbr: $('#txtbstnbr').val()
                },
                success: function(response) {
                    if (response.result === 'tafadhol') {
                        $('#btnDone').attr('disabled', false);
                    } else {
                        $('#btnDone').attr('disabled', true);
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        jQuery.validator.addMethod("notEqual0", function(value, element, param) {
            return this.optional(element) || value != param;
        }, "Qty tidak boleh 0.");

        $("#frmAddBst").validate({
            rules: {
                description: "required",
                txtqty: {
                    required: true,
                    notEqual0: "0",
                },
                txtspk: "required",
                txtwo: "required",
                txtpacknbr: "required"
            },
            messages: {
                description: "Item harus dipilih.",
                txtqty: {
                    required: "Qty harus diisi."
                },
                txtspk: "Nomor SPK harus diisi.",
                txtwo: "Nomor WO harus diisi.",
                txtpacknbr: "Nomor pack QC harus diisi."
            }
        });

        $("#frmUpdQty").validate({
            rules: {
                txtqty2: {
                    required: true,
                    notEqual0: "0",
                },
                txtspk2: "required",
                txtwo2: "required",
                txtpacknbr2: "required"
            },
            messages: {
                txtqty2: {
                    required: "Qty harus diisi."
                },
                txtspk2: "Nomor SPK harus diisi.",
                txtwo2: "Nomor WO harus diisi.",
                txtpacknbr2: "Nomor pack QC harus diisi."
            }
        });

        $('#btnTmpAdd').click(function() {
            if ($("#frmAddBst").valid()) {
                if (sel1itemYN == 'Y') {
                    alert('1 BST hanya boleh untuk 1 item !');
                } else {
                    chkIsItemExist($('#item_code').val());
                }
            }
        });

        function clearForm() {
            $('#item_code').val('');
            $('#description').val('');
            $('#uom').text('');
            $('#txtqty').val('1');
            $('#txtspk').val('');
            $('#txtwo').val('');
            $('#txtpacknbr').val('');
            $('#txtrmks').val('');
        }

        /* 1 BST hanya untuk 1 WO alias 1 BST hanya untuk 1 item */
        // function chkIsItemBSTExist(i) {
        //     $.ajax({
        //         dataType: "json",
        //         type: "POST",
        //         url: "// $base_url . 'index.php/addhandover/chkIsItemBSTExist'",
        //         data: {
        //             itm: i
        //         },
        //         success: function(response) {
        //             if (response.result === "avail") {
        //                 alert('1 BST hanya untuk 1 item !')
        //             } else {
        //             }
        //         },
        //         error: function() {
        //             alert("Error");
        //         }
        //     });
        // }

        function chkIsItemExist(i) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/chkIsItemExist' ?>",
                data: {
                    itm: i
                },
                success: function(response) {
                    if (response.result === "avail") {
                        alert('Kode item '+response.itemcode+' sudah ada di list, tidak boleh duplikat.');
                    } else {
                        addTmpItmBst( $('#txtbstnbr').val(), $('#item_code').val(), $('#description').val(), $('#uom').text(), $('#txtqty').val(),
                                      $('#txtspk').val(), $('#txtwo').val(), $('#txtpacknbr').val(), $('#txtrmks').val() );
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        function addTmpItmBst(n, i, d, u, q, s, w, p, r) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/addTmpItmBst' ?>",
                data: {
                    nbr: n,
                    itm: i,
                    desc: d,
                    uom: u,
                    qty: q,
                    spk: s,
                    wo: w,
                    pack: p,
                    rmk: r
                },
                success: function(response) {
                    if (response.result === "LIB_E001B") {
                        alert(response.errorMessage);
                    } else {
                        clearForm();

                        chkNotEmptyItm();
                        loadTmpBstItem();

                        sel1itemYN = 'Y';
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        $(document).on("click", ".btn-info", function() {
            beforeEdit(this.id);
        });

        $(document).on("click", ".btn-danger", function() {
            var str_desc = $(this).attr('data-info').replace(/_/g, ' ');
            if (confirm('Anda yakin akan menghapus item\n'+str_desc+' ?')) {
                deleteItemTmp($('#txtbstnbr').val(), this.id);
            }
        });

        $('#btnSubmitBst').click(function() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/submitBst' ?>",
                data: {
                    nbr: $('#txtbstnbr').val()
                },
                success: function(response) {
                    if (response.result === "LIB_E001B") {
                        alert(response.errorMessage);
                    } else {
                        delTmpBst(response.nomorbst);
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
        });

        function delTmpBst(n) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/delTmpBst' ?>",
                data: {
                    nbr: n
                },
                success: function(response) {
                    window.location.href = "<?= $base_url . 'index.php/handover' ?>";
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        function beforeEdit(itm) {
            $.ajax({
                url : "<?php echo site_url('addhandover/beforeEdit')?>" +'/'+$('#txtbstnbr').val()+'/'+itm,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#item_code2').val(data.tmp_item);
                    $('#description2').val(data.tmp_desc);
    				$('#txtqty2').val(data.tmp_qty);
                    $('#uom2').text(data.tmp_uom);
                    $('#txtspk2').val(data.tmp_spk);
                    $('#txtwo2').val(data.tmp_wo);
                    $('#txtpacknbr2').val(data.tmp_packnbr);
                    $('#txtrmks2').val(data.tmp_rmks);

                    $('#myModal').modal('show'); // show bootstrap modal when complete loaded
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        $('#btnUpdTmpItm').on('click', function() {
            if ($('#frmUpdQty').valid()) {
                updTmpItm( $('#txtbstnbr').val(), $('#item_code2').val(), $('#txtqty2').val(), $('#txtspk2').val(), $('#txtwo2').val(), $('#txtpacknbr2').val(), $('#txtrmks2').val() );
            }
        });

        function updTmpItm(n, i, q, s, w, p, r) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/updTmpItm' ?>",
                data: {
                    nbr: n,
                    itm: i,
                    qty: q,
                    spk: s,
                    wo: w,
                    pack: p,
                    rmk: r
                },
                success: function(response) {
                    if (response.result === "LIB_E001B") {
                        alert(response.errorMessage);
                    } else {
                        $('#myModal').modal('hide');

                        loadTmpBstItem();
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        function deleteItemTmp(n, i) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/addhandover/deleteItemTmp' ?>",
                data: {
                    nbr: n,
                    itm: i
                },
                success: function(response) {
                    chkNotEmptyItm();
                    loadTmpBstItem();

                    sel1itemYN = 'N';
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        $("#txtqty").keydown(function (e) {
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

        $("#txtqty2").keydown(function (e) {
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

	} );


</script>

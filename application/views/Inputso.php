
<!--
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
-->

<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/cdn_datatables_net/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>assets/css/editor.dataTables.min.css" rel="stylesheet" type="text/css" />
<!--<link href="<?php //echo base_url(); ?>assets/css/syntax/shCore.css" rel="stylesheet" type="text/css" />-->
<!--<link href="<?php //echo base_url(); ?>assets/css/demo.css" rel="stylesheet" type="text/css" />-->


<style rel="stylesheet" type="text/css">
	.numerik {
		text-align: right;
	}
	.tengah {
		text-align: center;
	}
</style>

<div align="center">
	<h3>Input Qty Stock Opname - [ <?php echo $stonbr; ?> ]</h3>
</div>

<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th></th>
			<th>Rack</th>
			<th>Bin</th>
			<th>Kd Item</th>
			<th>Deskripsi</th>
			<th>UoM</th>
			<th>Qty eStock</th>
			<th>Qty Fisik</th>
			<th>Qty NG</th>
			<th>Keterangan</th>
			<th>User</th>
			<th>Tgl Update</th>
		</tr>
	</thead>
</table>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/cdn_datatables_net/js/dataTables.select.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/dataTables.editor.min.js" type="text/javascript"></script>
<!-- <script src="<?php // echo base_url(); ?>assets/js/custom.js" type="text/javascript" ></script> -->
<script src="<?php echo base_url(); ?>assets/js/syntax/shCore.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/demo.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/editor-demo.js" type="text/javascript" ></script>

<script type="text/javascript" language="javascript">
	var editor; // use a global for the submit and return data rendering in the examples
	var stillopenYN = '<?php Print($stillopen); ?>';

	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajax": "Ajax/inputso",
			"table": "#example",
			fields: [ {
					label: "Rack:",
					name: "sto_rack",
					"type": "readonly"
				}, {
					label: "Bin:",
					name: "sto_bin",
					"type": "readonly"
				}, {
					label: "Item:",
					name: "sto_item",
					"type": "readonly"
				}, {
					label: "Deskripsi",
					name: "sto_desc",
					"type": "readonly"
				}, {
					label: "UoM:",
					name: "sto_uom",
					"type": "readonly"
				}, {
					label: "Qty:",
					name: "sto_qty",
					"type": "readonly"
				}, {
					label: "Qty Real:",
					name: "sto_qtyreal"
				}, {
					label: "Qty NG:",
					name: "sto_qtyng"
				}, {
					label: "Keterangan",
					name: "sto_rmks"
				}
			]
		} );
		
		// Activate an inline edit on click of a table cell
		// $('#example').on( 'click', 'tbody td:not(:first-child)', function (e) {
		if (stillopenYN == 'Y') {
			$('#example').on( 'click', 'tbody td:nth-child(8)', function (e) {
				editor.inline( this );
			} );
			
			$('#example').on( 'click', 'tbody td:nth-child(9)', function (e) {
				editor.inline( this );
			} );

			$('#example').on( 'click', 'tbody td:nth-child(10)', function (e) {
				editor.inline( this );
			} );
		}

		$('#example').DataTable( {
			dom: "Bfrtip",
			ajax: {
				url: "Ajax/inputso",
				type: "POST"
			},
			serverSide: true,
			"pageLength": 20,
			order: [[ 1, 'asc' ]],
			columns: [
				{
					data: null,
					defaultContent: '',
					className: 'select-checkbox',
					orderable: false,
					searchable: false
				},
				{ data: "sto_rack" },
				{ data: "sto_bin" },
				{ data: "sto_item" },
				{ data: "sto_desc" },
				{ data: "sto_uom", className: "tengah" },
				{ data: "sto_qty", className: "numerik" },
				{ data: "sto_qtyreal", className: "numerik" },
				{ data: "sto_qtyng", className: "numerik" },
				{ data: "sto_rmks" },
				{ data: "sto_updatedby" },
				{ data: "sto_updateddt" }
			],
			select: {
				style:    'os',
				selector: 'td:first-child'
			},
			order: [[2, "asc" ], [3, "asc"]],
			buttons: [
				{ extend: "edit",
				  text: 'Edit <u>(<i>shift</i> e)</u>',
				  editor: editor,
				  shiftKey: true,
                  key: 'e'
				}
			]
		} );
	} );
</script>







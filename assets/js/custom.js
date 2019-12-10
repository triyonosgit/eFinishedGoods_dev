var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
    editor = new $.fn.dataTable.Editor( {
        "ajax": "Ajax/Staff",
        "table": "#example",
        fields: [ {
				label: "Rack:",
				name: "sto_rack"
			}, {
				label: "Bin:",
				name: "sto_bin"
			}, {
				label: "Item:",
				name: "sto_item"
			}, {
				label: "Deskripsi",
				name: "sto_desc"
			}, {
				label: "Qty:",
				name: "sto_qty"
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
	$('#example').on( 'click', 'tbody td:nth-child(7)', function (e) {
		editor.inline( this );
	} );
	
	$('#example').on( 'click', 'tbody td:nth-child(8)', function (e) {
		editor.inline( this );
	} );

	$('#example').on( 'click', 'tbody td:nth-child(9)', function (e) {
		editor.inline( this );
	} );

    $('#example').DataTable( {
        dom: "Bfrtip",
        ajax: {
            url: "Ajax/Staff",
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
			{ data: "sto_qty", className: "numerik" },
			{ data: "sto_qtyreal", className: "numerik" },
			{ data: "sto_qtyng", className: "numerik" },
			{ data: "sto_rmks" }
		],
		select: {
			style:    'os',
			selector: 'td:first-child'
		},
		buttons: [
			{ extend: "edit",   editor: editor }
		]
    } );
} );
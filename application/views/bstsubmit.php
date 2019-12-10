<?php
$base_url = base_url();
?>

<link href="<?php echo base_url(); ?>assets/datatables/dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

<style>
    td.details-control {
        background: url('../img/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('../img/details_close.png') no-repeat center center;
    }

    .align-right {
        text-align: right;
    }

    .align-center {
        text-align: center;
    }
</style>

<div class="container">
    <h3>Submit BST</h3>
    <hr>
    <br>

    <div class="row">
        <div class="col-md-12">
            <table id="bsttable" class="table table-striped" width="100%">
                <thead>
                    <tr>
                        <th> </th>
                        <th>Id</th>
                        <th>Nomor</th>
                        <th>Tgl BST</th>
                        <th>User Produksi</th>
                        <th>Tgl Submit</th>
                        <th>User Submit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatables/datatables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatables/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var data = '<?php print($jsonbstdata); ?>';
        var bstnbr;

        // CARA LAIN LOAD DATA KE DATATABLES
        var table = $('#bsttable').DataTable({
            // Column definitions
            "processing": true,
            "select": true,
            "order": [],
            "columns": [{
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {
                    "data": 'hvr_id'
                },
                {
                    "data": 'hvr_nbr'
                },
                {
                    "data": 'hvr_adddt'
                },
                {
                    "data": 'hvr_useradd'
                },
                {
                    "data": 'hvr_aprvdt'
                },
                {
                    "data": 'hvr_useraprv'
                },
                {
                    "data": 'code_cmmt'
                },
                {
                    "className": 'sbmt',
                    "data": null,
                    "render": function(data, type, row) {
                        if (data.hvr_status == 'SENT') {
                            return '<button class="btn-warning btn-xs" title="revisi" id="rev_' + data.hvr_nbr + '"> <i class="glyphicon glyphicon-arrow-left"></i> </button>&nbsp;' +
                                '<button class="btn-primary btn-xs" title="submit" id="smt_' + data.hvr_nbr + '"> <i class="glyphicon glyphicon-ok"></i> </button>';

                        } else {
                            return '<button class="btn-inverse btn-xs disabled"> <i class="glyphicon glyphicon-arrow-left"></i> </button>&nbsp;' +
                                '<button class="btn-inverse btn-xs disabled"> <i class="glyphicon glyphicon-ok"></i> </button>';
                        }
                    },

                },
            ],
            "data": data,
            "columnDefs": [{
                    "className": "align-center",
                    "targets": [2, 3, 5]
                },
                {
                    "targets": [1],
                    "visible": false
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                // console.log(aData.hvr_status);
                if (aData.hvr_status == 'SUBMITED') {
                    $('td', nRow).css('background-color', '#a9a4a9');
                    $('td', nRow).css('color', 'white');
                }
            },

        });

        $('#bsttable tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            var d = table.row(this).data();

            bstnbr = d.hvr_nbr;

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                getBstDetail(bstnbr);

                row.child(
                    '<div class="col-md-12">' +
                    '<div class="well" style="padding-bottom: 1px;">' +
                    '<table class="table table-striped">' +
                    '<thead>' +
                    '<tr>' +
                    '<th align="center"> # </th>' +
                    '<th align="center"> Item </th>' +
                    '<th align="center"> Description </th>' +
                    '<th align="center"> UoM </th>' +
                    '<th align="center"> Qty </th>' +
                    '<th align="center"> SPK </th>' +
                    '<th align="center"> WO </th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody id="' + 'rowbst_' + bstnbr + '">' +
                    '</tbody>' +
                    '</table>' +
                    '<div class="alert alert-warning" id="' + 'info_' + bstnbr + '">' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                ).show();
                tr.addClass('shown');
            }
        });

        function getBstDetail(nbr) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/handover/getBstDetail' ?>",
                data: {
                    nbr: nbr
                },
                success: function(response) {
                    var tr = $("#rowbst_" + response.bstnumber);
                    var divinfo = $("#info_" + response.bstnumber);

                    tr.empty();
                    divinfo.empty();

                    $.each(response.data, function(index, item) {
                        tr.append('<tr>' +
                            '<td align="center">' + item[0] + '</td>' +
                            '<td>' + item[1] + '</td>' +
                            '<td>' + item[2] + '</td>' +
                            '<td align="center">' + item[3] + '</td>' +
                            '<td align="center">' + item[4] + '</td>' +
                            '<td>' + item[5] + '</td>' +
                            '<td>' + item[6] + '</td>' +
                            '</tr>');

                        divinfo.append('<h4>Nomor Pack QC</h4>' +
                            '<p>' + item[7] + '</p><br>' +
                            '<h4>Keterangan</h4>' +
                            '<p>' + item[8] + '</p>');
                    });
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        $(document).on("click", ".btn-primary", function() {
            bstnbr = this.id.substr(4, 8);

            window.location.href = "<?= $base_url . 'index.php/bstsubmit/prcsSubmitBst' ?>" + '/' + bstnbr;
        });

        $(document).on("click", ".btn-warning", function() {
            bstnbr = this.id.substr(4, 8);

            if (confirm('Lakukan revisi untuk nomor BST ' + bstnbr + ' ini?')) {
                returnBST(bstnbr);
            }
        });

        function returnBST(n) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "<?= $base_url . 'index.php/bstsubmit/returnBST' ?>",
                data: {
                    nbr: n
                },
                success: function(response) {
                    location.reload(true);
                },
                error: function() {
                    alert("Error");
                }
            });
        }




    });
</script>
function selectWarehouse() {

        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var w = 1000;
        var h = 500;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var params = 'width='+w+', height='+h+', scrollbars=yes';
        params += ', top='+top+', left='+left+'';
        var newWindow = window.open("../warehouse/select", '', params);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }

};

function getWarehouse(wh_code) {

        //alert(a);
        window.opener.document.getElementById('wh_code').value = wh_code;
        window.close();
};

function selectItem(sourceField) {

        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var w = 1000;
        var h = 500;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var params = 'width='+w+', height='+h+', scrollbars=yes';
        params += ', top='+top+', left='+left+'';
        var newWindow = window.open("../item_master/select", '', params);

        window.document.getElementById('sourceId').value = sourceField;

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }

};


function getItem(item_code, description, uom) {

        //alert(a);

        if (window.opener.document.getElementById('trans_type').value == 'R' ||
            window.opener.document.getElementById('trans_type').value == 'I' ||
            window.opener.document.getElementById('trans_type').value == 'T') {
            // Set the uom and description fields

            //window.opener.document.getElementById('item_code').value = item_code;
            var sourceField = window.opener.document.getElementById('sourceId').value;
            window.opener.document.getElementById(sourceField).value = item_code;
            window.opener.document.getElementById('uom').value = uom;
            window.opener.document.getElementById('description').value = description;
        }

        if (window.opener.document.getElementById('trans_type').value == 'A') {
            //Set the calling Field value
            //window.opener.document.getElementById('item_code').value = item_code;
            var sourceField = window.opener.document.getElementById('sourceId').value;
            window.opener.document.getElementById(sourceField).value = item_code;
            window.opener.document.getElementById('uom').value = uom;
            window.opener.document.getElementById('description').value = description;
        }

        if (window.opener.document.getElementById('trans_type').value == 'R' ||
            window.opener.document.getElementById('trans_type').value == 'I') {
            //reset bin_code and bin_qty
            window.opener.document.getElementById('bin_code').value = '';
            window.opener.document.getElementById('bin_qty').value = 0;
        } else if (window.opener.document.getElementById('trans_type').value == 'T') {
            //reset from_bin_code and bin_qty
            window.opener.document.getElementById('from_bin_code').value = '';
            window.opener.document.getElementById('bin_qty').value = 0;
        }


        //window.opener.document.getElementById('description').innerHTML = description;

        window.close();
};

/*
function getItem(item_code, description, uom) {

        //alert(a);
        window.opener.document.getElementById('item_code').value = item_code;
        window.opener.document.getElementById('uom').value = uom;
        window.opener.document.getElementById('description').value = description;

        if (window.opener.document.getElementById('trans_type').value == 'R' ||
            window.opener.document.getElementById('trans_type').value == 'I') {
            //reset bin_code and bin_qty
            window.opener.document.getElementById('bin_code').value = '';
            window.opener.document.getElementById('bin_qty').value = 0;
        } else if (window.opener.document.getElementById('trans_type').value == 'T') {
            //reset from_bin_code and bin_qty
            window.opener.document.getElementById('from_bin_code').value = '';
            window.opener.document.getElementById('bin_qty').value = 0;
        }


        //window.opener.document.getElementById('description').innerHTML = description;

        window.close();
};
*/


function selectTransferToBin() {

        if (window.document.getElementById('item_code').value == "") {
            //window.document.getElementById("item_code").innerHTML = "You must select Item Code first";
            alert("Item Code harus dipilih terlebih dahulu");
            return false;
        }

        if (window.document.getElementById('from_bin_code').value == "") {
            //window.document.getElementById("item_code").innerHTML = "You must select Item Code first";
            alert("From Bin Code harus dipilih terlebih dahulu");
            return false;
        }

        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var w = 1000;
        var h = 500;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var params = 'width='+w+', height='+h+', scrollbars=yes';
        params += ', top='+top+', left='+left+'';
        //var newWindow = window.open("../bin/select", '', params);
        var from_bin_code = window.document.getElementById('from_bin_code').value;
        var item_code = window.document.getElementById('item_code').value;
        var newWindow = window.open("../bin/selectTransferToBin/"+item_code+"/"+from_bin_code, '', params);
        //var newWindow = window.open("../bin/select/"+item_code, '', params);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
};

function selectBin() {

        if (window.document.getElementById('item_code').value == "") {
            //window.document.getElementById("item_code").innerHTML = "You must select Item Code first";
            alert("Item Code harus dipilih terlebih dahulu");
            return false;
        }

        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var w = 1000;
        var h = 500;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var params = 'width='+w+', height='+h+', scrollbars=yes';
        params += ', top='+top+', left='+left+'';
        //var newWindow = window.open("../bin/select", '', params);
        var trans_type = window.document.getElementById('trans_type').value;
        var item_code = window.document.getElementById('item_code').value;
        var newWindow = window.open("../bin/select/"+item_code+"/"+trans_type, '', params);
        //var newWindow = window.open("../bin/select/"+item_code, '', params);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
};

function getBin(bin_code, qty) {

        //alert(a);
        /*
        window.opener.document.getElementById('bin_code').value = bin_code;
        if (qty == null) {
            window.opener.document.getElementById('bin_qty').value = 0;
        } else {
            window.opener.document.getElementById('bin_qty').value = qty;
        }
        */

        if (window.opener.document.getElementById('trans_type').value == 'A' ||
            window.opener.document.getElementById('trans_type').value == 'R' ||
            window.opener.document.getElementById('trans_type').value == 'I') {
            window.opener.document.getElementById('bin_code').value = bin_code;
        } else if (window.opener.document.getElementById('trans_type').value == 'T') {
           window.opener.document.getElementById('from_bin_code').value = bin_code;
        }

        if (qty == null) {
            window.opener.document.getElementById('bin_qty').value = 0;
        } else {
            window.opener.document.getElementById('bin_qty').value = qty;
        }


        window.close();
};


function getToBin(bin_code) {

        //alert(a);
        /*
        window.opener.document.getElementById('bin_code').value = bin_code;
        if (qty == null) {
            window.opener.document.getElementById('bin_qty').value = 0;
        } else {
            window.opener.document.getElementById('bin_qty').value = qty;
        }
        */

        window.opener.document.getElementById('to_bin_code').value = bin_code;

        window.close();
};

function runningFormatter(value, row, index) {
    return index + 1;
}


/*
function getBin(bin_code, wh_code) {

        //alert(a);
        window.opener.document.getElementById('bin_code').value = bin_code;
        window.opener.document.getElementById('wh_code').value = wh_code;

        window.close();
};
*/


//Format Bin Code based on Block, Column, and Level
$("#block").on("focusout", function () {
    var block = $("#block").val().toUpperCase();
    var column = $("#column").val().toUpperCase();
    var level = $("#level").val().toUpperCase();

    //$("#bin_code").val(block + "-" + column + "-" + level);
    $("#bin_code").val(block + column + level);
    $("#block").val(block);
});

$("#column").on("focusout", function () {
    var block = $("#block").val().toUpperCase();
    var column = $("#column").val().toUpperCase();
    var level = $("#level").val().toUpperCase();

    //$("#bin_code").val(block + "-" + column + "-" + level);
    $("#bin_code").val(block + column + level);
    $("#column").val(column);
});

$("#level").on("focusout", function () {
    var block = $("#block").val().toUpperCase();
    var column = $("#column").val().toUpperCase();
    var level = $("#level").val().toUpperCase();

    //$("#bin_code").val(block + "-" + column + "-" + level);
    $("#bin_code").val(block + column + level);
    $("#level").val(level);
});


var $binSelectTable = $('#binSelectTable');
var $binTransferToTable = $('#binTransferToTable');
var $itemSelectTable = $('#itemSelectTable');
var $table;


$(function () {
    $itemSelectTable.on('click-row.bs.table', function (e, row, $element) {
        $('.clicked').removeClass('clicked');
        $($element).addClass('clicked');
        $table = $itemSelectTable;
        var item_code = getSelectedRow().item_code;
        var description = getSelectedRow().description;
        var uom = getSelectedRow().uom;
        getItem(item_code, description, uom);
        //alert(getSelectedRow().qty);
        //getBin(bin_code, qty);
    });

    $binSelectTable.on('click-row.bs.table', function (e, row, $element) {
        $('.clicked').removeClass('clicked');
        $($element).addClass('clicked');
        $table = $binSelectTable;
        var bin_code = getSelectedRow().bin_code;
        var qty = getSelectedRow().qty;
        getBin(bin_code, qty);
        //alert(getSelectedRow().qty);
        //getBin(bin_code, qty);
    });

    $binTransferToTable.on('click-row.bs.table', function (e, row, $element) {
        $('.clicked').removeClass('clicked');
        $($element).addClass('clicked');
        $table = $binTransferToTable;
        var bin_code = getSelectedRow().bin_code;
        getToBin(bin_code);
        //alert(getSelectedRow().qty);
        //getBin(bin_code, qty);
    });


});

 function getSelectedRow() {
    var index = $table.find('tr.clicked').data('index');
    return $table.bootstrapTable('getData')[index];
}

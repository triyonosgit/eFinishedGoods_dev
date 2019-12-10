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

function selectItm(sourceField) {
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
        var newWindow = window.open("../index.php/item_master/select", '', params);

        window.document.getElementById('sourceId').value = sourceField;

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
};

function selectItem2(itm) {

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
    var newWindow = window.open("item_master/select2", '', params);

    // window.document.getElementById('sourceId').value = sourceField;

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
};




function getItem(item_code, description, uom) {

        //alert(a);

        if (window.opener.document.getElementById('trans_type').value == 'J' ||
            window.opener.document.getElementById('trans_type').value == 'R' ||
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

        /* 20191007 3ono */
        if (window.opener.document.getElementById('trans_type').value == 'BST') {
            window.opener.document.getElementById('item_code').value = item_code;
            window.opener.document.getElementById('txtqty').value = 1;
            window.opener.document.getElementById('uom').innerText = uom;
            window.opener.document.getElementById('description').value = description;
        }


        //window.opener.document.getElementById('description').innerHTML = description;

        window.close();
};

function getItem2(item_code, description, uom) {
    window.opener.document.getElementById('item_code').value = item_code;
    window.opener.document.getElementById('description').value = description;
    window.opener.document.getElementById('uom').value = uom;

    window.opener.document.getElementById('hidItmCode').value = item_code;

    window.close();
}



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

function selectBin2() {

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

    var item_code = window.document.getElementById('item_code').value;
    var newWindow = window.open("bin/select2/"+item_code, '', params);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
};

/* 20191021 */
function selectBin4() {
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

    var item_code = window.document.getElementById('item_code').value;
    var newWindow = window.open("../../bin/select4/"+item_code, '', params);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
};


function selectRack($accessform) {
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

    if ($accessform == 'index') {
        var newWindow = window.open("bin/selectRack", '', params);


    } else {
        var newWindow = window.open("../bin/selectRack", '', params);
    }

    if (window.focus) {
        newWindow.focus();
    }
};

function selectRack2($accessform) {
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

    var fr_rack_code = window.document.getElementById('fr_rack_code').value;

    if ($accessform == 'index') {
        var newWindow = window.open("bin/selectRack2/"+fr_rack_code, '', params);

    } else {
        var newWindow = window.open("../bin/selectRack2/"+fr_rack_code, '', params);
    }

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

        if (window.opener.document.getElementById('trans_type').value == 'J' ||
            window.opener.document.getElementById('trans_type').value == 'A' ||
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

function getBin2(bin_code) {
    window.opener.document.getElementById('bin_code').value = bin_code;

    window.close();
};

function getBin4(bin_code, qty_oh) {
    window.opener.document.getElementById('bin_code').value = bin_code;
    window.opener.document.getElementById('qty_oh').value = qty_oh;

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

function getFrRack(rack_code) {
    window.opener.document.getElementById('fr_rack_code').value = rack_code;
    window.opener.document.getElementById('to_rack_code').value = rack_code;

    window.close();
};

function getToRack(rack_code) {
    window.opener.document.getElementById('to_rack_code').value = rack_code;

    window.close();
};

function runningFormatter(value, row, index) {
    return index + 1;
}

function runningFormatterServerSide(value, row, index) {
      var $table = $('#table');
      var tableOptions = $table.bootstrapTable('getOptions');
      if (tableOptions.pageSize == 'All') {
        return index + 1;
      } else {
        return ((tableOptions.pageNumber-1) * tableOptions.pageSize)+(1 + index);
      }

}

function runningFormatterItemSelectServerSide(value, row, index) {
      var $table = $('#itemSelectTable');
      var tableOptions = $table.bootstrapTable('getOptions');
      return ((tableOptions.pageNumber-1) * tableOptions.pageSize)+(1 + index);

}

function itemDetailLinkFormatter(value, row, index) {

      return "<a href='item_detail/"+row.item_code+"'><i class='glyphicon glyphicon-list-alt'></i></a>";

}

function numberFormatter(value, row, index) {

      return numeral(value).format('0,0.00');

}

function differenceFormatter(value, row, index) {

      var difference = row.qty_eStockCard - row.qty_external;
      return numeral(difference).format('0,0.00');

}

function itemCRUDLinkFormatter(value, row, index) {

      return "<a href='item/edit/"+row.id+"'><i class='glyphicon glyphicon-edit'></i></a>&nbsp;&nbsp"+
             "<a href='item/hapus/"+row.id+"'><i class='glyphicon glyphicon-trash'></i></a>";


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
var $binSelectTable2 = $('#binSelectTable2');
var $binSelectTable4 = $('#binSelectTable4');
var $binTransferToTable = $('#binTransferToTable');
var $itemSelectTable = $('#itemSelectTable');
var $itemSelectTable2 = $('#itemSelectTable2');
var $rackTransferToTable = $('#rackTransferToTable');
var $rackTransferToTable2 = $('#rackTransferToTable2');
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

    $itemSelectTable2.on('click-row.bs.table', function (e, row, $element) {
        $('.clicked').removeClass('clicked');
        $($element).addClass('clicked');
        $table = $itemSelectTable2;
        var item_code = getSelectedRow().item_code;
        var description = getSelectedRow().description;
        var uom = getSelectedRow().uom;
        getItem2(item_code, description, uom);
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

    $binSelectTable2.on('click-row.bs.table', function (e, row, $element) {
        $('.clicked').removeClass('clicked');
        $($element).addClass('clicked');
        $table = $binSelectTable2;
        var bin_code = getSelectedRow().bin_code;

        getBin2(bin_code);
    });

    $binSelectTable4.on('click-row.bs.table', function (e, row, $element) {
        $('.clicked').removeClass('clicked');
        $($element).addClass('clicked');
        $table = $binSelectTable4;
        var bin_code = getSelectedRow().bin_code;
        var qty_oh = getSelectedRow().qty_oh;

        getBin4(bin_code, qty_oh);
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

    $rackTransferToTable.on('click-row.bs.table', function (e, row, $element) {
        $('.clicked').removeClass('clicked');
        $($element).addClass('clicked');
        $table = $rackTransferToTable;
        var rack_code = getSelectedRow().rack_code;
        getFrRack(rack_code);
        //alert(getSelectedRow().qty);
        //getBin(bin_code, qty);
    });

    $rackTransferToTable2.on('click-row.bs.table', function (e, row, $element) {
        $('.clicked').removeClass('clicked');
        $($element).addClass('clicked');
        $table = $rackTransferToTable2;
        var rack_code = getSelectedRow().rack_code;
        getToRack(rack_code);
        //alert(getSelectedRow().qty);
        //getBin(bin_code, qty);
    });


});

 function getSelectedRow() {
    var index = $table.find('tr.clicked').data('index');
    return $table.bootstrapTable('getData')[index];
}

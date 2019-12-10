<div class="container">
    <h2>Item Detail List - Adjustment</h2>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

    <input type="text" name="sourceId" id="sourceId" >
    <input type="text" name="trans_type" id="trans_type" value="A" >
    
    <p><input type="button" value="Tambah" id="New" onclick="addNewRow()"></p>
    <div class="row">
        <div class="col-md-12">
            <table id="table1" class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Id</th>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Bin Code</th>
                    <th>UoM</th>
                    <th>Current Qty</th>
                    <th>Actual Qty</th>
                    <th>Action</th>
                </tr>
                </thead>
                

            </table>
            
        </div>
    </div>

    <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary')) ?>

    <?php echo form_close() ?>
</div>


<script type="text/javascript">
function addNewRow() {
    var tbl = document.getElementById("table1");

    

    var row = tbl.insertRow(tbl.rows.length);

    document.getElementById("sourceId").value = row.rowIndex;



    var tdNo = document.createElement("td");
    var tdId = document.createElement("td");
    var tdItemCode = document.createElement("td");
    var tdDescription = document.createElement("td");
    var tdBinCode = document.createElement("td");
    var tdUoM = document.createElement("td");
    var tdCurrentQty = document.createElement("td");
    var tdActualQty = document.createElement("td");
    var tdDeleteRow = document.createElement("td");

    tdNo.appendChild(generateIndex(row.rowIndex));
    tdId.appendChild(generateId(row.rowIndex));
    tdItemCode.appendChild(generateItemCode(row.rowIndex));
    //tdItemCode.appendChild(generateCariItemCode(row.rowIndex));
    tdDescription.appendChild(generateDescription(row.rowIndex));
    tdBinCode.appendChild(generateBinCode(row.rowIndex));
    tdUoM.appendChild(generateUoM(row.rowIndex));
    tdCurrentQty.appendChild(generateCurrentQty(row.rowIndex));
    tdActualQty.appendChild(generateActualQty(row.rowIndex));
    tdDeleteRow.appendChild(generateDeleteRow(row.rowIndex));

    row.appendChild(tdNo);
    row.appendChild(tdId);
    row.appendChild(tdItemCode);
    row.appendChild(tdDescription);
    row.appendChild(tdBinCode);
    row.appendChild(tdUoM);
    row.appendChild(tdCurrentQty);
    row.appendChild(tdActualQty);
    row.appendChild(tdDeleteRow);

    document.getElementById('ItemCode['+row.rowIndex+']').setAttribute('onclick', 'selectItem('+row.rowIndex+')');
    //document.getElementById('ItemCode['+row.rowIndex+']').setAttribute('onclick', 'selectItem(this.id)');
    document.getElementById('DeleteRow['+row.rowIndex+']').setAttribute('onclick', 'removeRow('+row.rowIndex+')');
    //document.getElementById('DeleteRow['+row.rowIndex+']').setAttribute('onclick', 'removeRow(this.id)');
} 

function generateIndex(index) {
    var idx = document.createElement("label");
    idx.name = "Index[]";
    idx.id = "Index["+index+"]";
    idx.innerHTML = index;
    idx.size = "5";
    return idx;
}

function generateId(index) {
    var idx = document.createElement("input");
    //idx.type = "hidden";
    idx.name = "Id[]";
    idx.id = "Id["+index+"]";
    idx.size = "1";
    return idx;
}

function generateItemCode(index) {
    var idx = document.createElement("input");
    idx.type = "text";
    idx.name = "ItemCode[]";
    idx.id = "ItemCode["+index+"]";
    idx.readOnly = "readonly";
    idx.value = "click here..."
    idx.size = "10";
    <?php echo form_error('item_code');?>
    return idx;

}

/*
function generateCariItemCode(index) {
    var idx = document.createElement("button");
    //idx.type = "button";
    idx.name = "CariItemCode[]";
    idx.value = "..."
    idx.id = "CariItemCode["+index+"]";
    return idx;
}
*/

function generateDescription(index) {
    var idx = document.createElement("input");
    idx.type = "text";
    idx.name = "Description[]";
    idx.id = "Description["+index+"]";
    idx.readOnly = "readonly";
    return idx;
}

function generateBinCode(index) {
    var idx = document.createElement("input");
    idx.type = "text";
    idx.name = "BinCode[]";
    idx.id = "BinCode["+index+"]";
    idx.readOnly = "readonly";
    return idx;
}

function generateUoM(index) {
    var idx = document.createElement("input");
    idx.type = "text";
    idx.name = "UoM[]";
    idx.id = "UoM["+index+"]";
    idx.readOnly = "readonly";
    return idx;
}

function generateCurrentQty(index) {
    var idx = document.createElement("input");
    idx.type = "text";
    idx.name = "CurrentQty[]";
    idx.id = "CurrentQty["+index+"]";
    idx.readOnly = "readonly";
    return idx;
}

function generateActualQty(index) {
    var idx = document.createElement("input");
    idx.type = "text";
    idx.name = "ActualQty[]";
    idx.id = "ActualQty["+index+"]";
    //idx.readOnly = "readonly";
    return idx;
}

function generateDeleteRow(index) {
    var idx = document.createElement("button");
    //idx.type = "text";
    idx.name = "DeleteRow[]";
    idx.id = "DeleteRow["+index+"]";
    var icon = document.createElement("span");
    icon.className = "glyphicon glyphicon-trash";
    idx.appendChild(icon);
    return idx;
}


function removeRow(index) {
    document.getElementById('sourceId').value = index;
    var tbl = document.getElementById("table1");

    //Reindex Table   
    //var nextRowPos = index + 1;   //nextRow is the next index of the deleted row -- Start indexing from here
    //var originalTotalRowNum = tbl.rows.length;
    //var deletedRowPos = index;     // index is the position being deleted
    
    tbl.deleteRow(index);

    //if (index < originalTotalRowNum) {
    //for (i = nextRowPos; i <= originalTotalRowNum; i++) {
        //var currentIndex = i - 1;
        /*
        document.getElementById("Index['+nextRowPos+']").id = "Index["+currentIndex+"]";
        document.getElementById("Id['+nextRowPos+']").id = "Id["+currentIndex+"]";
        document.getElementById("ItemCode['+nextRowPos+']").id = "ItemCode["+currentIndex+"]";
        document.getElementById("Description['+nextRowPos+']").id = "Description["+currentIndex+"]";
        document.getElementById("BinCode['+nextRowPos+']").id = "BinCode["+currentIndex+"]";
        document.getElementById("UoM['+nextRowPos+']").id = "UoM["+currentIndex+"]";
        document.getElementById("CurrentQty['+nextRowPos+']").id = "CurrentQty["+currentIndex+"]";
        document.getElementById("ActualQty['+nextRowPos+']").id = "ActualQty["+currentIndex+"]";
        document.getElementById("DeleteRow['+nextRowPos+']").id = "DeleteRow["+currentIndex+"]";
        */
        //document.getElementById("Index['+nextRowPos+']").id = "Index['+currentIndex+']";

        /*
        document.getElementById("Index['+nextRowPos+']").innerHTML = currentIndex;
        document.getElementById("Id['+nextRowPos+']").id = "Id['+currentIndex+']";
        document.getElementById("ItemCode['+nextRowPos+']").setAttribute("onclick", "selectItem('+currentIndex+')");
        document.getElementById("ItemCode['+nextRowPos+']").id = "ItemCode['+currentIndex+']";
        document.getElementById("Description['+nextRowPos+']").id = "Description['+currentIndex+']";
        document.getElementById("BinCode['+nextRowPos+']").id = "BinCode['+currentIndex+']";
        document.getElementById("UoM['+nextRowPos+']").id = "UoM['+currentIndex+']";
        document.getElementById("CurrentQty['+nextRowPos+']").id = "CurrentQty['+currentIndex+]";
        document.getElementById("ActualQty['+nextRowPos+']").id = "ActualQty['+currentIndex+]";
        document.getElementById("DeleteRow['+nextRowPos+']").setAttribute("onclick", "removeRow('+currentIndex+')");
        document.getElementById("DeleteRow['+nextRowPos+']").id = "DeleteRow['+currentIndex+]";
        */

        //changeId(Index['+nextRowPos+'], Index['+currentIndex+']);
        //document.getElementById("Index['+nextRowPos+']").innerHTML = currentIndex;
        //document.getElementById("Index['+nextRowPos+']").innerHTML = elementId;

        //document.getElementById('ItemCode['+row.rowIndex+']').setAttribute('onclick', 'selectItem(this.id)');
        
    //}
    }

function changeId(targetElement, newId) {
    var element = document.getElementById(targetElement);
    element.id = newId;
}




</script>
                
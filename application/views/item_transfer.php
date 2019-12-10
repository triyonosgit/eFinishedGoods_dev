
<div class="container">
    <h2>Item Transfer</h2>
    <hr>

    <input type="text" name="sourceId" id="sourceId" hidden="true">

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <!-- Item Code -->
        <div class="form-group has-feedback <?php set_validation_style('item_code')?>">
            <?php echo form_label('Item Code', 'item_code', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('item_code', $values->item_code, 'id="item_code" class="form-control" placeholder="Item Code" maxlength="20" readonly="true"'); ?>
                <?php $data = array(
                                'type'      => 'button',
                                'id'        => 'item_code',
                                'name'      => 'item_code',
                                'content'   => '<span class="glyphicon glyphicon-search"></span>',
                                'onclick'   => "selectItm(this.id)"
                            )
                ?>
                <?php echo form_button($data) ?>
                <?php set_validation_icon('item_code') ?>
                <?php echo form_error('item_code', '<span class="help-block">', '</span>');?>
            </div>
        </div>

        <div class="form-group has-feedback">
            <?php echo form_label('Item Description', 'description', array('class' => 'control-label')) ?>
            <?php echo form_input('description', $values->description, 'id="description" class="form-control" placeholder="Item Description" readonly="true"'); ?>
        </div>

        <!-- Trans Type -->
        <div class="form-group has-feedback">
            <?php echo form_label('Transaction Type', 'trans_type', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('trans_type', $values->trans_type, 'id="trans_type" class="form-control" placeholder="Transaction Type" maxlength="1" readonly="true"') ?>
            </div>
        </div>

        <!-- Referensi Transfer Bin -->
        <div class="form-group has-feedback <?php set_validation_style('reference')?>">
            <?php echo form_label('Reference', 'reference', array('class' => 'control-label')) ?>
            <?php echo form_input('reference', $values->reference, 'id="reference" class="form-control" placeholder="Reference" maxlength="60"') ?>
            <?php set_validation_icon('reference') ?>
            <?php echo form_error('reference', '<span class="help-block">', '</span>');?>
        </div>

        <!-- UoM -->
        <div class="form-group has-feedback">
            <?php echo form_label('UoM', 'uom', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('uom', $values->uom, 'id="uom" class="form-control" placeholder="UoM" maxlength="3" readonly="true" ') ?>
            </div>
        </div>


        <!-- From Bin Code-->
        <div class="form-group has-feedback <?php set_validation_style('bin_code')?>">
            <?php echo form_label('From Bin', 'from_bin_code', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('from_bin_code', $values->from_bin_code, 'id="from_bin_code" class="form-control" placeholder="From Bin" maxlength="6" readonly="true"') ?>
                <?php $data = array(
                                'type'      => 'button',
                                'id'        => 'from_bin_code',
                                'name'      => 'from_bin_code',
                                'content'   => '<span class="glyphicon glyphicon-search"></span>',
                                'onclick'   => "selectBin()"
                            )
                ?>
                <?php echo form_button($data) ?>
                <?php set_validation_icon('from_bin_code') ?>
                <?php echo form_error('from_bin_code', '<span class="help-block">', '</span>');?>
            </div>
        </div>

        <!-- To Bin Code-->
        <div class="form-group has-feedback <?php set_validation_style('to_bin_code')?>">
            <?php echo form_label('To Bin', 'to_bin_code', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('to_bin_code', $values->to_bin_code, 'id="to_bin_code" class="form-control" placeholder="To Bin" maxlength="6" readonly="true"') ?>
                <?php $data = array(
                                'type'      => 'button',
                                'id'        => 'to_bin_code',
                                'name'      => 'to_bin_code',
                                'content'   => '<span class="glyphicon glyphicon-search"></span>',
                                'onclick'   => "selectTransferToBin()"
                            )
                ?>
                <?php echo form_button($data) ?>
                <?php set_validation_icon('to_bin_code') ?>
                <?php echo form_error('to_bin_code', '<span class="help-block">', '</span>');?>
            </div>
        </div>

        <!-- From Bin Qty -->
        <div class="form-group has-feedback">
            <?php echo form_label('From Bin Available Qty', 'bin_qty', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('bin_qty', $values->bin_qty, 'id="bin_qty" class="form-control" placeholder="Bin Qty" readonly="true"'); ?>
            </div>
        </div>

        <!-- To Bin Qty -->
        <div class="form-group has-feedback <?php set_validation_style('qty')?>">
            <?php echo form_label('Qty', 'qty', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('qty', $values->qty, 'id="qty" class="form-control" placeholder="Qty" maxlength="10"') ?>
            </div>
            <?php set_validation_icon('qty') ?>
            <?php echo form_error('qty', '<span class="help-block">', '</span>');?>
        </div>

        <br>
        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan menyimpan data ini?')) ?>

        <!--<?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary')) ?>-->

    <?php echo form_close() ?>
</div>

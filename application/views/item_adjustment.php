
<div class="container">
    <h2>Item Adjustment</h2>
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
                                'content'   => '<span class="glyphicon glyphicon-search" id="item_code_error"></span>',
                                'onclick'   => "selectItem(this.id)"
                            )
                ?>
                <?php echo form_button($data) ?>
                <?php set_validation_icon('item_code') ?>
                <?php echo form_error('item_code', '<span class="help-block">', '</span>');?>
            </div>

            <!--
            <div class="form-inline">
                <label id="description"><?php echo $values->description ?></label>
            </div>
            -->
        </div>


        <div class="form-group has-feedback">
            <?php echo form_label('Item Description', 'description', array('class' => 'control-label')) ?>
            <?php echo form_input('description', $values->description, 'id="description" class="form-control" placeholder="Item Description" readonly="true"'); ?>
        </div>

        <!-- Bin -->
        <div class="form-group has-feedback <?php set_validation_style('bin_code')?>">
            <?php echo form_label('Bin', 'bin_code', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('bin_code', $values->bin_code, 'id="bin_code" class="form-control" placeholder="Bin" maxlength="6" readonly="true"') ?>
                <?php $data = array(
                                'type'      => 'button',
                                'id'        => 'bin_code',
                                'name'      => 'bin_code',
                                'content'   => '<span class="glyphicon glyphicon-search"></span>',
                                'onclick'   => "selectBin()"
                            )
                ?>
                <?php echo form_button($data) ?>
                <?php set_validation_icon('bin_code') ?>
                <?php echo form_error('bin_code', '<span class="help-block">', '</span>');?>
            </div>
        </div>

        <div class="form-group has-feedback">
            <?php echo form_label('Bin Qty', 'bin_qty', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('bin_qty', $values->bin_qty, 'id="bin_qty" class="form-control" placeholder="Bin Qty" readonly="true"'); ?>
            </div>
        </div>

         <!-- Trans Type -->
        <div class="form-group has-feedback">
            <?php echo form_label('Transaction Type', 'trans_type', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('trans_type', $values->trans_type, 'id="trans_type" class="form-control" placeholder="Transaction Type" maxlength="1" readonly="true"') ?>
            </div>
        </div>

        <!-- Referensi -->
        <div class="form-group has-feedback <?php set_validation_style('reference')?>">
            <?php echo form_label('Referensi', 'reference', array('class' => 'control-label')) ?>
            <?php echo form_input('reference', $values->reference, 'id="reference" class="form-control" placeholder="Referensi" maxlength="60"') ?>
            <?php set_validation_icon('reference') ?>
            <?php echo form_error('reference', '<span class="help-block">', '</span>');?>
        </div>

        <!--
        <div class="form-group has-feedback <?php set_validation_style('vendor')?>">
            <?php echo form_label('Vendor', 'vendor', array('class' => 'control-label')) ?>
            <?php echo form_input('vendor', $values->vendor, 'id="vendor" class="form-control" placeholder="Vendor" maxlength="90"') ?>
            <?php set_validation_icon('vendor') ?>
            <?php echo form_error('vendor', '<span class="help-block">', '</span>');?>
        </div>
        -->

        <!-- UoM -->
        <div class="form-group has-feedback">
            <?php echo form_label('UoM', 'uom', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('uom', $values->uom, 'id="uom" class="form-control" placeholder="UoM" maxlength="3" readonly="true" ') ?>
            </div>
        </div>

        <!-- Final Qty -->
        <div class="form-group has-feedback <?php set_validation_style('qty')?>">
            <?php echo form_label('Final Qty', 'qty', array('class' => 'control-label')) ?>
            <div class="form-inline">
                <?php echo form_input('qty', $values->qty, 'id="qty" class="form-control" placeholder="Final Qty" maxlength="10"') ?>
            </div>
            <?php set_validation_icon('qty') ?>
            <?php echo form_error('qty', '<span class="help-block">', '</span>');?>
        </div>



        <br>
        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan menyimpan data ini?')) ?>

        <!--<?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary')) ?>-->

    <?php echo form_close() ?>
</div>

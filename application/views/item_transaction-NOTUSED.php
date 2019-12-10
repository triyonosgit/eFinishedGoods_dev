
<div class="container">
    <h2>Item Transaction</h2>
    <hr>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <!-- row -->
        <div class="form-group has-feedback <?php set_validation_style('row')?>">
            <?php echo form_label('Row', 'row', array('class' => 'control-label')) ?>
            <?php echo form_input('row', $values->row, 'id="row" class="form-control" placeholder="Row" maxlength="2"') ?>
            <?php set_validation_icon('row') ?>
            <?php echo form_error('row', '<span class="help-block">', '</span>');?>
        </div>

        <!-- stack -->
        <div class="form-group has-feedback <?php set_validation_style('stack')?>">
            <?php echo form_label('Stack', 'stack', array('class' => 'control-label')) ?>
            <?php echo form_input('stack', $values->stack, 'id="stack" class="form-control" placeholder="Stack" maxlength="2"') ?>
            <?php set_validation_icon('stack') ?>
            <?php echo form_error('stack', '<span class="help-block">', '</span>');?>
        </div>

        <!-- level -->
        <div class="form-group has-feedback <?php set_validation_style('level')?>">
            <?php echo form_label('Level', 'level', array('class' => 'control-label')) ?>
            <?php echo form_input('level', $values->level, 'id="level" class="form-control" placeholder="Level" maxlength="2"') ?>
            <?php set_validation_icon('level') ?>
            <?php echo form_error('level', '<span class="help-block">', '</span>');?>
        </div>

        <!-- bin code -->
        <div class="form-group has-feedback <?php set_validation_style('bin_code')?>">
            
            <?php echo form_label('Bin Code', 'bin_code', array('class' => 'control-label')) ?>
            <?php echo form_input('bin_code', $values->bin_code, 'id="bin_code" class="form-control" placeholder="Bin Code" maxlength="10" readonly="true" ') ?>
            <?php set_validation_icon('bin_code') ?>
            <?php echo form_error('bin_code', '<span class="help-block">', '</span>');?>
        </div>
    

        <!-- warehouse -->
        <div class="form-group has-feedback <?php set_validation_style('wh_code')?>">
            <?php echo form_label('Warehouse Code', 'wh_code', array('class' => 'control-label')) ?>
            <div class="form-inline">  
                <!--?php $link_hapus = anchor('bin/','<span class="glyphicon glyphicon-search"></span>', array('title' => 'Search', 'data-confirm' => 'Anda yakin akan menghapus data ini?')); ?>-->
                <?php echo form_input('wh_code', $values->wh_code, 'id="wh_code" class="form-control" placeholder="Warehouse Code" maxlength="10"'); ?>
                <?php $data = array(
                                'type'      => 'button',
                                'id'        => 'warehouse',
                                'name'      => 'warehouse',
                                //'content'   => '<i><span class="glyphicon glyphicon-search"></span></i>',
                                'content'   => '<span class="glyphicon glyphicon-search"></span>',
                                'onclick'   => "selectWarehouse()"
                            )
                ?>
                <!--?php $link_hapus = anchor('warehouse/','<span class="glyphicon glyphicon-search"></span>', $data); ?>-->
                <?php echo form_button($data) ?>               
                <!--?php echo $link_hapus ?>-->
                <?php set_validation_icon('wh_code') ?>
                <?php echo form_error('wh_code', '<span class="help-block">', '</span>');?>
            </div>    
        </div>


        <!-- Item -->
        <div class="form-group has-feedback <?php set_validation_style('item_code')?>">
            <?php echo form_label('Item Code', 'item_code', array('class' => 'control-label')) ?>
            <div class="form-inline">  
                <?php echo form_input('item_code', $values->item_code, 'id="item_code" class="form-control" placeholder="Item Code" maxlength="20" readonly="true"'); ?>
                <?php $data = array(
                                'type'      => 'button',
                                'id'        => 'item_code',
                                'name'      => 'item_code',
                                'content'   => '<span class="glyphicon glyphicon-search"></span>',
                                'onclick'   => "selectItem()"
                            )
                ?>
                <?php echo form_button($data) ?>               
                <?php set_validation_icon('item_code') ?>
                <?php echo form_error('item_code', '<span class="help-block">', '</span>');?>
            </div>    
        </div>

        <!-- Item Description -->
        <div class="form-group has-feedback <?php set_validation_style('item_description')?>">
            <?php echo form_label('Item Description', 'item_description', array('class' => 'control-label')) ?>
            <?php echo form_input('item_description', $values->item_description, 'id="item_description" class="form-control" placeholder="Item Description" maxlength="60" readonly="true"'); ?>          
            <?php set_validation_icon('item_description') ?>
            <?php echo form_error('item_description', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Warehouse Code -->
        <div class="form-group has-feedback <?php set_validation_style('wh_code')?>">
            <?php echo form_label('Warehouse Code', 'wh_code', array('class' => 'control-label')) ?>
            <div class="form-inline">  
                <?php echo form_input('wh_code', $values->wh_code, 'id="wh_code" class="form-control" placeholder="Warehouse Code" maxlength="10"'); ?>
                <?php $data = array(
                                'type'      => 'button',
                                'id'        => 'wh_code',
                                'name'      => 'wh_code',
                                'content'   => '<span class="glyphicon glyphicon-search"></span>',
                                'onclick'   => "selectWarehouse()"
                            )
                ?>
                <?php echo form_button($data) ?>               
                <?php set_validation_icon('wh_code') ?>
                <?php echo form_error('wh_code', '<span class="help-block">', '</span>');?>
            </div>    
        </div>
       
        <!-- Bin Code -->
        <div class="form-group has-feedback <?php set_validation_style('bin_code')?>">
            <?php echo form_label('Bin Code', 'bin_code', array('class' => 'control-label')) ?>
            <div class="form-inline">  
                <?php echo form_input('bin_code', $values->bin_code, 'id="bin_code" class="form-control" placeholder="Bin Code" maxlength="10"'); ?>
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

        <!-- Jenis Transaksi -->
        <div class="form-group form-group-sm has-feedback <?php set_validation_style('trans_type')?>">
            <?php echo form_label('Jenis Transaksi', 'trans_type', array('class' => 'control-label col-sm-3')) ?>
            <div class="col-sm-4">
                <label class="radio-inline" for="receive">
                    <?php echo form_radio('trans_type', 'Receive', (isset($values->trans_type) && $values->trans_type == 'receive') ? true : false, 'id="receive" readonly="true"')?> Receive
                </label>
                <label class="radio-inline" for="issue">
                    <?php echo form_radio('trans_type', 'Issue', (isset($values->trans_type) && $values->trans_type == 'issue') ? true : false, 'id="issue" readonly="true"')?> Issue
                </label>
            </div>
            <?php if (form_error('trans_type')) : ?>
                <div class="col-sm-9 col-sm-offset-3">
                    <?php echo form_error('trans_type', '<span class="help-block">', '</span>');?>
                </div>
            <?php endif ?>
        </div>

        <!-- Quantity -->
        <div class="form-group has-feedback <?php set_validation_style('qty')?>">
            <?php echo form_label('Quantity', 'qty', array('class' => 'control-label')) ?>
            <?php echo form_input('qty', $values->qty, 'id="qty" class="form-control" placeholder="Quantity" maxlength="20"') ?>
            <?php set_validation_icon('qty') ?>
            <?php echo form_error('qty', '<span class="help-block">', '</span>');?>
        </div>
        

        <br>
        <?php echo form_button(array('content'=>'Proses', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan proses transaksi ini?')) ?>

    <?php echo form_close() ?>
</div>





<div class="container">
    <h2>Warehouse</h2>
    <hr>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <!-- Warehouse Code -->
        <div class="form-group has-feedback <?php set_validation_style('wh_code')?>">
            <?php echo form_label('Warehouse Code', 'wh_code', array('class' => 'control-label')) ?>
            <?php echo form_input('wh_code', $values->wh_code, 'id="wh_code" class="form-control" placeholder="Warehouse Code" maxlength="4"') ?>
            <?php set_validation_icon('wh_code') ?>
            <?php echo form_error('wh_code', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Description -->
        <div class="form-group has-feedback <?php set_validation_style('description')?>">
            <?php echo form_label('Description', 'description', array('class' => 'control-label')) ?>
            <?php echo form_input('description', $values->description, 'id="description" class="form-control" placeholder="Description" maxlength="60"') ?>
            <?php set_validation_icon('description') ?>
            <?php echo form_error('description', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Location -->
        <div class="form-group has-feedback <?php set_validation_style('location')?>">
            <?php echo form_label('Location', 'location', array('class' => 'control-label')) ?>
            <?php echo form_input('location', $values->location, 'id="location" class="form-control" placeholder="Location" maxlength="30"') ?>
            <?php set_validation_icon('location') ?>
            <?php echo form_error('location', '<span class="help-block">', '</span>');?>
        </div>
    
        <br>
        <!--<?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan menyimpan data ini?')) ?>-->
        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary')) ?>
        
    <?php echo form_close() ?>
</div>


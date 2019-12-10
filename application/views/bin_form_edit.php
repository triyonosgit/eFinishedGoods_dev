
<div class="container">
    <h2>Bin</h2>
    <hr>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <!-- block -->
        <div class="form-group has-feedback <?php set_validation_style('block')?>">
            <?php echo form_label('Block', 'block', array('class' => 'control-label')) ?>
            <?php echo form_input('block', $values->block, 'id="block" class="form-control" placeholder="Block" maxlength="2" readonly="true"') ?>
            <?php set_validation_icon('block') ?>
            <?php echo form_error('block', '<span class="help-block">', '</span>');?>
        </div>

        <!-- column -->
        <div class="form-group has-feedback <?php set_validation_style('column')?>">
            <?php echo form_label('Column', 'column', array('class' => 'control-label')) ?>
            <?php echo form_input('column', $values->column, 'id="column" class="form-control" placeholder="Column" maxlength="3" readonly="true"') ?>
            <?php set_validation_icon('column') ?>
            <?php echo form_error('column', '<span class="help-block">', '</span>');?>
        </div>

        <!-- level -->
        <div class="form-group has-feedback <?php set_validation_style('level')?>">
            <?php echo form_label('Level', 'level', array('class' => 'control-label')) ?>
            <?php echo form_input('level', $values->level, 'id="level" class="form-control" placeholder="Level" maxlength="1" readonly="true"') ?>
            <?php set_validation_icon('level') ?>
            <?php echo form_error('level', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Description -->
        <div class="form-group has-feedback <?php set_validation_style('level')?>">
            <?php echo form_label('Description', 'description', array('class' => 'control-label')) ?>
            <?php echo form_input('description', $values->description, 'id="description" class="form-control" placeholder="Description" maxlength="100"') ?>
            <?php set_validation_icon('description') ?>
            <?php echo form_error('description', '<span class="help-block">', '</span>');?>
        </div>


        <!-- bin code -->
        <div class="form-group has-feedback <?php set_validation_style('bin_code')?>">

            <?php echo form_label('Bin Code', 'bin_code', array('class' => 'control-label')) ?>
            <?php echo form_input('bin_code', $values->bin_code, 'id="bin_code" class="form-control" placeholder="Bin Code" maxlength="8" readonly="true" ') ?>
            <?php set_validation_icon('bin_code') ?>
            <?php echo form_error('bin_code', '<span class="help-block">', '</span>');?>
        </div>

        <br>
        <!--<?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan menyimpan data ini?')) ?>-->

        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary')) ?>

    <?php echo form_close() ?>
</div>

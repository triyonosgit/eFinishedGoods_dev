
<div class="container">
    <h2>Unit of Measure</h2>
    <hr>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <!-- Unit of Measure -->
        <div class="form-group has-feedback <?php set_validation_style('uom')?>">
            <?php echo form_label('Unit of Measure', 'uom', array('class' => 'control-label')) ?>
            <?php echo form_input('uom', $values->uom, 'id="uom" class="form-control" placeholder="Unit of Measure" maxlength="3" autofocus="autofocus"') ?>
            <?php set_validation_icon('uom') ?>
            <?php echo form_error('uom', '<span class="help-block">', '</span>');?>
        </div>

        
       
        <br>
        <!--<?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan menyimpan data ini?')) ?>-->
        
        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary')) ?>

    <?php echo form_close() ?>
</div>





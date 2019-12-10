
<div class="container">
    <h2>Item Category</h2>
    <hr>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <!-- Unit of Measure -->
        <div class="form-group has-feedback <?php set_validation_style('category')?>">
            <?php echo form_label('Item Category', 'category', array('class' => 'control-label')) ?>
            <?php echo form_input('category', $values->category, 'id="category" class="form-control" placeholder="Item Category" maxlength="45" autofocus="autofocus"') ?>
            <?php set_validation_icon('category') ?>
            <?php echo form_error('category', '<span class="help-block">', '</span>');?>
        </div>

        
       
        <br>
        <!--<?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan menyimpan data ini?')) ?>-->
        
        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary')) ?>
        

    <?php echo form_close() ?>
</div>





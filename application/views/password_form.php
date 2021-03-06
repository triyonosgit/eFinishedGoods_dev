<div class="container">
    <h2>Ganti Password</h2>
    <hr>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <?php echo form_hidden('id', $values->id) ?>

        <!-- password -->
        <div class="form-group has-feedback <?php set_validation_style('password')?>">
            <?php echo form_label('password', 'password', array('class' => 'control-label')) ?>
            <?php echo form_password('password', $values->password, 'id="password" class="form-control" placeholder="Password" maxlength="45"') ?>
            <?php set_validation_icon('password') ?>
            <?php echo form_error('password', '<span class="help-block">', '</span>');?>
        </div>

        <!-- passconf -->
        <div class="form-group has-feedback <?php set_validation_style('passconf')?>">
            <?php echo form_label('passconf', 'passconf', array('class' => 'control-label')) ?>
            <?php echo form_password('passconf', $values->passconf, 'id="passconf" class="form-control" placeholder="Konfirmasi Passowrd" maxlength="45"') ?>
            <?php set_validation_icon('passconf') ?>
            <?php echo form_error('passconf', '<span class="help-block">', '</span>');?>
        </div>

        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan menyimpan data ini?')) ?>

    <?php echo form_close() ?>

</div>
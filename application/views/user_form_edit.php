<div class="container">
    <h2>User</h2>
    <hr>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <!-- nama -->
        <div class="form-group has-feedback <?php set_validation_style('nama')?>">
            <?php echo form_label('Nama', 'nama', array('class' => 'control-label')) ?>
            <?php echo form_input('nama', $values->nama, 'id="nama" class="form-control" placeholder="Nama" maxlength="60"') ?>
            <?php set_validation_icon('nama') ?>
            <?php echo form_error('nama', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Username -->
        <div class="form-group has-feedback <?php set_validation_style('username')?>">
            <?php echo form_label('Username', 'username', array('class' => 'control-label')) ?>
            <?php echo form_input('username', $values->username, 'id="username" class="form-control" placeholder="Username" maxlength="45" readonly="true"') ?>
            <?php set_validation_icon('username') ?>
            <?php echo form_error('username', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Password -->
        <div class="form-group has-feedback <?php set_validation_style('password')?>">
            <?php echo form_label('Password', 'password', array('class' => 'control-label')) ?>
            <?php echo form_password('password', $values->password, 'id="password" class="form-control" placeholder="Password" maxlength="45" readonly="true"') ?>
            <?php set_validation_icon('password') ?>
            <?php echo form_error('password', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Passconf -->
        <div class="form-group has-feedback <?php set_validation_style('passconf')?>">
            <?php echo form_label('Konfirmasi Password', 'passconf', array('class' => 'control-label')) ?>
            <?php echo form_password('passconf', $values->passconf, 'id="passconf" class="form-control" placeholder="Konfirmasi Password" maxlength="45" readonly="true"') ?>
            <?php set_validation_icon('passconf') ?>
            <?php echo form_error('passconf', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Level -->
        <div class="form-group has-feedback <?php set_validation_style('level')?>">
            <?php echo form_label('Level', 'level', array('class' => 'control-label')) ?>
            <div class="radio">
                <label for="operator">
                    <?php echo form_radio('level', 'viewer', (isset($values->level) && $values->level == 'viewer') ? true : false, 'id ="viewer" ')?> Viewer
                </label>
                &nbsp;&nbsp;&nbsp;
                <label for="operator">
                    <?php echo form_radio('level', 'operator', (isset($values->level) && $values->level == 'operator') ? true : false, 'id ="operator" ')?> Operator
                </label>
                &nbsp;&nbsp;&nbsp;
                <label for="supervisor">
                    <?php echo form_radio('level', 'supervisor', (isset($values->level) && $values->level == 'supervisor') ? true : false, 'id ="supervisor"')?> Supervisor
                </label>
                &nbsp;&nbsp;&nbsp;
                <label for="administrator">
                    <?php echo form_radio('level', 'administrator', (isset($values->level) && $values->level == 'administrator') ? true : false, 'id ="administrator"')?> Administrator
                </label>
            </div>
            <?php echo form_error('level', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Status -->
        <div class="form-group has-feedback <?php set_validation_style('enable')?>">
            <?php echo form_label('Status', 'enable', array('class' => 'control-label')) ?>
            <div class="radio">
                <label for="aktif">
                    <?php echo form_radio('enable', 1, (isset($values->enable) && $values->enable == '1') ? true : false, 'id ="aktif"')?> Aktif
                </label>
                &nbsp;&nbsp;&nbsp;
                <label for="tidak_aktif">
                    <?php echo form_radio('enable', 0, (isset($values->enable) && $values->enable == '0') ? true : false, 'id ="tidak_aktif"')?> Tidak Aktif
                </label>
                &nbsp;&nbsp;&nbsp;
            </div>
            <?php echo form_error('enable', '<span class="help-block">', '</span>');?>
        </div>


        <br>
        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan proses data ini?')) ?>

    <?php echo form_close() ?>
</div>
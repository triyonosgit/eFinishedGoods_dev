
<div class="container">
    <h2>Item</h2>
    <hr>

    <?php echo form_open($form_action, array('id'=>'myform', 'class'=>'myform', 'role'=>'form')) ?>

        <!-- Item Code -->
        <div class="form-group has-feedback <?php set_validation_style('item_code')?>">
            <?php echo form_label('Item Code', 'item_code', array('class' => 'control-label')) ?>
            <?php echo form_input('item_code', $values->item_code, 'id="item_code" class="form-control" placeholder="Item Code" maxlength="20"') ?>
            <?php set_validation_icon('item_code') ?>
            <?php echo form_error('item_code', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Description -->
        <div class="form-group has-feedback <?php set_validation_style('description')?>">
            <?php echo form_label('Description', 'description', array('class' => 'control-label')) ?>
            <?php echo form_input('description', $values->description, 'id="description" class="form-control" placeholder="Description" maxlength="60"') ?>
            <?php set_validation_icon('description') ?>
            <?php echo form_error('description', '<span class="help-block">', '</span>');?>
        </div>

        <!-- Item Type -->
        <div class="form-group has-feedback <?php set_validation_style('item_type')?>">
            <?php echo form_label('Item Type', 'item_type', array('class' => 'control-label')) ?>
            <div>
                <?php
                    $atribut_item_type = 'class="form-control"';
                    echo form_dropdown('item_type', $item_type, $values->item_type, $atribut_item_type);
                ?>
            </div>
            <?php if (form_error('item_type')) {
                    echo form_error('item_type', '<span class="help-block">', '</span>');
                }
            ?>
        </div>

        <!-- Category -->
        <div class="form-group has-feedback <?php set_validation_style('category')?>">
            <?php echo form_label('Category', 'category', array('class' => 'control-label')) ?>
            <div>
                <?php
                    $atribut_category = 'class="form-control"';
                    echo form_dropdown('category', $category, $values->category, $atribut_category);
                ?>
            </div>
            <?php if (form_error('category')) {
                    echo form_error('category', '<span class="help-block">', '</span>');
                }
            ?>
        </div>

        <!-- UoM -->
        <div class="form-group has-feedback <?php set_validation_style('uom')?>">
            <?php echo form_label('UoM', 'uom', array('class' => 'control-label')) ?>
            <div>
                <?php
                    $atribut_uom = 'class="form-control"';
                    echo form_dropdown('uom', $uom, $values->uom, $atribut_uom);
                ?>
            </div>
            <?php if (form_error('uom')) {
                    echo form_error('uom', '<span class="help-block">', '</span>');
                }
            ?>
        </div>

        <!-- Aktif -->
        <div class="form-group has-feedback <?php set_validation_style('enable')?>">
            <?php echo form_label('Status', 'enable', array('class' => 'control-label')) ?>
            <div class="radio">
                <label for="aktif">
                    <?php echo form_radio('enable', 'Y', (isset($values->enable) && $values->enable == 'Y') ? true : false, 'id ="aktif"')?> Aktif
                </label>
                &nbsp;&nbsp;&nbsp;
                <label for="tidak_aktif">
                    <?php echo form_radio('enable', 'N', (isset($values->enable) && $values->enable == 'N') ? true : false, 'id ="tidak_aktif"')?> Tidak Aktif
                </label>
                &nbsp;&nbsp;&nbsp;
            </div>
            <?php echo form_error('enable', '<span class="help-block">', '</span>');?>
        </div>







        <br>
        <!--<?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary', 'data-confirm'=>'Anda yakin akan menyimpan data ini?')) ?>-->

        <?php echo form_button(array('content'=>'Simpan', 'type'=>'submit', 'class'=>'btn btn-primary')) ?>

    <?php echo form_close() ?>
</div>

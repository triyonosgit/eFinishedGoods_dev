<?php $user_level = $this->session->userdata('user_level')?>

<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">

        <?php
        $user_level = $this->session->userdata('user_level');
        if ($user_level == 'administrator') {
        ?>
            <a class="navbar-brand">eFinishedGoods</a>

            <!-- Link -->
            <ul class="nav navbar-nav navbar-left">
                <?php echo (isset($halaman) && $halaman == 'home') ? '<li class="active">' : '<li>'; ?> <?php echo anchor(base_url(), '<span class="glyphicon glyphicon-home"></span> Home');?></li>

                <!-- Dropdown Transaction -->
                <?php echo (isset($halaman) && preg_match('#(item_receive|item_issue|item_transfer)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-list-alt"></span> Transaction<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'item_receive') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/receive', '<span class="glyphicon glyphicon-plus-sign"></span> Receive');?></li>
                    <?php echo (isset($halaman) && $halaman == 'item_issue') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/issue', '<span class="glyphicon glyphicon-minus-sign"></span> Issue');?></li>
                    <?php echo (isset($halaman) && $halaman == 'item_transfer') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/transfer', '<span class="glyphicon glyphicon-list-alt"></span> Transfer');?></li>

                    <?php echo (isset($halaman) && $halaman == 'handover') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('handover', '<span class="glyphicon glyphicon-retweet"></span> Pembuatan BST');?></li>
                    <?php echo (isset($halaman) && $halaman == 'bstsubmit') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('bstsubmit', '<span class="glyphicon glyphicon-retweet"></span> Proses BST');?></li>
                </ul>
                </li>

                <!-- Item -->
                <?php echo (isset($halaman) && ($halaman == 'item_master' || $halaman == 'item_detail')) ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_master', '<span class="glyphicon glyphicon-list-alt"></span> Item');?></li>


                <!-- Report -->
                <?php echo (isset($halaman) && $halaman == 'report') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('report', '<span class="glyphicon glyphicon-list-alt"></span> Report');?></li>

                <!-- Stock Opname -->
                <?php echo (isset($halaman) && preg_match('#(generateso|prnsoitem|inputso|monitorso|summaryso)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-check"></span> Stock Opname<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'generateso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('generateso', '<span class="glyphicon glyphicon-download-alt"></span> Generate Stock Opname Data');?></li>
                    <?php echo (isset($halaman) && $halaman == 'prnsoitem') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('prnsoitem', '<span class="glyphicon glyphicon-print"></span> Cetak Form Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'inputso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('inputso', '<span class="glyphicon glyphicon-edit"></span> Input Qty Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'monitorso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('monitorso', '<span class="glyphicon glyphicon-log-in"></span> Monitoring Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'summaryso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('summaryso', '<span class="glyphicon glyphicon-inbox"></span> Summary Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'adjqtyso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('adjqtyso', '<span class="glyphicon glyphicon-retweet"></span> Closing Stock Opname');?></li>
                </ul>
                </li>

                <!-- Dropdown Administration -->
                <!--?php echo (isset($halaman) && preg_match('#(bin|warehouse|adjustment|user)#', $halaman)) ? '<li class="active">' : '<li>'; ?>-->
                <?php echo (isset($halaman) && preg_match('#(uom|item_category|item_admin|bin|item_adjustment|user)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-list-alt"></span> Administrasi<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'uom') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('uom', '<span class="glyphicon glyphicon-list-alt"></span> UoM');?></li>
                    <?php echo (isset($halaman) && $halaman == 'item_category') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_category', '<span class="glyphicon glyphicon-list-alt"></span> Item Category');?></li>
                    <?php echo (isset($halaman) && $halaman == 'item_admin') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item', '<span class="glyphicon glyphicon-list-alt"></span> Item');?></li>
                    <?php echo (isset($halaman) && $halaman == 'bin') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('bin', '<span class="glyphicon glyphicon-list-alt"></span> Bin');?></li>
                    <!--<?php echo (isset($halaman) && $halaman == 'warehouse') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('warehouse', '<span class="glyphicon glyphicon-list-alt"></span> Warehouse');?></li>-->
                    <?php echo (isset($halaman) && $halaman == 'item_adjustment') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/adjustment', '<span class="glyphicon glyphicon-list-alt"></span> Stock Adjustment');?></li>
                    <?php echo (isset($halaman) && $halaman == 'user') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('user', '<span class="glyphicon glyphicon-user"></span> User');?></li>

                    <?php echo (isset($halaman) && $halaman == 'chgitmnbr') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('chgitmnbr', '<span class="glyphicon glyphicon-user"></span> Ganti Kode Item');?></li>
                </ul>
                </li>

            </ul>
            <!-- end Link -->

        <?php
        }
        ?>

         <?php
        if ($user_level == 'supervisor') {
        ?>
            <a class="navbar-brand">eFinishedGoods</a>

            <!-- Link -->
            <ul class="nav navbar-nav navbar-left">
                <?php echo (isset($halaman) && $halaman == 'home') ? '<li class="active">' : '<li>'; ?> <?php echo anchor(base_url(), '<span class="glyphicon glyphicon-home"></span> Home');?></li>

                <!-- Dropdown Transaction -->
                <?php echo (isset($halaman) && preg_match('#(item_receive|item_issue|item_transfer)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-list-alt"></span> Transaction<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'item_receive') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/receive', '<span class="glyphicon glyphicon-plus-sign"></span> Receive');?></li>
                    <?php echo (isset($halaman) && $halaman == 'item_issue') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/issue', '<span class="glyphicon glyphicon-minus-sign"></span> Issue');?></li>
                    <?php echo (isset($halaman) && $halaman == 'item_transfer') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/transfer', '<span class="glyphicon glyphicon-list-alt"></span> Transfer');?></li>
                    <?php echo (isset($halaman) && $halaman == 'bstsubmit') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('bstsubmit', '<span class="glyphicon glyphicon-retweet"></span> Proses BST');?></li>
                </ul>
                </li>

                <!-- Item -->
                <?php echo (isset($halaman) && ($halaman == 'item_master' || $halaman == 'item_detail')) ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_master', '<span class="glyphicon glyphicon-list-alt"></span> Item');?></li>


                <!-- Report -->
                <?php echo (isset($halaman) && $halaman == 'report') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('report', '<span class="glyphicon glyphicon-list-alt"></span> Report');?></li>

                <!-- Stock Opname -->
                <?php echo (isset($halaman) && preg_match('#(generateso|prnsoitem|inputso|monitorso|summaryso)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-check"></span> Stock Opname<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'generateso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('generateso', '<span class="glyphicon glyphicon-download-alt"></span> Generate Stock Opname Data');?></li>
                    <?php echo (isset($halaman) && $halaman == 'inputso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('inputso', '<span class="glyphicon glyphicon-edit"></span> Input Qty Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'monitorso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('monitorso', '<span class="glyphicon glyphicon-log-in"></span> Monitoring Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'summaryso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('summaryso', '<span class="glyphicon glyphicon-inbox"></span> Summary Stock Opname');?></li>
                </ul>
                </li>


            </ul>
            <!-- end Link -->

        <?php
        }
        ?>

        <?php
        if ($user_level == 'operator') {
        ?>
            <a class="navbar-brand">eFinishedGoods</a>

            <!-- Link -->
            <ul class="nav navbar-nav navbar-left">
                <?php echo (isset($halaman) && $halaman == 'home') ? '<li class="active">' : '<li>'; ?> <?php echo anchor(base_url(), '<span class="glyphicon glyphicon-home"></span> Home');?></li>

                <!-- Dropdown Transaction -->
                <?php echo (isset($halaman) && preg_match('#(item_receive|item_issue|item_transfer)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-list-alt"></span> Transaction<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'item_receive') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/receive', '<span class="glyphicon glyphicon-plus-sign"></span> Receive');?></li>
                    <?php echo (isset($halaman) && $halaman == 'item_issue') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/issue', '<span class="glyphicon glyphicon-minus-sign"></span> Issue');?></li>
                    <?php echo (isset($halaman) && $halaman == 'item_transfer') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_trans/transfer', '<span class="glyphicon glyphicon-list-alt"></span> Transfer');?></li>
                </ul>
                </li>

                <!-- Item -->
                <?php echo (isset($halaman) && ($halaman == 'item_master' || $halaman == 'item_detail')) ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_master', '<span class="glyphicon glyphicon-list-alt"></span> Item');?></li>

                <!-- Report -->
                <?php echo (isset($halaman) && $halaman == 'report') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('report', '<span class="glyphicon glyphicon-list-alt"></span> Report');?></li>

                <!-- Stock Opname -->
                <?php echo (isset($halaman) && preg_match('#(generateso|prnsoitem|inputso|monitorso|summaryso)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-check"></span> Stock Opname<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'inputso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('inputso', '<span class="glyphicon glyphicon-edit"></span> Input Qty Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'monitorso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('monitorso', '<span class="glyphicon glyphicon-log-in"></span> Monitoring Stock Opname');?></li>

                </ul>
                </li>
            </ul>
            <!-- end Link -->

        <?php
        }
        ?>

        <!-- production --------------------------------------------------------------------------------------------------->
        <?php
        if ($user_level == 'production') {
        ?>
            <a class="navbar-brand">eFinishedGoods</a>

            <!-- Link -->
            <ul class="nav navbar-nav navbar-left">
                <?php echo (isset($halaman) && $halaman == 'home') ? '<li class="active">' : '<li>'; ?> <?php echo anchor(base_url(), '<span class="glyphicon glyphicon-home"></span> Home');?></li>

                <!-- Dropdown Transaction -->
                <?php echo (isset($halaman) && preg_match('#(item_receive|item_issue|item_transfer)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-list-alt"></span> Transaction<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'handover') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('handover', '<span class="glyphicon glyphicon-retweet"></span> Pembuatan BST');?></li>
                </ul>
                </li>

                <!-- Item -->
                <?php echo (isset($halaman) && ($halaman == 'item_master' || $halaman == 'item_detail')) ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_master', '<span class="glyphicon glyphicon-list-alt"></span> Item');?></li>

                <!-- Report -->
                <?php echo (isset($halaman) && $halaman == 'report') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('report', '<span class="glyphicon glyphicon-list-alt"></span> Report');?></li>

                <!-- Stock Opname -->
                <?php echo (isset($halaman) && preg_match('#(generateso|prnsoitem|inputso|monitorso|summaryso)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-check"></span> Stock Opname<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'inputso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('inputso', '<span class="glyphicon glyphicon-edit"></span> Input Qty Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'monitorso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('monitorso', '<span class="glyphicon glyphicon-log-in"></span> Monitoring Stock Opname');?></li>

                </ul>
                </li>
            </ul>
            <!-- end Link -->

        <?php
        }
        ?>
        <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <?php
        if ($user_level == 'viewer') {
        ?>
            <a class="navbar-brand">eFinishedGoods</a>

            <!-- Link -->
            <ul class="nav navbar-nav navbar-left">
                <?php echo (isset($halaman) && $halaman == 'home') ? '<li class="active">' : '<li>'; ?> <?php echo anchor(base_url(), '<span class="glyphicon glyphicon-home"></span> Home');?></li>

                <!-- Item -->
                <?php echo (isset($halaman) && ($halaman == 'item_master' || $halaman == 'item_detail')) ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_master', '<span class="glyphicon glyphicon-list-alt"></span> Item');?></li>


                <!-- Report -->
                <?php echo (isset($halaman) && $halaman == 'report') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('report', '<span class="glyphicon glyphicon-list-alt"></span> Report');?></li>


            </ul>
            <!-- end Link -->

        <?php
        }
        ?>

        <?php
        if ($user_level == 'accounting') {
        ?>
            <a class="navbar-brand">eStockCard</a>

            <!-- Link -->
            <ul class="nav navbar-nav navbar-left">
                <?php echo (isset($halaman) && $halaman == 'home') ? '<li class="active">' : '<li>'; ?> <?php echo anchor(base_url(), '<span class="glyphicon glyphicon-home"></span> Home');?></li>

                <!-- Item -->
                <?php echo (isset($halaman) && ($halaman == 'item_master' || $halaman == 'item_detail')) ? '<li class="active">' : '<li>'; ?> <?php echo anchor('item_master', '<span class="glyphicon glyphicon-list-alt"></span> Item');?></li>


                <!-- Report -->
                <?php echo (isset($halaman) && $halaman == 'report') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('report', '<span class="glyphicon glyphicon-list-alt"></span> Report');?></li>

                <!-- Stock Opname -->
                <?php echo (isset($halaman) && preg_match('#(generateso|prnsoitem|inputso|monitorso|summaryso)#', $halaman)) ? '<li class="active">' : '<li>'; ?>
                <?php echo anchor('#', '<span class="glyphicon glyphicon-check"></span> Stock Opname<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
                <ul class="dropdown-menu" role="menu">
                    <?php echo (isset($halaman) && $halaman == 'prnsoitem') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('prnsoitem', '<span class="glyphicon glyphicon-print"></span> Cetak Form Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'inputso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('inputso', '<span class="glyphicon glyphicon-edit"></span> Input Qty Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'monitorso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('monitorso', '<span class="glyphicon glyphicon-log-in"></span> Monitoring Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'summaryso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('summaryso', '<span class="glyphicon glyphicon-inbox"></span> Summary Stock Opname');?></li>
                    <?php echo (isset($halaman) && $halaman == 'adjqtyso') ? '<li class="active">' : '<li>'; ?> <?php echo anchor('adjqtyso', '<span class="glyphicon glyphicon-retweet"></span> Closing Stock Opname');?></li>
                </ul>
                </li>
            </ul>
            <!-- end Link -->

        <?php
        }
        ?>


        <!-- Informasi login -->
        <ul class="nav navbar-nav navbar-right">
            <!-- Dropdown -->

            <li> <?php echo anchor('#', '<span class="glyphicon glyphicon-user"></span> '. $this->session->userdata('username') . '<span class="caret"></span>', 'class="dropdown-toggle" data-toggle="dropdown"');?>
            <ul class="dropdown-menu" role="menu">
                <li> <?php echo anchor('password', '<span class="glyphicon glyphicon-edit"></span> Change Password');?> </li>
                <li> <?php echo anchor('login/logout', '<span class="glyphicon glyphicon-log-out"></span> Logout', array('data-confirm' => 'Anda yakin akan logout?')); ?></li>
            </ul>
        </li>
        </ul>

    </div> <!-- container -->
</nav>

<div class="container">
    <!--
    <div class="list-group">
        <a href="http://localhost/reportico/run.php?project=eStockCard&project_password=&xmlin=itemhistory.xml&execute_mode=PREPARE" class="list-group-item">Item History</a>
        <a href="http://localhost/reportico/run.php?project=eStockCard&project_password=&xmlin=itemhistory.xml&execute_mode=PREPARE" class="list-group-item">Item Category</a>
    </div>
    -->


    <div class="list-group list-group-flush text-center col-md-4 col-md-offset-4">
        <?php echo anchor_popup('http://appserver.sinarsaktimetalindo.com/reportico/run.php?project=eFinishedGoods&project_password=&xmlin=itemhistory.xml&execute_mode=PREPARE', 'Item History', array('class'=>'list-group-item')) ?>
        <?php echo anchor_popup('http://appserver.sinarsaktimetalindo.com/reportico/run.php?project=eFinishedGoods&project_password=&xmlin=itemdetail.xml&execute_mode=PREPARE', 'Item Detail', array('class'=>'list-group-item')) ?>
        <?php echo anchor_popup('http://appserver.sinarsaktimetalindo.com/reportico/run.php?project=eFinishedGoods&project_password=&xmlin=bindetail.xml&execute_mode=PREPARE', 'Bin Detail', array('class'=>'list-group-item')) ?>
        <?php echo anchor_popup('http://appserver.sinarsaktimetalindo.com/reportico/run.php?project=eFinishedGoods&project_password=&xmlin=bininfo.xml&execute_mode=PREPARE', 'Bin Information', array('class'=>'list-group-item')) ?>
    </div>



    <?php
        //ob_start();

        /*
        set_include_path('C:\xampp\htdocs\reportico');
        require_once('reportico.php');
        $q = new reportico();                         // Create instance
                       // Allows access to single specified report


        $q->initial_project="eStockCard";            // Name of report project folder
        $q->initial_project_password="";
        $q->initial_report="itemhistory.xml";           // Name of report to run
        $q->initial_execute_mode="PREPARE";         // Starts user in report criteria selection mode
        $q->access_mode="ONEREPORT";
        $q->bootstrap_styles="3";                   // Set to "3" for bootstrap v3, "2" for V2 or false for no bootstrap
        //$q->force_reportico_mini_maintains=true;    // Often required
        $q->bootstrap_preloaded = true;               // true if you dont need Reportico to load its own bootstrap
        //$q->embedded_report=true;
        $q->clear_reportico_session=true;           // Normally required
        //$q->reportico_ajax_script_url = 'C:\xampp\htdocs\reportico\run.php';
        //$q->reportico_ajax_script_url = 'http://localhost/reportico/run.php';
        $q->execute();
        */

        //echo $hostname;
        //echo $database;
        //echo $username;
        //echo $password;
        //echo $dbdriver;


        //echo anchor_popup('http://localhost/reportico/run.php?project=eStockCard&project_password=&xmlin=itemhistory.xml&execute_mode=PREPARE', 'Item History');

        //ob_end_flush();


    ?>
</div>

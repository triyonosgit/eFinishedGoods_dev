<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditorLib {
    
    private $CI = null;
    
    function __construct()
    {
        $this->CI = &get_instance();
    }   

	public function process($post)
	{	
	    // DataTables PHP library
		// require dirname(__FILE__).'/Editor-PHP-1.5.4/php/DataTables.php';
		// require dirname(__FILE__).'/editor-php-1.8.1/php/DataTables.php';
		require dirname(__FILE__).'/editor-php-1.9/php/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('Inputso_model');
		
		$db->sql( 'set names utf8' ); /* 20182612, ini ditambahin supaya bisa baca utf8 di sto_hist */

		//Pass the database object to the model
		$this->CI->Inputso_model->init($db);
		
		//Let the model produce the data
		$this->CI->Inputso_model->getStoItem($post);
	}
}


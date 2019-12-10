<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chgitmnbr extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'chgitmnbr',
        'main_view' => 'chgitmnbr'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('chgitmnbr_model', 'chgitmnbr');
    }

	public function index()
	{	
        // $listitemchg = $this->chgitmnbr->getListItemChg();
        // $this->data['listitemchg'] = $listitemchg;
		
		// print_r($listitemchg); die();

		$this->load->view($this->layout, $this->data);
    }
	
	public function execChgItmNbr() {
        ini_set('max_execution_time', 500);
        
        $responce = new StdClass;

        //$tgl = $this->input->post('tgl');

        $result = $this->chgitmnbr->execChgItmNbr();

        if (!($result)) {
            $responce->result = "LIB_E001A";
            $responce->errorMessage = "Error download data !";
        } else {
            $responce->result = "";
            $responce->errorMessage = "";
            $responce->successMessage = "Success download data.";
         }

        echo json_encode($responce);
    }

    
    
}

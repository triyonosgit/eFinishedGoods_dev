<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generateso extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'generateso',
        'main_view' => 'generateso'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('generateso_model', 'generateso');
    }

	public function index()
	{	
        $stohisthdr = $this->generateso->getSOHistHdr();
        $this->data['tabelrecord'] = $stohisthdr;

		$this->load->view($this->layout, $this->data);
    }

    public function isAnyOpenSO() {
        $responce = new StdClass;

        $count = (int)$this->generateso->isAnyOpenSO();

        if( $count > 0 ) {
            $responce->result = "ada";
        } else {
            $responce->result = "na";
        }

        echo json_encode($responce);
    }

    public function dnldData() {
        ini_set('max_execution_time', 500);
        
        $responce = new StdClass;

        //$tgl = $this->input->post('tgl');

        $result = $this->generateso->downloadData();

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

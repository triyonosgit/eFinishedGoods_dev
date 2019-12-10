<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjqtyso extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'adjqtyso',
        'main_view' => 'adjqtyso'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('adjqtyso_model', 'adjqtyso');
        $this->load->model('prnsoitem_model', 'prnsoitem');
    }

	public function index()
	{	
        $stonbr = $this->prnsoitem->getMaxStoNbr();
        $diffItems = $this->adjqtyso->getDiffItems($stonbr);

        $this->data['stonbr'] = $stonbr;
		$this->data['diffrecord'] = $diffItems;

		$this->load->view($this->layout, $this->data);
    }

    public function adjStock() {
        ini_set('max_execution_time', 500);
        
        $responce = new StdClass;

        $stonbr = $this->prnsoitem->getMaxStoNbr();
        $result = $this->adjqtyso->adjStock($stonbr);

        if (!($result)) {
            $responce->result = "LIB_E001A";
            $responce->errorMessage = "Error adjustment data !";
        } else {
            $responce->result = "";
            $responce->errorMessage = "";
            $responce->successMessage = "Adjustment stock berhasil.";
         }

        echo json_encode($responce);
    }
    
}

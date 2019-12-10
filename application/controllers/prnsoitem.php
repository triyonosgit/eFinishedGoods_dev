<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prnsoitem extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'prnsoitem',
        'main_view' => 'prnsoitem'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_detail_model', 'item_detail');
        $this->load->model('prnsoitem_model', 'prnsoitem');
    }

	public function index($fr = '000000', $to = 'ZZZZZZ')
	{	
		$frrack = $this->input->post('fr_rack_code');
        $torack = $this->input->post('to_rack_code');

        if (!empty($frrack)) {
            $fr = $frrack;
        } 

        if (!empty($torack)) {
            $to = $torack;
        }

        $this->data['frrack'] = $fr;
        $this->data['torack'] = $to;
        
        $stonbr = $this->prnsoitem->getMaxStoNbr();
        
        $binItems = $this->prnsoitem->getBinItems($stonbr, $fr, $to);
        $this->data['stonbr'] = $stonbr;
        $this->data['tabelrecord'] = $binItems;

		$this->load->view($this->layout, $this->data);
    }
    
    public function paramPdf() {
        $responce = new StdClass;

        $stonbr = $this->input->post('stonbr');
        $frrack = $this->input->post('frrack');
		$torack = $this->input->post('torack');

        $responce->stonbr = $stonbr;
        $responce->frrack = $frrack;
        $responce->torack = $torack;

        echo json_encode($responce);
    }

    public function printPdfSOitem() {
        $nbr = $_GET['nbr'];
        $fr = $_GET['fr'];
        $to = $_GET['to'];
        
        $this->data['stonbr'] = $nbr;
        $this->data['frRack'] = $fr;
        $this->data['toRack'] = $to;
        $this->data['racklist'] = $this->prnsoitem->getRackList($nbr, $fr, $to);
        //print_r($this->data['racklist']); die();
		
		$this->load->view('pdfcreate', $this->data);
    }
}

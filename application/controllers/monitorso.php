<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitorso extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'monitorso',
        'main_view' => 'monitorso'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('monitorso_model', 'monitorso');
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
        
        $binItems = $this->monitorso->getSOItem($stonbr, $fr, $to);
        $this->data['stonbr'] = $stonbr;
        $this->data['tabelrecord'] = $binItems;

		$this->load->view($this->layout, $this->data);
    }
    
}

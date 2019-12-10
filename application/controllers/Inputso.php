<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inputso extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'inputso',
        'main_view' => 'Inputso'
    );

	public function index()
	{	
		$this->load->model('inputso_model');
		$this->load->model('prnsoitem_model');

		$stonbr = $this->prnsoitem_model->getMaxStoNbr();

		if ($this->inputso_model->isStillOpen($stonbr)) {
			$stillopen = 'Y';
		} else {
			$stillopen = 'N';
		}

		$this->data['stonbr'] = $stonbr;
		$this->data['stillopen'] = $stillopen;

		$this->load->view($this->layout, $this->data);
	}
}

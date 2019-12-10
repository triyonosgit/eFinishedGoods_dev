<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Efgmailer extends MY_Controller {

	public $layout = 'layout';


    public function __construct()
    {
        parent::__construct();
        $this->load->model('handover_model', 'handover');
		$this->load->model('bstsubmit_model', 'bstsubmit');
    }

	public function index()
	{
        $nbr = '19110208';

		$data['nbr'] = $nbr;

        $bsthdr = $this->handover->getBstHdrPdf($nbr);
		$itembst = $this->bstsubmit->getBstDetail2($nbr);

		// print_r($bsthdr); die();

        $data['tanggal'] = $bsthdr->tgl_input;
        $data['weekday'] = $bsthdr->weekday;
        $data['pemohon'] = $bsthdr->hvr_useradd;
		$data['parcode'] = $itembst->hod_item;
		$data['pardesc'] = $itembst->hod_desc;
		$data['spknbr'] = $itembst->hod_spk;
		$data['wonbr'] = $itembst->hod_wo;
		$data['packnbr'] = $itembst->hod_packnbr;
		$data['qty'] = $itembst->hod_qty;
		$data['uom'] = $itembst->hod_uom;
		$data['rmks'] = $itembst->hod_rmks;

        // print_r($data['tanggal']); die();

		$this->load->view('pdfbstfile', $data);
    }


	public function savePdf() {
		$nbr = '19110208';

		$data['nbr'] = $nbr;

        $bsthdr = $this->handover->getBstHdrPdf($nbr);
		$itembst = $this->bstsubmit->getBstDetail2($nbr);

		// print_r($bsthdr); die();

        $data['tanggal'] = $bsthdr->tgl_input;
        $data['weekday'] = $bsthdr->weekday;
        $data['pemohon'] = $bsthdr->hvr_useradd;
		$data['parcode'] = $itembst->hod_item;
		$data['pardesc'] = $itembst->hod_desc;
		$data['spknbr'] = $itembst->hod_spk;
		$data['wonbr'] = $itembst->hod_wo;
		$data['packnbr'] = $itembst->hod_packnbr;
		$data['qty'] = $itembst->hod_qty;
		$data['uom'] = $itembst->hod_uom;
		$data['rmks'] = $itembst->hod_rmks;

        // print_r($data['tanggal']); die();

		$this->load->view('pdfbstfile', $data);
        return true;
	}




}

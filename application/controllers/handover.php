<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handover extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'handover',
        'main_view' => 'handover'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('handover_model', 'handover');
		$this->load->model('bstsubmit_model', 'bstsubmit');
    }

	public function index()
	{
        $this->data['title'] = 'Serah terima';

        $bstdata = $this->handover->getBstHdr();

        $this->data['jsonbstdata'] = json_encode($bstdata);

        // print_r($this->data['jsonbstdata']); die();

		$this->load->view($this->layout, $this->data);
    }

    function getBstDetail() {
		$responce = new StdClass;

		$nbr = $this->input->post('nbr');
		$iritem = $this->handover->getBstDetail($nbr);

        $responce->bstnumber = $nbr;

		$w = 1;
		foreach ($iritem as $li) {
			$responce->data[$w] = array (
                $w,
				$li->hod_item,
				$li->hod_desc,
                $li->hod_uom,
                $li->hod_qty,
                $li->hod_spk,
                $li->hod_wo,
                $li->hod_packnbr,
				$li->hod_rmks
			);
			$w++;
		}

		echo json_encode($responce);
	}

	public function deleteBst() {
		$responce = new StdClass;

		$nbr = $this->input->post('nbr');

		$result = $this->handover->deleteBst($nbr);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error delete BST !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "BST berhasil didelete !";
		}

		echo json_encode($responce);
	}

	public function printPdf() {
		$nbr = $_GET['nbr'];

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

		$this->load->view('pdfbst', $data);
	}

	public function svPdf() {
		$data['tanggal'] = date('Y-m-d');

        $data['weekday'] = date('N', strtotime(date('Y-m-d')));
		$data['listbst'] = $this->handover->getTodayBst();
		$data['totamount'] = $this->handover->getTotAmount();


        // print_r($listbst); die();

		$this->load->view('pdfbstfile', $data);
	}



	public function sendBST() {
		$responce = new StdClass;

		$nbr = $this->input->post('nbr');

		$result = $this->handover->sendBST($nbr);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error kirim BST !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "BST berhasil dikirim !";
		}

		echo json_encode($responce);
	}


}

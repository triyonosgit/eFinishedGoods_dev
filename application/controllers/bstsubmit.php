<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bstsubmit extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'bstsubmit',
        'main_view' => 'bstsubmit'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('updhandover_model', 'updhandover');
        $this->load->model('bstsubmit_model', 'bstsubmit');
    }

	public function index()
	{
        $this->data['title'] = 'Submit BST';

        $bstdata = $this->bstsubmit->getBstHdr();

        $this->data['jsonbstdata'] = json_encode($bstdata);

        // print_r($this->data['jsonbstdata']); die();

		$this->load->view($this->layout, $this->data);
    }

	public function prcsSubmitBst($bst) {
		$this->data['halaman'] = 'handover';
        $this->data['main_view'] = 'prcssubmit';

		$this->data['nbr'] = $bst;
		// $this->data['listitem'] = $this->updhandover->loadBstDetail($bst);
		// $this->data['listbin'] = $this->bstsubmit->getListBin();

		$itembst = $this->bstsubmit->getBstDetail2($bst);
		$this->data['parcode'] = $itembst->hod_item;
		$this->data['pardesc'] = $itembst->hod_desc;
		$this->data['spknbr'] = $itembst->hod_spk;
		$this->data['wonbr'] = $itembst->hod_wo;
		$this->data['packnbr'] = $itembst->hod_packnbr;
		$this->data['rmks'] = $itembst->hod_rmks;
		$this->data['qty'] = $itembst->hod_qty;
		$this->data['uom'] = $itembst->hod_uom;


		$this->load->view($this->layout, $this->data);
	}

    function getBstDetail() {
		$responce = new StdClass;

		$nbr = $this->input->post('nbr');
		$iritem = $this->bstsubmit->getBstDetail($nbr);

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

	public function returnBST() {
		$responce = new StdClass;

		$nbr = $this->input->post('nbr');

		$result = $this->bstsubmit->returnBST($nbr);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error return BST !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "BST berhasil direturn !";
		}

		echo json_encode($responce);
	}

	public function submitBST() {
		$responce = new StdClass;

		$nbr = $this->input->post('nbr');
		$tableData = $this->input->post('pTableData');

		// Unescape the string values in the JSON array
		// $tableData = stripcslashes($_POST['pTableData']);

		// Decode the JSON array
		// $tableData = json_decode($tableData,TRUE);

		// print_r($tableData); die();

		$result = $this->bstsubmit->submitBST($nbr, $tableData);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error submit BST !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "BST berhasil disubmit !";
		}

		echo json_encode($responce);
	}

	public function getQtyOHItmBin() {
		$responce = new StdClass;

		$bin = $this->input->post('bin');
		$itm = $this->input->post('itm');

		$responce->itembin = str_replace('-', '_', $itm);
		$responce->binselected = $bin;
		$responce->qtyoh = $this->bstsubmit->getQtyOHItmBin($bin, $itm);

        echo json_encode($responce);
	}

}

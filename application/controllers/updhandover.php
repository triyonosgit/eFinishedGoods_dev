<?php
class Updhandover extends MY_Controller
{
	public $layout = 'layout';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('updhandover_model', 'updhandover');
    }

    public function index() {
        $nbr = $_GET['nbr'];
        $this->data['halaman'] = 'handover';
        $this->data['main_view'] = 'updhandover';

        $bsthdr = $this->updhandover->getBstHdr($nbr);
        // print_r($bsthdr); die();

        $this->data['nbr'] = $bsthdr->hvr_nbr;


        $this->load->view($this->layout, $this->data);
	}

    function loadBstDetail(){
		$bst = $this->input->post('bst');
		$responce = new StdClass;

		$listitem = $this->updhandover->loadBstDetail($bst);

		$w = 0;
		foreach ($listitem as $li) {
			$responce->data[$w] = array (
				$li->hod_nbr,
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

	public function chkIsItemExist() {
		$responce = new StdClass;

		$bst = $this->input->post('bst');
		$itm = $this->input->post('itm');

		if ($this->updhandover->chkIsItemExist($bst, $itm)) {
			$responce->result = "avail";
			$responce->itemcode = $itm;
		} else {
			$responce->result = "notavail";
		}

		echo json_encode($responce);
	}

	public function addBstItem() {
		$responce = new StdClass;

        $nbr = $this->input->post('nbr');
		$itm = $this->input->post('itm');
		$desc = $this->input->post('desc');
		$uom = $this->input->post('uom');
        $qty = $this->input->post('qty');
        $spk = $this->input->post('spk');
        $wo = $this->input->post('wo');
        $pack = $this->input->post('pack');
		$rmk = $this->input->post('rmk');

		$result = $this->updhandover->addBstItem($nbr, $itm, $desc, $uom, $qty, $spk, $wo, $pack, $rmk);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error insert item !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "Item berhasil ditambahkan !";
		}

		echo json_encode($responce);
	}

	public function beforeEdit($nbr, $itm) {
		$data = $this->updhandover->getBstItemDtl($nbr, $itm);

		// print_r(json_encode($data)); die();
		echo json_encode($data);
	}

	public function updBstDtl() {
		$responce = new StdClass;

        $nbr = $this->input->post('nbr');
		$itm = $this->input->post('itm');
        $qty = $this->input->post('qty');
        $spk = $this->input->post('spk');
        $wo = $this->input->post('wo');
        $pack = $this->input->post('pack');
		$rmk = $this->input->post('rmk');

		$result = $this->updhandover->updBstDtl($nbr, $itm, $qty, $spk, $wo, $pack, $rmk);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error update item BST !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "Item BST berhasil diupdate !";
		}

		echo json_encode($responce);
	}

	public function delBstItem() {
		$responce = new StdClass;

		$nbr = $this->input->post('nbr');
		$itm = $this->input->post('itm');

		$result = $this->updhandover->delBstItem($nbr, $itm);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error delete item !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "Item berhasil didelete !";
		}

		echo json_encode($responce);
	}




}

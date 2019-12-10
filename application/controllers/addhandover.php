<?php
class Addhandover extends MY_Controller
{
    public $layout = 'layout';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('addhandover_model', 'addhandover');
    }

    public function index() {
        $this->data['halaman'] = 'handover';
        $this->data['main_view'] = 'addhandover';

        $this->load->view($this->layout, $this->data);
    }

    public function chkIsItemExist() {
		$responce = new StdClass;

		$itm = $this->input->post('itm');

		if ($this->addhandover->chkIsItemExist($itm)) {
			$responce->result = "avail";
			$responce->itemcode = $itm;
		} else {
			$responce->result = "notavail";
		}

		echo json_encode($responce);
	}

    public function chkIsItemBSTExist() {
        $responce = new StdClass;

		// $itm = $this->input->post('itm');

		if ($this->addhandover->chkIsItemBSTExist()) {
			$responce->result = "avail";
			// $responce->itemcode = $itm;
		} else {
			$responce->result = "notavail";
		}

		echo json_encode($responce);
    }

    public function getNewBstNbr() {
        $responce = new StdClass;

        $responce->nomorbst = $this->addhandover->getNewBstNbr();

        echo json_encode($responce);
    }

    public function addTmpItmBst() {
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

		$result = $this->addhandover->addTmpItmBst($nbr, $itm, $desc, $uom, $qty, $spk, $wo, $pack, $rmk);

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

    public function delTmpBstItem() {
		$responce = new StdClass;

		$result = $this->addhandover->delTmpBstItem();

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error delete temporari item !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "Temporari item berhasil didelete !";
		}

		echo json_encode($responce);
	}

    public function loadTmpBstItem() {
		$responce = new StdClass;

		$listitem = $this->addhandover->loadTmpBstItem();

		$w = 0;
		foreach ($listitem as $li) {
			$responce->data[$w] = array (
				$li->tmp_nbr,
				$li->tmp_item,
				$li->tmp_desc,
				$li->tmp_uom,
				$li->tmp_qty,
				$li->tmp_spk,
				$li->tmp_wo,
                $li->tmp_packnbr,
                $li->tmp_rmks
			);
			$w++;
		}

		echo json_encode($responce);
	}

    public function submitBst() {
        $responce = new StdClass;

        $nbr = $this->input->post('nbr');

        $result = $this->addhandover->submitBst($nbr);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error submit BST !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "BST berhasil ditambahkan !";
            $responce->nomorbst = $nbr;
		}

		echo json_encode($responce);
    }

    public function delTmpBst() {
		$responce = new StdClass;

        $nbr = $this->input->post('nbr');

		$result = $this->addhandover->delTmpBst($nbr);

		if (!($result)) {
			$responce->result = "LIB_E001A";
			$responce->errorMessage = "Error delete temporary BST !";
		} else {
			$responce->result = "";
			$responce->errorMessage = "";
			$responce->successMessage = "Temporary BST berhasil didelete !";
		}

		echo json_encode($responce);
    }

    public function beforeEdit($nbr, $itm) {
		$data = $this->addhandover->getTmpItmDtl($nbr, $itm);

		// print_r(json_encode($data)); die();
		echo json_encode($data);
	}

    public function updTmpItm() {
		$responce = new StdClass;

        $nbr = $this->input->post('nbr');
		$itm = $this->input->post('itm');
        $qty = $this->input->post('qty');
        $spk = $this->input->post('spk');
        $wo = $this->input->post('wo');
        $pack = $this->input->post('pack');
        $rmk = $this->input->post('rmk');

		$result = $this->addhandover->updTmpItm($nbr, $itm, $qty, $spk, $wo, $pack, $rmk);

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

    public function chkNotEmptyItm() {
        $responce = new StdClass;

		$nbr = $this->input->post('nbr');

		if ($this->addhandover->chkNotEmptyItm($nbr)) {
			$responce->result = "tafadhol";
		} else {
			$responce->result = "la";
		}

		echo json_encode($responce);
    }

    public function deleteItemTmp() {
		$responce = new StdClass;

		$nbr = $this->input->post('nbr');
		$itm = $this->input->post('itm');

		$result = $this->addhandover->deleteItemTmp($nbr, $itm);

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

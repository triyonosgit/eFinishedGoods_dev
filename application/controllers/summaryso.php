<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summaryso extends MY_Controller {

	public $layout = 'layout';

    public $data = array(
        'halaman' => 'summaryso',
        'main_view' => 'summaryso'
    );

    public function __construct()
    {
        parent::__construct();
		$this->load->model('summaryso_model', 'summaryso');
		$this->load->model('prnsoitem_model', 'prnsoitem');
    }

	public function index($fr = '000000', $to = 'ZZZZZZ')
	{	
		$frrack = $this->input->post('fr_rack_code');
		$torack = $this->input->post('to_rack_code');
		
		$stonbr = $this->prnsoitem->getMaxStoNbr();

        if (!empty($frrack)) {
            $fr = $frrack;
        } 

        if (!empty($torack)) {
            $to = $torack;
        }

		$this->data['stonbr'] = $stonbr;
        $this->data['frrack'] = $fr;
        $this->data['torack'] = $to;
		
		
        $binItems = $this->summaryso->getSOItem($stonbr, $fr, $to);
		$this->data['tabelrecord'] = $binItems;
		
		$diffItems = $this->summaryso->getDiffItems($stonbr, $fr, $to);
		$this->data['diffrecord'] = $diffItems;
		
		$ngItems = $this->summaryso->getNGItems($stonbr, $fr, $to);
        $this->data['ngrecord'] = $ngItems;

		$this->load->view($this->layout, $this->data);
    }
    
    // function ajax_list(){
	// 	$list = $this->summaryso->get_datatables();
	// 	// print_r(json_encode($list)); die();
	// 	$data = array();
	// 	$no = $_POST['start'];
	// 	foreach ($list as $li) {
	// 		$no++;
	// 		$row = array();

	// 		$qtyGSS = $this->summaryso->getGssBinQty($li->sto_bin, $li->sto_item);
    //         //$row[] = $no;
    //         $row[] = $li->sto_rack;
	// 		$row[] = $li->sto_bin;
	// 		$row[] = $li->sto_item;
	// 		$row[] = $li->sto_desc;
	// 		$row[] = $li->sto_uom;
	// 		$row[] = $li->sto_qty;
	// 		$row[] = $li->sto_qtyreal;
	// 		$row[] = $qtyGSS;
			
	// 		$data[] = $row;
	// 	}
		
	// 	$output = array("draw" => $_POST['draw'],
	// 					"recordsTotal" => $this->summaryso->count_all(),
	// 					"recordsFiltered" => $this->summaryso->count_filtered(),
	// 					"data" => $data,
	// 			);
	// 	echo json_encode($output);
	// }
}
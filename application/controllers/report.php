<?php
class Report extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'report',
        'main_view' => 'report',
        'title' => 'Report'
    );

    public function __construct()
    {
        parent::__construct();

        $this->load->model('item_trans_model', 'item_trans');
        $this->load->model('handover_model', 'handover');
    }

    public function index()
    {
        $this->load->view($this->layout, $this->data);
    }

    public function getReceivedItems()
    {
        $frdate = $this->input->post('datepicker1');
        $todate = $this->input->post('datepicker2');

        if (!empty($frdate)) {
            $fr = $frdate;
            $dateFrSelect = 'Y';
        } else {
            $fr = date('Y-m-d');
            $dateFrSelect = 'N';
        }

        if (!empty($todate)) {
            $to = $todate;
            $dateToSelect = 'Y';
        } else {
            $to = date('Y-m-d');
            $dateToSelect = 'N';
        }

        $this->data['halaman'] = 'report';
        $this->data['main_view'] = 'rptrcvitem';
        $this->data['frdate'] = $fr;
        $this->data['todate'] = $to;
        $this->data['dtfrselectedYN'] = $dateFrSelect;
        $this->data['dttoselectedYN'] = $dateToSelect;

        $dtlRcvItems = $this->item_trans->getDtlRcvItems($fr, $to);
        $this->data['dtlrecord'] = $dtlRcvItems;

        $smryRcvItems = $this->item_trans->getSmryRcvItems($fr, $to);
        $this->data['smryrecord'] = $smryRcvItems;

        //print_r($smryRcvItems); die();

        $this->load->view($this->layout, $this->data);
    }

    public function getIssuedItems()
    {
        $frdate = $this->input->post('datepicker1');
        $todate = $this->input->post('datepicker2');

        if (!empty($frdate)) {
            $fr = $frdate;
            $dateFrSelect = 'Y';
        } else {
            $fr = date('Y-m-d');
            $dateFrSelect = 'N';
        }

        if (!empty($todate)) {
            $to = $todate;
            $dateToSelect = 'Y';
        } else {
            $to = date('Y-m-d');
            $dateToSelect = 'N';
        }

        $this->data['halaman'] = 'report';
        $this->data['main_view'] = 'rptissitem';
        $this->data['frdate'] = $fr;
        $this->data['todate'] = $to;
        $this->data['dtfrselectedYN'] = $dateFrSelect;
        $this->data['dttoselectedYN'] = $dateToSelect;

        $dtlIssItems = $this->item_trans->getDtlIssItems($fr, $to);
        $this->data['dtlrecord'] = $dtlIssItems;

        $smryIssItems = $this->item_trans->getSmryIssItems($fr, $to);
        $this->data['smryrecord'] = $smryIssItems;

        //print_r($smryIssItems); die();

        $this->load->view($this->layout, $this->data);
    }

    public function getTransByDate()
    {
        $frdate = $this->input->post('datepicker1');
        $todate = $this->input->post('datepicker2');

        if (!empty($frdate)) {
            $fr = $frdate;
            $dateFrSelect = 'Y';
        } else {
            $fr = date('Y-m-d');
            $dateFrSelect = 'N';
        }

        if (!empty($todate)) {
            $to = $todate;
            $dateToSelect = 'Y';
        } else {
            $to = date('Y-m-d');
            $dateToSelect = 'N';
        }

        $this->data['halaman'] = 'report';
        $this->data['main_view'] = 'rpttransbydate';
        $this->data['frdate'] = $fr;
        $this->data['todate'] = $to;
        $this->data['dtfrselectedYN'] = $dateFrSelect;
        $this->data['dttoselectedYN'] = $dateToSelect;

        $smryTrans = $this->item_trans->getTransByDate($fr, $to);

        // print_r($smryTrans); die();
        $this->data['smryrecord'] = $smryTrans;

        $this->load->view($this->layout, $this->data);
    }

    public function getBstByDate()
    {
        $frdate = $this->input->post('datepicker1');
        $todate = $this->input->post('datepicker2');

        if (!empty($frdate)) {
            $fr = $frdate;
            $dateFrSelect = 'Y';
        } else {
            $fr = date('Y-m-d');
            $dateFrSelect = 'N';
        }

        if (!empty($todate)) {
            $to = $todate;
            $dateToSelect = 'Y';
        } else {
            $to = date('Y-m-d');
            $dateToSelect = 'N';
        }

        $this->data['halaman'] = 'report';
        $this->data['main_view'] = 'rptbstbydate';
        $this->data['frdate'] = $fr;
        $this->data['todate'] = $to;
        $this->data['dtfrselectedYN'] = $dateFrSelect;
        $this->data['dttoselectedYN'] = $dateToSelect;

        $this->data['listbst'] = $this->handover->getBstByDate($fr, $to);
        // print_r($this->data['listbst']); die();

        $this->load->view($this->layout, $this->data);
    }

    public function getItemQtyOH()
    {
        $bincode = $this->input->post('bin_code');

        if (!empty($bincode)) {
            $selbin = $bincode;
            $isbinselect = 'Y';
        } else {
            $selbin = 'ALL';
            $isbinselect = 'N';
        }

        $this->load->model('item_detail_model', 'item_detail');

        $this->data['isbinselect'] = $isbinselect;
        $this->data['selbin'] = $selbin;
        $this->data['listitem'] = $this->item_detail->getItemQtyOH($selbin);
        // print_r($this->data['listitem']); die();

        $this->data['halaman'] = 'report';
        $this->data['main_view'] = 'itmdtlver2';

        $this->load->view($this->layout, $this->data);
    }

    public function GetReportBstToday()
    {
        $Isi = $this->handover->IsiReviewPdfdetail_today();
        $data['IsiReviewPdf'] = $Isi;

        $this->load->view('bstTodayPdf', $data);
    }

    public function GetReportSum_BstToday()
    {
        $Isi_Sum = $this->handover->Sum_BstToday();
        $data['IsiReviewPdfSUM'] = $Isi_Sum;

        $this->load->view('bstSumToday', $data);
    }

    public function GetItemHistory()
    {
        $frdate = $this->input->post('datepicker1');
        $todate = $this->input->post('datepicker2');

        if (!empty($frdate)) {
            $fr = $frdate;
            $dateFrSelect = 'Y';
        } else {
            $fr = date('Y-m-d');
            $dateFrSelect = 'N';
        }

        if (!empty($todate)) {
            $to = $todate;
            $dateToSelect = 'Y';
        } else {
            $to = date('Y-m-d');
            $dateToSelect = 'N';
        }

        $ItemHistory = $this->handover->ItemHistory__model();
        $this->data['ItemHistory'] = $ItemHistory;
        $this->data['halaman'] = 'report';
        $this->data['main_view'] = 'ViewItemHistory';
        $this->data['frdate'] = $fr;
        $this->data['todate'] = $to;
        $this->data['dtfrselectedYN'] = $dateFrSelect;
        $this->data['dttoselectedYN'] = $dateToSelect;
        if ($this->input->post('datepicker1')) {
            $this->data['ItemHistory'] = $this->handover->ItemHistory__modelByDate($fr, $to);
        }

        $this->load->view($this->layout, $this->data);
    }

    public function GetItemDetail()
    {
        $this->data['ItemDetail'] = $this->handover->ItemDetail__model();
        $this->data['halaman'] = 'report';
        $this->data['main_view'] = 'ViewItemDetail';

        $this->load->view($this->layout, $this->data);
    }

    public function GetBinDescription()
    {
        $data['BinDesc'] = $this->handover->BinDesc__model();
        $this->load->view('BinDescription', $data);
    }
}

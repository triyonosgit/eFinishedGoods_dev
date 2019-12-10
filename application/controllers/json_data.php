<?php
class Json_Data extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => '',
        'main_view' => '',
        'title' => 'Json Data'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_master_model', 'item');

    }

    public function index($offset = null)
    {

    }

    public function item_master()
    {

      $vars = $this->input->get(null, TRUE);
      //var_dump($vars);


      if (isset($vars['search'])) {
          $SEARCH_VALUE = '%'.$vars['search'].'%';
      } else {
          $SEARCH_VALUE = '%';
      }
      //var_dump($SEARCH_VALUE);

      $LIMIT_VALUE = $vars['limit'];
      $OFFSET_VALUE = $vars['offset'];
      $SORT_VALUE = $vars['sort'];
      $ORDER_VALUE = $vars['order'];
      //var_dump($LIMIT_VALUE);
      //var_dump($OFFSET_VALUE);
      //var_dump($SORT_VALUE);
      //var_dump($ORDER_VALUE);


      $totalRows = $this->item->get_num_rows($SEARCH_VALUE);
      $item = $this->item->get_data($LIMIT_VALUE, $OFFSET_VALUE, $SORT_VALUE, $ORDER_VALUE, $SEARCH_VALUE);
      $data = array(
          'total' => $totalRows,
          'rows' => $item
      );

      echo json_encode($data);

      //var_dump($data);
    }

    public function item_master_active()
    {

      $vars = $this->input->get(null, TRUE);
      //var_dump($vars);


      if (isset($vars['search'])) {
          $SEARCH_VALUE = '%'.$vars['search'].'%';
      } else {
          $SEARCH_VALUE = '%';
      }
      //var_dump($SEARCH_VALUE);

      $LIMIT_VALUE = $vars['limit'];
      $OFFSET_VALUE = $vars['offset'];
      $SORT_VALUE = $vars['sort'];
      $ORDER_VALUE = $vars['order'];
      //var_dump($LIMIT_VALUE);
      //var_dump($OFFSET_VALUE);
      //var_dump($SORT_VALUE);
      //var_dump($ORDER_VALUE);


      $totalRows = $this->item->get_num_rows_active($SEARCH_VALUE);
      $item = $this->item->get_data_active($LIMIT_VALUE, $OFFSET_VALUE, $SORT_VALUE, $ORDER_VALUE, $SEARCH_VALUE);
      $data = array(
          'total' => $totalRows,
          'rows' => $item
      );

      echo json_encode($data);

      //var_dump($data);
    }

}

<?php

use
    DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\MJoin,
	DataTables\Editor\Options,
    DataTables\Editor\Upload,
    DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
	
    
class Inputso_model extends CI_Model 
{
    private $editorDb = null;
    
    //constructor which loads the CodeIgniter database class (not required)
    public function __construct()	{
        $this->load->database();
    }    
    
    public function init($editorDb)
    {
        $this->editorDb = $editorDb;
    }
    
    public function getStoItem($post)
    {
		// Build our Editor instance and process the data coming from _POST
		// Use the Editor database class
		Editor::inst( $this->editorDb, 'sto_hist' )
			->fields(
                Field::inst( 'sto_rack' ),
				Field::inst( 'sto_bin' ),
                Field::inst( 'sto_item' ),
                Field::inst( 'sto_desc' ),
                Field::inst( 'sto_uom' ),
				Field::inst( 'sto_qty' ),
				Field::inst( 'sto_qtyreal' )
					->validator( Validate::numeric() )
                    ->setFormatter( Format::ifEmpty(0) ),
                Field::inst( 'sto_qtyng' )
					->validator( Validate::numeric() )
                    ->setFormatter( Format::ifEmpty(0) ),
                Field::inst( 'sto_rmks' )
                    ->setFormatter( Format::ifEmpty('-') ),
                Field::inst( 'sto_updatedby' )
                    ->setValue($this->session->userdata('username')),
                Field::inst( 'sto_updateddt' )
                    ->setValue(date('Y-m-d H:i:s'))
            )
            ->where('sto_nbr', $this->getMaxStoNbr())
			->process( $post )
			->json();
    }
    
    //An additional method just to see if we can still use the Codeigniter database class (not required)
    public function getStaffMember($id)
    {
        if($id != false) 
        {
            //Use the CodeIgniter database class
            $query = $this->db->get_where('users', array('id' => $id));
            return $query->row_array();
        }
        return false;
    }

    public function isStillOpen($nbr) {
        $sql = " select count(*) as cnt
                   from sto_hist
                  where sto_nbr = '".$nbr."'
                    and sto_status = 'OPN' ";
        $query = $this->db->query($sql);

        if ($query->row('cnt') > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMaxStoNbr() {
        $sql = " select max(sto_nbr) as maxNbr
                   from sto_hist ";
        $query = $this->db->query($sql);

        return $query->row('maxNbr');
    }


}
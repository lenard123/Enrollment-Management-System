<?php 

class Login_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}

	public function chkData()
	{
		$res = 0;
		if(isset($_POST['user']) && isset($_POST['pass'])){
			$res = 'aaa';
			$a = array('USERNAME'=>$_POST['user'], 'PASSWORD'=>$_POST['pass']);
			$query = $this->db->get_where('ADMIN', $a);
			$row = $query->row();
			$res =  $query->num_rows();
			if($res==1)
			{
				$logged = array(
					'ADMIN_ID' => $row->ID,
					'logged_in'=> true
				);
				$this->session->set_userdata($logged);
			}
		}
		return $res;
	}


}
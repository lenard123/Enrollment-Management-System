<?php 

class Account_model extends CI_Model{
		

	public function __construct()
	{
		parent::__construct();
	}


	//Update Account
	public function getAdminInfo(){
		$id = $_SESSION['ADMIN_ID'];
		$this->db->select('*');
		$this->db->from('ADMIN');
		$this->db->where('ID',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function updateAdminInfo(){
		$id = $_SESSION['ADMIN_ID'];
		$username = $this->input->post('username');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$gender = $this->input->post('gender');
		//check if username exists
		$this->db->select('*');
		$this->db->from('ADMIN');
		$this->db->where('USERNAME', $username);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$res = '{"status":"failed","message":"Username already exists"}';
		}else{
			$params = array(
				'USERNAME' => $username,
				'FIRSTNAME' => $firstname,
				'LASTNAME' => $lastname,
				'GENDER' => $gender
			);
			$this->db->where('ID', $id);
			if($this->db->update('ADMIN', $params)){
				$res = '{"status":"success","message":"admin updated Successfully"}';
			}else{
				$res = '{"status":"failed","message":"User already exist"}';
			}
		}
		return $res;
	}

	public function updateAdminPassword(){
		$id = $_SESSION['ADMIN_ID'];
		$oldpassword = $this->input->post('oldpassword');
		$newpassword = $this->input->post('newpassword');
		//check if password is correct
		$params = array('ID'=>$id, 'PASSWORD'=>$oldpassword);
		$query = $this->db->get_where('ADMIN', $params);
		if($query->num_rows() == 1){
			$params = array('PASSWORD'=>$newpassword);
			$this->db->where('ID',$id);
			if($this->db->update('ADMIN',$params)){
				$res = '{"status":"success","message":"admin updated Successfully"}';
			}else{
				$res = '{"status":"failed","message":"Error occured"}';
			}
		}else{
			$res = '{"status":"failed","message":"Wrong password"}';
		}
		return $res;
	}


	//Add Account
	public function addAccount(){
		$username = $this->input->post('username');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$gender = $this->input->post('gender');
		$password = $this->input->post('password');
		//check if username exists
		$this->db->select('*');
		$this->db->from('ADMIN');
		$this->db->where('USERNAME', $username);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$res = '{"status":"failed","message":"Username already exists"}';
		}else{
			$params = array(
				'USERNAME' => $username,
				'FIRSTNAME' => $firstname,
				'LASTNAME' => $lastname,
				'GENDER' => $gender,
				'PASSWORD' => $password
			);
			if($this->db->insert('ADMIN', $params)){
 		 		$res = '{"status":"success","message":"Inserted Successfully"}';
 		 	}else{
 		 		$res = '{"status":"error","message":"'. $this->db->error() . '"}';
 		 	}
		}
		return $res;
	}


	//Manage Account
	public function getAllAdmin(){
		$this->db->select('*');
		$this->db->from('ADMIN');
		$query = $this->db->get();
		return $query->result();
	}	

	public function deleteAdmin(){
		$id = $this->input->get('id');
		$password = $this->input->get('password');
		//check if password is correct
		$params = array('ID'=>$_SESSION['ADMIN_ID'], 'PASSWORD'=>$password);
		$query = $this->db->get_where('ADMIN', $params);
		if($query->num_rows() == 1){	
			$a = array('ID'=> $id);
	 		if($this->db->delete('ADMIN',$a)){
				$res = '{"status":"success","message":"Deleted Successfully"}';
	 		}else{
	 			$res = '{"status":"error","message":"'.$this->db->error().'"}';
	 		}
	 	}else{
	 		$res = '{"status":"error","message":"Wrong password"}';
	 	}
 		return $res;		
	}
}
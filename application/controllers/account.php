<?php 

class Account extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('main');
		$this->load->library('session');
		$this->load->helper('url_helper');		
		$this->load->database();
		$this->load->model('Account_model');
	}


	public function updateAccount(){
		if(isset($_GET['submit'])){
			echo $this->Account_model->updateAdminInfo();
			die();
		}else if(isset($_GET['submitpassword'])){
			echo $this->Account_model->updateAdminPassword();
			die();
		}
		$data['page'] = 'account';
		$data['title'] = 'Update Account';
		$data['admin_info'] = json_encode($this->Account_model->getAdminInfo());
		$this->load->view('template/header', $data);
		$this->load->view('account/update', $data);
		$this->load->view('template/footer');	
	}

	public function addAccount(){
		if(isset($_GET['submit'])){
			echo $this->Account_model->addAccount();
			die();
		}
		$data['page'] = 'account';
		$data['title'] = 'Add Account';
		$this->load->view('template/header', $data);
		$this->load->view('account/add', $data);
		$this->load->view('template/footer');		
	}

	public function manageAccount(){
		$data['allAdmin'] = json_encode($this->Account_model->getAllAdmin());
		if(isset($_GET['getAllAdmin'])){
			echo $data['allAdmin'];
			die();
		}else if(isset($_GET['delete'])){
			echo $this->Account_model->deleteAdmin();
			die();
		}
		$data['page'] = 'account';
		$data['title'] = 'Manage Account';
		$this->load->view('template/header', $data);
		$this->load->view('account/manage', $data);
		$this->load->view('template/footer');
	}
}

?>
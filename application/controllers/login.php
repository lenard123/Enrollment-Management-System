<?php 

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('main');
		$this->load->library('session');
		$this->load->helper('url_helper');		
		$this->load->database();		
	}

	public function index()
	{
		if($this->main->isLogin()){
			$this->main->gotoHome();
		}else{
			$this->load->view('index1');
		}

	}

	public function checkData(){
		echo $this->login_model->chkData();;
		//$this->load->view('login_result',$data);
	}
}

?>
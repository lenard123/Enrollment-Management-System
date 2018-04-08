<?php 

class main extends CI_Model{


	public function isLogin(){
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
			return true;
		}else{
			return false;
		}

	}

	public function gotoHome(){
		echo '<meta http-equiv="refresh" content="0; url='.base_url().'home" />';
	}

	public function gotoLogin(){
		echo '<meta http-equiv="refresh" content="0; url='.base_url().'" />';		
	}

	public function logout(){
		unset($_SESSION['logged_in']);
		$this->gotoLogin();
	}

	public function getBalance(){
		return 1000;
	}

}

?>
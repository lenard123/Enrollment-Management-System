<?php 

class Test extends CI_Controller{

	public function index(){
		$this->load->library('pagination');
		$this->load->database();
		$config['base_url'] = "http://localhost/ems/test/page";
		$config['total_rows'] = $this->db->count_all('ALLSTUDENT');
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		echo $this->pagination->create_links();
	}

	public function page($page = 0){
		$this->load->library('pagination');
		$this->load->helper('url_helper');
		$this->load->database();
		$config['base_url'] = "http://localhost/ems/test/page";
		$config['total_rows'] = $this->db->count_all('ALLSTUDENT');
		$config['per_page'] = 10;
		$config['display_pages'] = false;
		$config['full_tag_open'] = "<ul class='pager'>";
		$config['prev_tag_open'] = "<li class='previous'>";
		$config['preg_tag_close'] = "</li>";
		$config['next_tag_open'] = "<li class='next'>";
		$config['next_tag_close'] = "</li>";		
		$config['last_link'] = FALSE;
		$config['first_link'] = FALSE;
		$config['full_tag_close']="</ul>";
		$this->pagination->initialize($config);
		$data['page'] = $this->pagination->create_links();
		$this->load->view("test",$data);
	}

}
<?php 

class Home extends CI_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->model('main');
		$this->load->model('home_model');
		$this->load->library('session');
		$this->load->helper('url_helper');		
		$this->load->database();
	}

	//pages
	public function index(){
		if($this->main->isLogin()){
			$data['page'] = "home";
			$data['title'] = "Home";
			$this->load->view('template/header',$data);
			$this->load->view('home',$data);
			$this->load->view('template/footer',$data);			
		}else{
			$this->main->gotoLogin();
		}
	}

	public function manageclass(){
		if($this->main->isLogin()){
			$data['page'] = "manageclass";
			$data['title'] = "Manage Class";
			$this->load->view('template/header',$data);
			$this->load->view('home/manageclass',$data);	
			$this->load->view('template/footer',$data);		
		}else{
			$this->main->gotoLogin();
		}		
	}

	public function managegrade($gradeId){
		if($this->main->isLogin()){
			$grade = $this->home_model->getGrade($gradeId);
			$data['page'] = "manageclass";
			$data['title'] = "Manage Grade ".$grade;
			$data['gradeId'] = $gradeId;
			$this->load->view('template/header',$data);
			$this->load->view('home/managegrade',$data);
			$this->load->view('template/footer');
		}else{
			$this->main->gotoLogin();			
		}
	}	

	public function manageStudent($view,$page=0){
		if($this->main->isLogin()){
			$this->load->library('pagination');
			$data['current_page'] = $page;		
			$data['page'] = "managestudent";
			$data['title'] = "Manage Student ";
			$data['view'] = $view;
			$data['view1'] = $view;
			switch ($view) {
				case 'enrolled':
					$data['totalPage'] = $this->db->count_all('ENROLLEDSTUDENT');
					break;
				case 'pending':
					$data['totalPage'] = $this->db->count_all('PENDINGSTUDENT');
					break;
				default:
					$data['totalPage'] = $this->db->count_all('ALLSTUDENT');
					break;
			}

			$data['pagination'] = $this->home_model->getPagination($view, $data['totalPage']);			
			$this->load->view('template/header',$data);
			if($view == "all") $data['view'] = "All";
			if($view == "pending") $data['view'] = "Pending";
			if($view == "enrolled") $data['view'] = "Enrolled";
			$this->load->view('home/managestudents',$data);
			$this->load->view('template/footer');
		}else{
			$this->main->gotoLogin();			
		}
	}	

	public function addstudent(){
		if($this->main->isLogin()){
			$data['page'] = "addstudent";
			$data['title'] = "Add Student";
			$data['BALANCE'] = $this->main->getBalance();			
			$this->load->view('template/header',$data);
			$this->load->view('home/addstudent',$data);
			$this->load->view('template/footer',$data);			
		}else{
			$this->main->gotoLogin();
		}		
	}

	public function updatestudent($id){
		if($this->main->isLogin()){
			$data['page'] = "managestudent";
			$data['title'] = "Update Student";
			$data['view'] = "";
			$data['id'] = $id;
			$data['studentInfo'] = $this->home_model->getStudentInfo($id);
			$data['oldId'] = $data['studentInfo']->STUDENT_ID;
			$data['studentInfo'] = json_encode($data['studentInfo']);
			$this->load->view('template/header',$data);
			$this->load->view('home/updatestudent',$data);
			$this->load->view('template/footer');
		}else{
			$this->main->gotoLogin();
		}		
	}

	public function enrollStudent($id){
		if($this->main->isLogin()){
			if(isset($_POST['requirement'])){
				$this->home_model->updateRequirement($id);
			}else if(isset($_POST['enroll'])){
				$this->home_model->enrollStudent($id);
			}
			$data['page']  = "managestudent";
			$data['title'] = "Enroll Student";
			$data['view']  = "";
			$studentInfo = $this->home_model->getStudentInfo1($id);
			$data['requirement'] = $studentInfo->REQUIREMENT;
			$data['student_info'] = json_encode($studentInfo);

			$data['all_grade'] = json_encode($this->home_model->getAllGrade());
			$data['all_section'] = json_encode($this->home_model->getAllSection1());
			$data['current_section'] = $studentInfo->SECTION;



			$this->load->view('template/header',$data);
			$this->load->view('home/enrollstudent');
			$this->load->view('template/footer');
		}else{
			$this->main->gotoLogin();
		}
	}

	public function searchStudent(){
		if($this->main->isLogin()){
			$data['q'] = $this->input->get('q');			
			if($this->input->get('refresh') == 'true'){
				echo json_encode($this->home_model->searchStudent($data['q']));
				die();
			}
			$data['page'] = '';
			$data['title'] = 'Search result for: '. $data['q'];
			$data['result'] = json_encode($this->home_model->searchStudent($data['q']));
			$this->load->view('template/header',$data);
			$this->load->view('home/search');
			$this->load->view('template/footer');
		}
	}

	public function manageSection($id){
		if($this->main->isLogin()){
			if($this->input->get('view')=='false'){
				echo json_encode($this->home_model->getStudentBySection($id));	
			}else{
				$data['page']  = "manageclass";
				$data['title'] = "Manage Section";
				$data['section_info'] = json_encode($this->home_model->getSection($id));
				$data['students'] = json_encode($this->home_model->getStudentBySection($id));
				$data['section_id'] = $id;			
				$this->load->view('template/header',$data);
				$this->load->view('home/managesection');
				$this->load->view('template/footer');
			}
		}else{
			$this->main->gotoLogin();
		}
	}

	public function getSection($id){
		echo json_encode($this->home_model->getSection($id));
	}

	public function getStudentBySection($id){
		echo json_encode($this->home_model->getStudentBySection($id));
	}




	//function -- CRUD--
	public function insertStudent(){
		if($this->main->isLogin()){
			$res = $this->home_model->insertStudent();
			echo $res;
		}		
	}

	public function getStudent($view){
		$data = array();
		$data = $this->home_model->getStudent($view);
		echo json_encode($data);
	}

	public function editStudent($id){
		if($this->main->isLogin()){
			$res = $this->home_model->updateStudent($id);
			echo $res;
		}		
	}

	public function removeStudent($id){
		$param = array('STUDENT_ID'=>$id);
		$res = '';
		if($this->db->delete('ENROLL',$param)){
			$res = '{"status":"success","message":"Deleted Successfully"}';
		}else{
			$res = '{"status":"error","message":"'.$this->db->error().'"}';
		}
		echo $res;
	}

	public function deleteStudent($id){
		$param = array('ID'=> $id);
		$res = '';
		if($this->db->delete('STUDENT', $param)){
			$res = '{"status":"success","message":"Deleted Successfully"}';
		}else{
			$res = '{"status":"error","message":"'.$this->db->error().'"}';
		}
		echo $res;	
	}

	//GRADE
	public function addGrade(){
		if($this->main->isLogin()){
			$res = $this->home_model->insertGrade();
			echo $res;
		}		
	}//create

	public function getAllGrade(){
		$data = array();
		$data = $this->home_model->getAllGrade();
		echo json_encode($data);
	}//read

	public function editGrade($oldGrade, $newGrade){
		if($this->main->isLogin()){		
			$data = $this->home_model->editGrade($oldGrade,$newGrade);
			echo $data;
		}
	}//update

	public function deleteGrade($grade){
		$data = $this->home_model->deleteGrade($grade);
		echo $data;
	}//delete	



	//SECTION
	public function addSection(){
		if($this->main->isLogin()){
			$res = $this->home_model->insertSection();
			echo $res;
		}
	}

	public function getAllSection($gradeId){
		if($this->main->isLogin()){
			$data = array();
			$data = $this->home_model->getAllSection($gradeId);
			echo json_encode($data);
		}
	}

	public function editSection(){
		if($this->main->isLogin()){			
			$data = $this->home_model->editSection();
			echo $data;
		}
	}	

	public function deleteSection($id){
		if($this->main->isLogin()){
			$data = $this->home_model->deleteSection($id);
			echo $data;
		}
	}



	public function logout(){
	
		$this->main->logout();
	}

}

?>
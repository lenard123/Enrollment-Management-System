 <?php 

 class Home_model extends CI_Model{

 	public function deleteSection($id){
 		$param = array('ID'=>$id);
 		$res= "";
 		if($this->db->delete('SECTION',$param)){
			$res = '{"status":"success","message":"Deleted Successfully"}';
 		}else{
 			$res = '{"status":"error","message":"'.$this->db->error().'"}';
 		}
 		return $res; 		
 	}

 	public function deleteGrade($grade){
 		$a = array('ID' => $grade);
 		$res = "";
 		if($this->db->delete('GRADE',$a)){
			$res = '{"status":"success","message":"Deleted Successfully"}';
 		}else{
 			$res = '{"status":"error","message":"'.$this->db->error().'"}';
 		}
 		return $res;
 	} 	

 	public function editGrade($oldGrade, $newGrade){
		$res = "";
		//check if Grade already exist
		$isNewGradeExist = false;
 		foreach ($this->getAllGrade() as $a) {
 			if($newGrade == $a->GRADE){
 				$isNewGradeExist = true;	
 			} 
 		};

 		if($isNewGradeExist){
 			$res = '{"status":"error","message":"Grade already exists"}';
 		}else{
 			$this->db->set('GRADE',$newGrade);
 			$this->db->where('GRADE',$oldGrade);
 			if($this->db->update('GRADE')){
 				$res = '{"status":"success","message":"Grade updated Successfully"}';
 			}else{
 				$res = '{"status":"error","message":"error occured '.$this->db->error().'"}';
 			}
 		}

 		return $res;
 	}

 	public function editSection(){
 		$res = "";
 		$section = $_POST['section'];
 		$teacher = $_POST['teacher'];
 		$gradeId = $_POST['gradeId'];
 		$id = $_POST['id'];
 		if(!$this->isSectionExist($section,$gradeId)){
 			$this->db->set('SECTION',$section);
 			$this->db->set('TEACHER',$teacher);
 			$this->db->where('ID',$id);
 			if($this->db->update('SECTION')){
 				$res = '{"status":"success","message":"Section updated Successfully"}';
 			}else{
 				$res = '{"status":"error","message":"error occured '.$this->db->error().'"}';
 			}
 		}else{
 			$res = '{"status":"error","message":"Section already exists"}';
 		}
 		return $res;
 	}

 	public function enrollStudent($id){
 		$isIDExist = $this->db->get_where('ENROLL', array('STUDENT_ID' => $id))->num_rows() == 1 ? true : false;
 		if(!$isIDExist){
 			$student_id = $id;
 			$section_id = $this->input->post('section');
 			$params = array(
 				'STUDENT_ID' => $id,
 				'SECTION_ID' => $section_id,
 			);
 			$this->db->insert('ENROLL', $params);
 		}else{
 			$student_id = $id;
 			$section_id = $this->input->post('section');
 			$params = array(
 				'SECTION_ID' => $section_id,
 			);
 			$this->db->where('STUDENT_ID',$student_id);
 			$this->db->update('ENROLL', $params); 			
 		}
 	} 	

 	public function getAllGrade(){

 		return $this->db->get('GRADE')->result();
 	}

 	public function getStudent($view){
 		$page = isset($_GET['page']) ? $_GET['page'] : 0;
 		switch($view){
 			case "enrolled":
 				$totalpage = $this->db->count_all('ENROLLEDSTUDENT');
 				$page = $page > $totalpage ? 10 : $page; 			
 				$data = $this->db->get('ENROLLEDSTUDENT',10,$page)->result();
 				break;
 			case "pending":
 				$totalpage = $this->db->count_all('PENDINGSTUDENT');
 				$page = $page > $totalpage ? 10 : $page; 			
 				$data = $this->db->get('PENDINGSTUDENT',10,$page)->result();
 				break;
 			default:
 				$totalpage = $this->db->count_all('ALLSTUDENT');
 				$page = $page > $totalpage ? 10 : $page;
 				$data = $this->db->get('ALLSTUDENT',10,$page)->result();
 				break;
 		}
 		return $data;
 	}

	public function searchStudent($q){
		//SELECT * FROM `allstudent` WHERE STUDENT_ID LIKE '%$q%' OR FIRSTNAME LIKE '%$q%' OR LASTNAME LIKE '%$q%' limit 15
 		$this->db->select('*');
 		$this->db->from('ALLSTUDENT');
 		$this->db->like('ID',$q);
 		$this->db->or_like('FIRSTNAME',$q);
 		$this->db->or_like('LASTNAME',$q);
 		$this->db->limit(15);
 		$query = $this->db->get();
 		return  $query->result();
 	}

 	public function getSection($id){
 		$this->db->select('grade.GRADE, grade.ID, section.SECTION, section.TEACHER');
 		$this->db->from('SECTION');
 		$this->db->join('GRADE', 'grade.ID=section.GRADE_ID','inner');
 		$this->db->where('section.ID',$id);
 		$query = $this->db->get();
 		return $query->row();
 	}

 	public function getStudentBySection($id){
 		$this->db->select('student.ID, student.STUDENT_ID, concat(student.FIRSTNAME," ",student.LASTNAME) AS NAME, student.BIRTHDAY, student.GENDER');
 		$this->db->from('student');
 		$this->db->join('ENROLL','student.ID=enroll.STUDENT_ID','inner');
 		$this->db->where('enroll.section_id',$id);
 		$query = $this->db->get();
 		return $query->result();
 	}

 	public function getGrade($id){
 		$this->db->where('ID',$id);
 		$data = $this->db->get('GRADE')->row();
 		return $data->GRADE;
 	}

 	public function getAllSection($gradeId){
 		$this->db->select('section.ID,section.SECTION,section.TEACHER,section.GRADE_ID, COUNT(enroll.SECTION_ID) AS STUDENT');
 		$this->db->from('SECTION');
 		$this->db->join('ENROLL','SECTION.ID=ENROLL.SECTION_ID','left');
 		$this->db->where('SECTION.GRADE_ID',$gradeId);
 		$this->db->group_by('SECTION.SECTION');
 		$query = $this->db->get();
 		return $query->result();
 		/*$sql = "SELECT * FROM SECTION LEFT JOIN ENROLL ";
 		$param = array('GRADE_ID' => $gradeId);
 		$query = $this->db->get_where('SECTION', $param);
 		return $query->result();*/
 	}

 	public function getAllSection1(){
 		$query = $this->db->get('SECTION');
 		return $query->result(); 		
 	} 	

 	public function getStudentInfo($id){
 		$this->db->where('ID',$id);
 		$data = $this->db->get('STUDENT')->row();
 		return $data;
 	}

 	public function getStudentInfo1($id){
 		$this->db->where('ID',$id);
 		$data = $this->db->get('STUDENT_INFO')->row();
 		return $data;
 	} 	

 	public function getPagination($view, $totalpage){
		$this->load->library('pagination');
		$config['base_url'] = base_url()."/home/managestudent/$view/";
		$config['per_page'] = 10;
		$config['display_pages'] = false;
		$config['full_tag_open'] = "<ul class='pager' style='margin: 0px'>";
		$config['prev_tag_open'] = "<li class='previous'>";
		$config['prev_link'] = "Previous";
		$config['preg_tag_close'] = "</li>";
		$config['next_tag_open'] = "<li class='next'>";
		$config['next_link'] = "Next";
		$config['next_tag_close'] = "</li>";		
		$config['last_link'] = FALSE;
		$config['first_link'] = FALSE;
		$config['full_tag_close']="</ul>";	
		$config['total_rows'] = $totalpage;			
		$this->pagination->initialize($config);
		return $this->pagination->create_links();		 		
 	}

 	public function insertGrade(){
 		$res = "";
 		$grade = $_POST['grade'];
 		if(!$this->isGradeExist($grade)){
 			$data = array(
 				'GRADE' => $grade
 			);
 			if($this->db->insert('GRADE',$data)){
 				$res = '{"status":"success","message":"grade added Successfully"}';
 			}else{
 				$res = '{"status":"error","message":"'.  $this->db->error() . '"}';
 			}
 		}else{
 			$res = '{"status":"error","message":"Student ID already Exists"}';
 		}
 		return $res;
 	}

 	public function insertSection(){
 		$res = "";
 		$section = $_POST['section'];
 		$teacher = $_POST['teacher'];
 		$gradeId = $_POST['gradeId'];
 		if(!$this->isSectionExist($section,$gradeId)){
 			$param = array(
 				'SECTION' => $section,
 				'TEACHER' => $teacher,
 				'GRADE_ID'=> $gradeId
 			);
 			if($this->db->insert('SECTION',$param)){
 				$res = '{"status":"success","message":"Section added Successfully"}';
 			}else{
 				$res = '{"status":"error","message":"'.  $this->db->error() . '"}';
 			}
 		}else{
 			$res = '{"status":"error","message":"Section already Exists"}';
 		}
 		return $res;
 	}

 	public function insertStudent(){
     	 $res = "";
 		 $id = $_POST['id'];
 		 $fname = $_POST['fname'];
 		 $mname = $_POST['mname'];
 		 $lname = $_POST['lname'];
 		 $bday = $_POST['bday'];
 		 $address = $_POST['address'];
 		 $gender = $_POST['gender'];
 		 $isenroll = 'false';
 		 $balance = $this->main->getBalance();;
 		 $requirement = 'false';
 		 $admin_id = $_SESSION['ADMIN_ID'];
 		 if(!$this->isIDExist($id)){
 		 	$data = array(
 		 		'STUDENT_ID'        => $id,
 		 		'FIRSTNAME' => $fname,
 		 		'MIDDLENAME'=> $mname,
 		 		'LASTNAME'  => $lname,
 		 		'BIRTHDAY'  => $bday,
 		 		'ADDRESS'   => $address,
 		 		'GENDER'    => $gender,
 		 		'ISENROLL'  => $isenroll,
 		 		'BALANCE'   => $balance,
 		 		'REQUIREMENT'=>$requirement,
 		 		'ADMIN_ID'  => $admin_id
  		 	);
 		 	if($this->db->insert('STUDENT', $data)){
 		 		$res = '{"status":"success","message":"Inserted Successfully"}';
 		 	}else{
 		 		$res = '{"status":"error","message":"'. $this->db->error() . '"}';
 		 	}
 		 }else{
 		 	$res = '{"status":"error","message":"Student ID already Exists"}';
 		 }
 		 return '['.$res.']';
 	}

 	public function isIDExist($id){
 		$a = array('STUDENT_ID' => $id);
 		$query =$this->db->get_where('STUDENT', $a);
 		$res = $query->num_rows();
 		if($res == 1){
 			return true;
 		}else{
 			return false;
 		}
 	}

 	public function isGradeExist($grade){
 		$a = array('GRADE' => $grade);
 		$query = $this->db->get_where('GRADE',$a);
 		$res = $query->num_rows();
 		if($res == 1){
 			return true;
 		}else{
 			return false;
 		}
 	}

 	public function isSectionExist($section, $gradeId){
 		$param = array('SECTION' => $section, 'GRADE_ID' => $gradeId);
 		$query = $this->db->get_where('SECTION',$param);
 		$res = $query->num_rows();
 		if($res == 1){
 			return true;
 		}else{
 			return false;
 		}
 	}

 	public function updateStudent($oldId){
 		$res    = "";
 		$id     = $this->input->post('id');
 		$oldId1 = $this->input->post('oldId');
 		$fname  = $this->input->post('fname');
 		$mname  = $this->input->post('mname');
 		$lname  = $this->input->post('lname');
 		$bday   = $this->input->post('bday');
 		$addr   = $this->input->post('addr');
 		$gender = $this->input->post('gender');
 		$params = array(
 			'STUDENT_ID' => $id,
 			'FIRSTNAME'  => $fname,
 			'MIDDLENAME' => $mname,
 			'LASTNAME'   => $lname,
 			'BIRTHDAY'	 => $bday,
 			'ADDRESS'    => $addr,
 			'GENDER'     => $gender
 		);
 		
 		if($id == $oldId1){
 			$this->db->where('ID',$oldId);
 			if($this->db->update('STUDENT',$params)){
 				$res = '{"status":"success","message":"Student updated Successfully"}';
 			}else{
 				$res = '{"status":"error","message":"something went wrong"}';
 			}
 		}else{
 			if($this->isIDExist($id)){
 				$res = '{"status":"error","message":"Id already exists"}';
 			}else{
 				$this->db->where('ID',$oldId);
	 			if($this->db->update('STUDENT',$params)){
	 				$res = '{"status":"success","message":"Student updated Successfully"}';
	 			}else{
	 				$res = '{"status":"error","message":"something went wrong"}';
	 			} 				
 			}
 		}

 		return $res;
 	}

 	public function updateRequirement($id){
 		$requirement = $this->input->post('requirement') == 'Complete' ? true : false;
 		$balance = $this->input->post('balance');
 		$current_balance = $this->input->post('current_balance');
 		if($balance > $current_balance){
 			$balance = 0;
 		}else if($balance <= $current_balance){
 			$balance = $current_balance - $balance;
 		}else{
 			$balance = $current_balance;
 		}
 		$params = array(
 			'REQUIREMENT' => $requirement,
 			'BALANCE'     => $balance
 		);
 		$this->db->where('ID',$id);
 		$this->db->update('STUDENT', $params);
 	}

 }

 ?>
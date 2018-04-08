		<div id="app">

			<div class="container">
				<div class="main-content">
					<div class="panel panel-info addstudent">
						<div class="panel-heading">Enroll Student</div>
						<div class="panel-body">
							<div class="panel panel-primary">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6">
											<strong>Name : </strong>{{student_info.FIRSTNAME}} {{student_info.LASTNAME}}<br/>
											<strong>Student Id : </strong>{{student_info.STUDENT_ID}}<br/>
											<strong>Gender : </strong>{{student_info.GENDER}}
										</div>
										<div class="col-md-6">
											<strong>Status : </strong> {{current_section1=='' ? 'Pending' : 'Enrolled'}}<br/>
											<strong>Current Balance : </strong>{{student_info.BALANCE}}<br/>
											<strong>Requirements : </strong>{{student_info.REQUIREMENT=='1' ? "Complete" : "Incomplete"}}
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-primary">
								<div class="panel-body">
									
										
										<div class="form-group">
											<label for="requirement">Requirement</label>
											<select class="form-control" v-model="requirement" name="requirement">
												<option>Complete</option>
												<option>Incomplete</option>
											</select>
										</div>
										<div class="form-group">
											<label for="balance">Balance</label>
											<input class="form-control" type="number" v-model="balance" name="balance" placeholder="Enter amount" />
										</div>
										<div class="form-group">
											<form action="" method="post">
												<input type="hidden" name="current_balance" v-model="student_info.BALANCE" />
												<input type="hidden" name="requirement" v-bind:value="requirement" />
												<input type="hidden" name="balance" v-bind:value="balance" />
												<button v-bind:class="{'disabled':current_section1!=''}" type="submit" class="btn btn-primary">Submit</button>
											</form>
										</div>
									
								</div>
							</div>
							<div class="alert alert-info">
								<strong>Note </strong>{{student_info.GENDER=="MALE" ? 'He' : 'She'}} can only be enroll if {{student_info.GENDER=="MALE" ? 'he' : 'she'}} complete the requirements and pay the balance
							</div>
							<div class="panel panel-primary">
								<div class="panel-body">
									<div class="form-group">
										<label for="grade">Grade</label>
										<select class="form-control" name="grade" v-model="student_info.GRADE" v-on:change="getSection(student_info.GRADE)">
											<option v-for="grades in grade">{{grades.GRADE}}</option>
										</select>
									</div>
									<div class="form-group">
										<label for="section">Section</label>
										<select class="form-control" v-model="student_info.SECTION">
											<option v-for="(sections,index) in current_section">{{sections.SECTION}}</option>
										</select>
									</div>
									<div class="form-group">
										<form action="" method="post">
											<input type="hidden" name="enroll" />
											<input type="text" style="display: none" name="section" v-bind:value="getSectionId(student_info.SECTION)" required/>
											<button type="submit" class="btn btn-primary" v-bind:class="{'disabled':!isValid()}">Submit</button>
											<button type="button" class="btn btn-default" v-on:click="back()">Back</button>
										</form>
									</div>									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var apiURL = "<?php echo base_url();?>";
			var app = new Vue({
				el:"#app",
				data:{
					balance:'',
					current_section:[],
					current_section1:'<?php echo $current_section; ?>', 
					grade:<?php echo $all_grade; ?>,
					section:<?php echo $all_section; ?>,
					student_info:<?php echo $student_info; ?>,
					requirement: '<?php echo $requirement; ?>'=='1' ? "Complete" : "Incomplete"
				},
				created(){
					this.getSection(this.student_info.GRADE);
				},
				methods:{
					getRequirement: function(){
						return this.student_info.REQUIREMENT ? "Complete" : "Incomplete"; 
					},
					getAllGrade: function(){
						var vm = this;
						var url = apiURL+"home/getAllGrade";
						vm.grade = {"ID":"","GRADE":"Loading..."};
						axios.get(url).then(function(response){
							vm.grade = response.data;
							if(vm.grade.length < 1){
								vm.grade = [{"ID":"","GRADE":"No grade"}];								
							}
							vm.select_grade = vm.grade[0].GRADE;
						})
					},
					getGradeId: function(grade){
						var res = "";
						var vm = this;
						for(var i=0;i<vm.grade.length;i++){
							if(vm.grade[i].GRADE == grade) res = vm.grade[i].ID;
						}
						return res;
					},
					getSectionId: function(section){
						var res = "";
						var vm = this;
						for(var i=0; i<vm.current_section.length;i++){
							if(vm.current_section[i].SECTION==section) res = vm.current_section[i].ID;
						}
						return res;
					},
					getSection: function(grade){
						var vm = this;
						vm.current_section = [];
						var grade_id = this.getGradeId(grade);
						for(var i=0; i<vm.section.length;i++){
							if(grade_id==vm.section[i].GRADE_ID) vm.current_section.push(vm.section[i]);
						}
					},
					isValid: function(){
						 if(this.student_info.BALANCE == "0" && this.student_info.REQUIREMENT=="1"){
						 	return true;
						 }else{
						 	return false;
						 }
					},
					back: function(){
						location.replace(apiURL+'home/updatestudent/'+this.student_info.ID);
					}

				},
				watch:{
					student_info : function(val){
						this.getSection(val);
					}
				}
			})
		</script>
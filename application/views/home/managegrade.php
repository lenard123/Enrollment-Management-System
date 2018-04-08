<div id="app">

	<div class="container">
		<div class="main-content">
			<div class="manageclass">
				<form action="#" v-on:submit.prevent="insertSection">
					<div v-bind:class="{'has-error':errors.has('section')}">
						<label for="section">Add Section</label>
						<input v-validate="'required'" v-model="section" type="text" name="section" class="form-control" id="section" />
						<span v-show="errors.has('section')" class="text-danger">{{ errors.first('section') }}</span>
 					</div><br/>
					<div v-bind:class="{'has-error':errors.has('teacher')}">
						<label for="teacher">Add Teacher</label>
						<input v-model="teacher" type="text" name="teacher" class="form-control" id="teacher" />
						<span v-show="errors.has('teacher')" class="text-danger">{{ errors.first('teacher') }}</span>
 					</div><br/>	
 					<div>
 						<button class="btn btn-primary" type="submit">Submit</button>
 						<button class="btn btn-default" type="reset">Reset</button>
						<div v-if="addStudentMessage.show" class="alert" v-bind:class="addStudentMessage.alertType">
							<strong>{{addStudentMessage.messageType}}</strong> {{addStudentMessage.message}}
						</div>
 					</div>			
				</form><br/>
				<small>Click the sections to View the students</small>
				<div class="panel panel-info addstudent">
					<div class="panel-heading">
						<table style="width: 100%">
							<tr>
								<td>Manage Section</td>
								<td style="text-align:right"><button class="btn btn-default" v-on:click="back()">Back</button></td>
							</tr>
						</table>
					</div>
					<div class="panel-body" style="padding:0px">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Section</th>
										<th>Teacher</th>
										<th>Edit</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="row in allSection">
										<td v-on:click="manageSection(row.ID)">{{row.SECTION}} <span class="badge" v-if="row.STUDENT>0">{{row.STUDENT}}</span></td>
										<td>{{row.TEACHER}}</td>
										<td v-on:click="selectedSection=row.ID;updateSection=row.SECTION;updateTeacher=row.TEACHER;updateId=row.ID" data-toggle="modal" data-target="#updateSectionModal"><span class="glyphicon glyphicon-pencil" ></span> Edit</td>
										<td v-on:click="selectedSection=row.ID;selectedSectionName=row.SECTION" data-toggle="modal" data-target="#deleteSectionModal"><span class="glyphicon glyphicon-trash"></span> Delete</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Delete Section Modal Statr-->
	<div class="modal fade" id="deleteSectionModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Section</h4>					
				</div>
				<div class="modal-body">
					<p>Are you sure to delete Section {{selectedSectionName}} ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" v-on:click="deleteSection(selectedSection)">Delete</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>					
				</div>
			</div>
		</div>
	</div>
	<!-- Delete Section Modal end -->

	<!--Update Section Modal Start-->
	<div class="modal fade" id="updateSectionModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="#" v-on:submit.prevent="editSection">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Update Section</h4>
					</div>

					<div class="modal-body">

						<div v-bind:class="{'has-error':errors.has('updateSection')}">
							<label for="updateSection">Update Section</label>
							<input v-validate="'required'" v-model="updateSection" type="text" name="updateSection" class="form-control" id="updateSection" />
							<span v-show="errors.has('updateSection')" class="text-danger">{{ errors.first('updateSection') }}</span>
	 					</div><br/>
						<div>
							<label for="updateTeacher">Update Teacher</label>
							<input v-model="updateTeacher" type="text" name="updateTeacher" class="form-control" id="updateTeacher" />
	 					</div><br/>	
	 					<div>
							<div v-if="updateStudentMessage.show" class="alert" v-bind:class="updateStudentMessage.alertType">
								<strong>{{updateStudentMessage.messageType}}</strong> {{updateStudentMessage.message}}
							</div>
	 					</div>			

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-info" v-on:click="editSection">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
	<!--Update Section Modal End-->
</div>
<script>
	Vue.use(VeeValidate);
	var apiURL = '<?php echo base_url(); ?>';
	var grade = '<?php echo $gradeId; ?>';
	var app = new Vue({
		el:"#app",
		data:{
			selectedSection:'',
			selectedSectionName:'',
			section:'',
			teacher:'',
			allSection:[],
			addStudentMessage:{
				show:false,
				message:'',
				alertType:'',
				messageType:''
			},
			updateSection:'',
			updateTeacher:'',
			updateId:'',
			updateStudentMessage:{
				show:false,
				message:'',
				alertType:'',
				messageType:''
			}
		},

		created(){
			this.getAllSection();
		},

		methods:{
			insertSection: function(){
				var vm = this;
				vm.hideMessage(vm.addStudentMessage);
				this.$validator.validate("section",this.section).then(function(isValid){
					if(isValid){
						vm.showMessage(vm.addStudentMessage,'','alert-info','Loading');
						var url = apiURL+'home/addSection';
						var params = new URLSearchParams();
						params.append('section',vm.section);
						params.append('teacher',vm.teacher);
						params.append('gradeId',grade);
						axios.post(url,params.a()).then(function(response){
							if(response.data.status == 'success'){
								vm.showMessage(vm.addStudentMessage,response.data.message,'alert-success','Success');
								vm.getAllSection();
							}else{
								vm.showMessage(vm.addStudentMessage,response.data.message,'alert-danger','Error');
							}							
						}).catch(function(error){
							vm.showMessage(vm.addStudentMessage,error.message,'alert-danger','Error')
							console.log(error);
						})						
					}
				})	
			},

			showMessage: function(messageObj, message, alertType, messageType){
				messageObj.show = true;
				messageObj.message = message;
				messageObj.alertType = alertType;
				messageObj.messageType = messageType;
			},

			hideMessage: function(messageObj){
				messageObj.show = false;
				messageObj.message = '';
				messageObj.alertType = '';
				messageObj.messageType = '';				
			},

			getAllSection: function(){
				var vm = this;
				var url = apiURL+'home/getAllSection/'+grade;
				axios.get(url).then(function(response){
					vm.allSection = response.data;
				}).catch(function(error){
					console.log(error);
				})	
			},

			editSection: function(){
				var vm = this;
				vm.hideMessage(vm.updateStudentMessage);
				var url = apiURL+"home/editSection";
				var params = new URLSearchParams();
				params.append('id',vm.updateId);
				params.append("gradeId",grade);
				params.append("section",vm.updateSection);
				params.append("teacher",vm.updateTeacher);
				this.$validator.validate('updateSection',this.updateSection).then(function(isValid){
					if(isValid){
						vm.showMessage(vm.updateStudentMessage,'','alert-info','Loading');
						axios.post(url,params.a()).then(function(response){
							if(response.data.status=="success"){
								vm.showMessage(vm.addStudentMessage, response.data.message, 'alert-success', 'Success');
								vm.getAllSection();
								$('#updateSectionModal').modal("hide");
							}else{
								vm.showMessage(vm.updateStudentMessage,response.data.message, 'alert-danger', 'Error');
							}
						}).catch(function(error){
							console.log(error);
							vm.showMessage(vm.updateStudentMessage, error.message, 'alert-danger','Error');
						})

						$('#updateSectionModal').on('hide.bs.modal',function(){
							vm.hideMessage(vm.updateStudentMessage);
						})

					}
				})
			},

			deleteSection: function(id){
				var vm = this;
				var url = apiURL+"home/deleteSection/"+id;
				vm.showMessage(vm.addStudentMessage,'','alert-info','Loading');	
				$("#deleteSectionModal").modal("hide");
				axios.get(url).then(function(response){
					if(response.data.status=="success"){
						vm.showMessage(vm.addStudentMessage, response.data.message, 'alert-success', 'Success');
						vm.getAllSection();
					}else{
						vm.showMessage(vm.addStudentMessage,response.data.message, 'alert-danger', 'Error');
					}					
				}).catch(function(error){
					console.log(error);
					vm.showMessage(vm.addStudentMessage,error.message, 'alert-danger', 'Error');					
				});
			},

			manageSection: function(sectionId){
				location.replace(apiURL+'home/manageSection/'+sectionId);
			},

			back: function(){
				location.replace(apiURL+'home/manageclass');
			}
		}
	});
	setInterval(function(){app.getAllSection();},10000);
</script>
		<div id="app">

			<div class="container">
				<div class="main-content">
					<div class="panel panel-info addstudent">
						<div class="panel-heading">Update Student</div>
						<div class="panel-body">
							<form v-on:submit.prevent="updateStudent" action="#" id="myForm">
								<div class="row">
									<div class="col-md-6">
										<div v-bind:class="{'form-group':true,'has-error':errors.has('studentId')}">
											<label for="studentId">Student ID</label>
											<input type="text" v-validate="'required|numeric'" v-model="studentInfo.STUDENT_ID" class="form-control" id="studentId" name="studentId"/>
											<span v-show="errors.has('studentId')" class="text-danger">{{ errors.first('studentId') }}</span>
										</div>
										<div v-bind:class="{'form-group':true,'has-error':errors.has('firstname')}">
											<label for="fName">First Name</label>
											<input type="text" v-validate="'required'" v-model="studentInfo.FIRSTNAME" class="form-control" id="fName" name="firstname"/>
											<span v-show="errors.has('firstname')" class="text-danger">{{ errors.first('firstname') }}</span>
										</div>										
										<div v-bind:class="{'form-group':true,'has-error':errors.has('middlename')}">
											<label for="mName">Middle Name</label>
											<input type="text" v-validate="'required'" v-model="studentInfo.MIDDLENAME" class="form-control" id="mName" name="middlename"/>
											<span v-show="errors.has('middlename')" class="text-danger">{{ errors.first('middlename') }}</span>
										</div>
										<div v-bind:class="{'form-group':true,'has-error':errors.has('lastname')}">
											<label for="lName">Last Name</label>
											<input type="text" v-validate="'required'" v-model="studentInfo.LASTNAME" class="form-control" id="lName" name="lastname"/>
											<span v-show="errors.has('lastname')" class="text-danger">{{ errors.first('lastname') }}</span>
										</div>										
									</div>
									<div class="col-md-6">
										<div v-bind:class="{'form-group':true,'has-error':errors.has('birthday')}">
											<label for="bDay">Birthday</label>
											<input type="date" class="form-control" v-model="studentInfo.BIRTHDAY" v-validate="'date_format:YYYY-MM-DD|required'"  style="padding:0px 6px" id="bDay" name="birthday"/>
											<span v-show="errors.has('birthday')" class="text-danger">{{ errors.first('birthday') }}</span>
										</div>
										<div v-bind:class="{'form-group':true,'has-error':errors.has('address')}">
											<label for="address">Address</label>
											<input type="text" v-validate="'required'" v-model="studentInfo.ADDRESS" class="form-control" id="address" name="address">
											<span v-show="errors.has('address')" class="text-danger">{{errors.first('address')}}</span>
										</div>
										<div class="form-group">
											<label for="Male">Gender</label><br/>
											<select class="form-control" v-model="studentInfo.GENDER">
												<option>MALE</option>
												<option>FEMALE</option>
											</select>
										</div><br/>
										<div v-if="showmessage" class="alert" v-bind:class="alerttype">
											<strong>{{messageType}}</strong> {{message}}
										</div>
										<div class="btn-group btn-group-justified">
											<div class="btn-group"><button type="submit" class="btn btn-info">Save</button></div>
											<div class="btn-group"><button type="button" class="btn btn-info" v-on:click="enrollStudent()">Enroll</button></div>
											<div class="btn-group"><button type="button" class="btn btn-info" v-on:click="back()">Back</button></div>
										</div>
									</div>															
								</div>
							</form>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo base_url();?>include/js/moment.js"></script>
		<script>
			var apiURL = '<?php echo base_url();?>';
			Vue.use(VeeValidate);
			var app = new Vue({
				el:"#app",
				data:{
					id:<?php echo $id;?>,
					oldId:<?php echo $oldId;?>,
					studentInfo:<?php echo $studentInfo;?>,
					showmessage:false,
					alerttype:'',
					messageType:'',
					message:''
				},
				methods:{
					updateStudent: function(){
						var vm = this;

						//url
						var url = apiURL+'home/editStudent/'+vm.id;
						var params = new URLSearchParams();
						params.append("id",vm.studentInfo.STUDENT_ID);
						params.append("fname",vm.studentInfo.FIRSTNAME);
						params.append("mname",vm.studentInfo.MIDDLENAME);
						params.append("lname",vm.studentInfo.LASTNAME);
						params.append("bday",vm.studentInfo.BIRTHDAY);
						params.append("addr",vm.studentInfo.ADDRESS);
						params.append("gender",vm.studentInfo.GENDER);
						params.append("oldId",vm.oldId);

						this.$validator.validateAll().then(function(isValid){
							if(isValid){

								//Loading
								vm.showmessage = true;
								vm.alerttype = "alert-info";
								vm.messageType = "Loading...";
								vm.message = "";

								axios.post(url,params.a()).then(function(response){
									if(response.data.status == "success"){
										vm.alerttype = "alert-success";
										vm.messageType = "Success";
										vm.message = response.data.message;
										vm.oldId = vm.studentInfo.STUDENT_ID;
									}else{
										vm.alerttype = "alert-danger";
										vm.messageType = "Failed";
										vm.message = response.data.message;										
									}
								}).catch(function(error){
									vm.alerttype = "alert-danger";
									vm.messageType = "Error";
									vm.message = error.message;	
									console.log(error);								
								})
							}
						})
					},

					enrollStudent: function(){
						location.replace(apiURL+'home/enrollStudent/'+this.id);
					},

					back: function(){
						history.back();
					}
				}
			})
		</script>


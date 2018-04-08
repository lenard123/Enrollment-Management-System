		<div id="app">
		
			<div class="container">
				<div class="main-content">
					<div class="panel panel-info addstudent">
						<div class="panel-heading">Add Student</div>
						<div class="panel-body">
							<form v-on:submit.prevent="insertStudent" action="#">
								<div class="row">
									<div class="col-md-6">
										<div v-bind:class="{'form-group':true,'has-error':errors.has('studentId')}">
											<label for="studentId">Student ID</label>
											<input type="text" v-validate="'required|numeric'" v-model="studentId" class="form-control" id="studentId" name="studentId"/>
											<span v-show="errors.has('studentId')" class="text-danger">{{ errors.first('studentId') }}</span>
										</div>
										<div v-bind:class="{'form-group':true,'has-error':errors.has('firstname')}">
											<label for="fName">First Name</label>
											<input type="text" v-validate="'required'" v-model="fname" class="form-control" id="fName" name="firstname"/>
											<span v-show="errors.has('firstname')" class="text-danger">{{ errors.first('firstname') }}</span>
										</div>										
										<div v-bind:class="{'form-group':true,'has-error':errors.has('middlename')}">
											<label for="mName">Middle Name</label>
											<input type="text" v-validate="'required'" v-model="mname" class="form-control" id="mName" name="middlename"/>
											<span v-show="errors.has('middlename')" class="text-danger">{{ errors.first('middlename') }}</span>
										</div>
										<div v-bind:class="{'form-group':true,'has-error':errors.has('lastname')}">
											<label for="lName">Last Name</label>
											<input type="text" v-validate="'required'" v-model="lname" class="form-control" id="lName" name="lastname"/>
											<span v-show="errors.has('lastname')" class="text-danger">{{ errors.first('lastname') }}</span>
										</div>										
									</div>
									<div class="col-md-6">
										<div v-bind:class="{'form-group':true,'has-error':errors.has('birthday')}">
											<label for="bDay">Birthday</label>
											<input type="date" class="form-control" v-model="bday" v-validate="'date_format:YYYY-MM-DD|required'"  style="padding:0px 6px" id="bDay" name="birthday"/>
											<span v-show="errors.has('birthday')" class="text-danger">{{ errors.first('birthday') }}</span>
										</div>
										<div v-bind:class="{'form-group':true,'has-error':errors.has('address')}">
											<label for="address">Address</label>
											<input type="text" v-validate="'required'" v-model="address" class="form-control" id="address" name="address">
											<span v-show="errors.has('address')" class="text-danger">{{errors.first('address')}}</span>
										</div>
										<div class="form-group">
											<label for="Male">Gender</label><br/>
											<select class="form-control" v-model="gender">
												<option>MALE</option>
												<option>FEMALE</option>
											</select>
										</div><br/>
										<div v-if="showmessage" class="alert" v-bind:class="alerttype">
											<strong>{{messageType}}</strong> {{message}}
										</div>
										<div class="btn-group btn-group-justified">
											<div class="btn-group"><button type="submit" class="btn btn-primary">Save</button></div>
											<div class="btn-group"><button type="reset" class="btn btn-default">Clear</button></div>
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
			var apiURL = '<?php echo base_url(); ?>';
			Vue.use(VeeValidate);
			var app = new Vue({
				el:'#app',
				data:{
					studentId:'',
					fname:'',
					mname:'',
					lname:'',
					bday:'',
					address:'',
					gender:'MALE',
					result:[],
					showmessage:false,
					alerttype:'',
					messageType:'',
					message:''
				},
				methods:{
					insertStudent: function(){
						var vm = this;
						var url;
						this.$validator.validateAll().then(function(isValid){
							if(isValid){
								vm.showmessages('alert-info','Loading','');
								url = apiURL+'home/insertStudent';
								var params = new URLSearchParams();
								params.append('id',vm.studentId);
								params.append('fname',vm.fname);
								params.append('mname',vm.mname);
								params.append('lname',vm.lname);
								params.append('bday',vm.bday);
								params.append('address',vm.address);
								params.append('gender',vm.gender);
								axios.post(url,params.a())
								.then(function(response){
									vm.result = response.data;
									if(response.data[0].status == 'success'){
										vm.showmessages('alert-success','Success',response.data[0].message);
									}else{
										vm.showmessages('alert-danger','Error',response.data[0].message);
									}
								})
								.catch(function(error){
									console.log(error)
								})
							}
						})
					},

					showmessages: function(alerttype, messageType, message){
						this.showmessage = true;
						this.alerttype = alerttype;
						this.messageType = messageType;
						this.message = message;
					}
				}
			})
		</script>
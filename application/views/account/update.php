<div id="app">
	<div class="container">
		<div class="main-content">
			<div class="panel panel-info addstudent">
				<div class="panel-heading">Update Account</div>
				<div class="panel-body">
					<form action="#">
						<div v-bind:class="{'form-group':true,'has-error':errors.has('username')}">
							<label for="username">Username</label>
							<input type="text" v-validate="'required'" v-model="admin_info.USERNAME" class="form-control" id="username" name="username"/>
							<span v-show="errors.has('username')" class="text-danger">{{ errors.first('username') }}</span>
						</div>
						<div v-bind:class="{'form-group':true,'has-error':errors.has('firstname')}">
							<label for="firstname">Firstname</label>
							<input type="text" v-validate="'required'" v-model="admin_info.FIRSTNAME" class="form-control" id="firstname" name="firstname"/>
							<span v-show="errors.has('firstname')" class="text-danger">{{ errors.first('firstname') }}</span>
						</div>	
						<div v-bind:class="{'form-group':true,'has-error':errors.has('lastname')}">
							<label for="lastname">Lastname</label>
							<input type="text" v-validate="'required'" v-model="admin_info.LASTNAME" class="form-control" id="lastname" name="lastname"/>
							<span v-show="errors.has('lastname')" class="text-danger">{{ errors.first('lastname') }}</span>
						</div>	
						<div class="form-group">
							<label for="Male">Gender</label><br/>
							<select class="form-control" v-model="admin_info.GENDER">
								<option>MALE</option>
								<option>FEMALE</option>
							</select>
						</div><br/>
						<div v-if="message.showmessage" class="alert" v-bind:class="message.alerttype">
							<strong>{{message.messageType}}</strong> {{message.message}}
						</div>		
						<div class="btn-group btn-group-justified">
							<div class="btn-group"><button type="button" class="btn btn-primary" v-on:click="save()">Save</button></div>
							<div class="btn-group"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#change_password_modal">Change Password</button></div>
						</div>												
					</form>
				</div>
			</div>
		</div>
	</div>
</div>	
<div class="modal fade" id="change_password_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Password</h4>	
			</div>
			<div class="modal-body">
				<form action="#">
					<div v-bind:class="{'form-group':true,'has-error':errors.has('oldpassword')}">
						<label for="oldpassword">Old Password</label>
						<input type="Password" v-validate="'required'" v-model="admin_info.oldpassword" class="form-control" id="oldpassword" name="oldpassword"/>
						<span v-show="errors.has('oldpassword')" class="text-danger">{{ errors.first('oldpassword') }}</span>
					</div>
					<div v-bind:class="{'form-group':true,'has-error':errors.has('newpassword')}">
						<label for="newpassword">New Password</label>
						<input type="Password" v-validate="'required'" v-model="admin_info.newpassword" class="form-control" id="newpassword" name="newpassword"/>
						<span v-show="errors.has('newpassword')" class="text-danger">{{ errors.first('newpassword') }}</span>
					</div>
					<div v-bind:class="{'form-group':true,'has-error':errors.has('confirmpassword')}">
						<label for="confirmpassword">Confirm Password</label>
						<input type="Password" v-validate="'required'" v-model="admin_info.confirmpassword" class="form-control" id="confirmpassword" name="confirmpassword"/>
						<span v-show="errors.has('confirmpassword')" class="text-danger">{{ errors.first('confirmpassword') }}</span>
					</div>
					<span class="text-danger" v-if="not_match">Password not match</span>
					<br/>
					<div v-if="message.showmessage" class="alert" v-bind:class="message.alerttype">
						<strong>{{message.messageType}}</strong> {{message.message}}
					</div>									
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" v-on:click="save()">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>	
<script>
	var apiURL = '<?php echo base_url(); ?>';
	Vue.use(VeeValidate);
	var app = new Vue({
		el: "#app",
		data:{
			message:{
				showmessage:false,
				alerttype:'',
				messageType:'',
				message:''
			},
			admin_info:<?php echo $admin_info; ?>
		},
		methods:{
			showmessages: function(alerttype, messageType, message){
				this.message.showmessage = true;
				this.message.alerttype = alerttype;
				this.message.messageType = messageType;
				this.message.message = message;
			},
			save: function(){
				var vm = this;
				var url;
				vm.$validator.validateAll().then(function(isValid){
					if(isValid){
						vm.showmessages('alert-info','Loading...','');
						url = apiURL+'account/updateAccount/?submit';
						var params = new URLSearchParams();
						params.append('username',vm.admin_info.USERNAME);
						params.append('firstname',vm.admin_info.FIRSTNAME);
						params.append('lastname',vm.admin_info.LASTNAME);
						params.append('gender',vm.admin_info.GENDER);
						axios.post(url,params.a())
								.then(function(response){
									if(response.data.status == 'success'){
										vm.showmessages('alert-success','Success',response.data.message);
									}else{
										vm.showmessages('alert-danger','Error',response.data.message);
									}
								})
								.catch(function(error){
									console.log(error)
								})
					}
				})	
			}
		}
	});
	var update_modal = new Vue({
		el: '#change_password_modal',
		data:{
			not_match:false,
			message:{
				showmessage:false,
				alerttype:'',
				messageType:'',
				message:''
			},
			admin_info:{
				oldpassword:'',
				newpassword:'',
				confirmpassword:''
			}
		},
		methods:{
			showmessages: function(alerttype, messageType, message){
				this.message.showmessage = true;
				this.message.alerttype = alerttype;
				this.message.messageType = messageType;
				this.message.message = message;
			},
			save: function(){
				var vm = this;
				var url;
				vm.$validator.validateAll().then(function(isValid){
					if(isValid){
						if(vm.admin_info.newpassword != vm.admin_info.confirmpassword){
							vm.not_match = true;
						}else{
							vm.not_match = false;
							vm.showmessages('alert-info','Loading...','');
							url = apiURL+'account/updateAccount/?submitpassword';
							var params = new URLSearchParams();
							params.append('oldpassword',vm.admin_info.oldpassword);
							params.append('newpassword',vm.admin_info.newpassword);
							axios.post(url,params)
								.then(function(response){
									if(response.data.status == 'success'){
										vm.showmessages('alert-success','Success',response.data.message);
									}else{
										vm.showmessages('alert-danger','Failed',response.data.message);
									}
								})
								.catch(function(error){
									console.log(error)
								})
						}
					}
				})	
			}

		}
	})
	setInterval(function(){
		app.$data.message.showmessage=false;
		update_modal.$data.message.showmessage=false;
	},10000);
</script>
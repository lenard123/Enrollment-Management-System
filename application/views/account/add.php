<div id="app">
	<div class="container">
		<div class="main-content">
			<div class="panel panel-info addstudent">
				<div class="panel-heading">Add Admin</div>
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
						</div>
						<div v-bind:class="{'form-group':true,'has-error':errors.has('password')}">
							<label for="password">Password</label>
							<input type="Password" v-validate="'required'" v-model="admin_info.PASSWORD" class="form-control" id="password" name="password"/>
							<span v-show="errors.has('password')" class="text-danger">{{ errors.first('password') }}</span>
						</div>
						<br/>
						<div v-if="message.showmessage" class="alert" v-bind:class="message.alerttype">
							<strong>{{message.messageType}}</strong> {{message.message}}
						</div>
						<div class="btn-group btn-group-justified">
							<div class="btn-group"><button type="button" class="btn btn-primary" v-on:click="submit()">Submit</button></div>
							<div class="btn-group"><button type="reset" class="btn btn-default">Clear</button></div>
						</div>
					</form>
				</div>
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
			admin_info:{
				USERNAME:'',
				FIRSTNAME:'',
				LASTNAME:'',
				GENDER:'MALE',
				PASSWORD:''
			},
			message:{
				showmessage:false,
				alerttype:'',
				messageType:'',
				message:''
			}
		},
		methods:{
			submit: function(){
				var vm = this;
				var url = apiURL+'account/addAccount?submit';
				this.$validator.validateAll().then(function(isValid){
					if(isValid){
						vm.showmessages('alert-info','Loading...','');
						var params = new URLSearchParams();
						params.append('username', vm.admin_info.USERNAME);
						params.append('firstname', vm.admin_info.FIRSTNAME);
						params.append('lastname', vm.admin_info.LASTNAME);
						params.append('gender', vm.admin_info.GENDER);
						params.append('password', vm.admin_info.PASSWORD);
						axios.post(url, params.a()).then
							(
								function(response){
									if(response.data.status == "success"){
										vm.showmessages('alert-success','Success', response.data.message);
									}else{
										vm.showmessages('alert-danger','Failed', response.data.message);
									}
								}
							).catch
							(
								function(error){
									console.log(error);
								}
							)
					}
				})
			},

			showmessages: function(alerttype,messageType,message){
				this.message.showmessage = true;
				this.message.alerttype = alerttype;
				this.message.messageType = messageType;
				this.message.message = message;
			}
		}
	})
	setInterval(function(){
		app.$data.message.showmessage = false;
	},10000)
</script>
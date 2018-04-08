<!DOCTYPE html>
<html>
	<head>
		<title>EMS - Login</title>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1"> 
		<meta name="description" content="Enrollment Management System">		
		<meta name="keywords" content="Enrollment,Management,System">		
		<meta name="author" content="Lenard Mangay-ayam">
		
		<script src="<?php echo base_url();?>include/js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>include/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>include/js/vue.min.js"></script>
		<script src="<?php echo base_url();?>include/js/vee-validate.min.js"></script>
		<script src="<?php echo base_url();?>include/js/axios.min.js"></script>
		<script src="<?php echo base_url();?>include/js/index.js"></script>

		<link rel="stylesheet" href="<?php echo base_url();?>include/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>include/css/index.css" />
		<style>
			.has-error{
				border-color: #a94442;
				box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
			}

			.loading{
				text-align: left;
			}
		</style>
		<script>
		$(document).ready(function(){
			//$('#submit').click(function(){
    		$('[data-toggle="popover"]').popover();
			//})
		});
		</script>
	</head>

	<body>
		<center>
			<div class="container login" id="app">
				<span class="title"><b>Welcome</b></span><br/>
				<span class="title">Enrollment Management System</span><br/><br/><br/>
				 <div v-if="showmessage" class="alert loading" v-bind:class="alerttype">
					<strong>{{message}}</strong>
				 </div>
				 <form v-on:submit.prevent="validateBeforeSubmit" action="#" id="itemform">
				  <div class="input-group" id="email-group" v-bind:class="{'has-error':errors.has('user')}">
				    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				    <input id="email" type="text" v-validate="'required'" v-model="username" class="form-control" name="user" placeholder="Username" data-toggle="popover" data-placement="right" data-trigger="hover" v-bind:data-content="errors.first('user')"  />
				  </div>
				  <div class="input-group" v-bind:class="{'has-error':errors.has('password')}">
				    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				    <input id="password" type="password" v-validate="'required'" v-model="password" class="form-control" name="password" placeholder="Password" data-toggle="popover" data-placement="right" data-trigger="hover" v-bind:data-content="errors.first('password')">
				  </div><br/>
				  <input type="submit" id="submit" name="" class="btn btn-primary" value="SUBMIT" />
				</form> 
			</div>
		</center>

		<script>
		    Vue.use(VeeValidate);

		    var apiURL = '<?php echo base_url(); ?>';
		    var app = new Vue(
		    {
		    	el:'#app',

		    	data:{
		    		showmessage:false,
		    		alerttype: 'alert-info',
		    		username:'',
		    		password:'',
		    		message:''
		    	},

		    	methods: {
		    		validateBeforeSubmit : function()
		    		{
		    			var vm = this;
		    			var url;
                		this.$validator.validateAll().then(function(isValid) {
                    		if(isValid){
                    			url = apiURL+'/login/checkData/';

                    			vm.showmessages('alert-info','Loading...');
                    			var params = new URLSearchParams();
                    			params.append('user',vm.username);
                    			params.append('pass',vm.password);
                    			//var params = "user="+escape(vm.username)+"&pass="+escape(vm.password);
                    			axios.post(url,params.a())
                    			.then(function(response){
                    				console.log(response.data);
                    				if(response.data=='1'){
                    					vm.showmessages('alert-success','Successfully login');
                    					location.replace(apiURL+'home');
                    				}else{
                    					vm.showmessages('alert-danger','Invalid user or password');
                    				}
                    			})
                    			.catch(function(error){
                    				console.log(error);
                    				vm.showmessages('alert-danger','Error occured');
                    			})
                    		}    			
		    			});
		    		},

		    		showmessages: function(alerttype,message){
		    			this.showmessage = true;
		    			this.alerttype = alerttype;
		    			this.message = message;
		    		}
		    	}
		    });		
		</script>

	</body>
</html>
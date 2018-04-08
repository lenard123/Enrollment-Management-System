 <div id="app">
 	<div class="container">
 		<div class="main-content">
 			<div class="panel panel-info addstudent">
 				<div class="panel-heading">Manage Admin</div>
 				<div class="panel-body" style="padding:0px">
 					<div class="table-responsive">
 						<table class="table table-striped table-hover">
 							<thead>
 								<tr>
 									<th>Username</th>
 									<th>Name</th>
 									<th>Delete</th>
 								</tr>
 							</thead>
 							<tbody>
 								<tr v-for="admin in allAdmin" v-if="admin.ID!=1">
 									<td>{{admin.USERNAME}}</td>
 									<td>{{admin.FIRSTNAME}} {{admin.LASTNAME}}</td>
 									<td data-toggle="modal" data-target="#delete_admin_modal" v-on:click="selected_admin=admin.ID"><span class="glyphicon glyphicon-trash"></span> Delete</td>
 								</tr>
 							</tbody>
 						</table>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 	<div id="delete_admin_modal" class="modal fade" role="dialog">
 		<div class="modal-dialog">
 			<div class="modal-content">
 				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Admin</h4> 
				</div>
				<div class="modal-body">
					<p>For Security Reason, Enter your password</p>
					<div class="form-group">
						<input type="text" v-model="password" class="form-control" placeholder="password" />
					</div>	
					<div v-if="message.showmessage" class="alert" v-bind:class="message.alerttype">
						<strong>{{message.messageType}}</strong> {{message.message}}
					</div>					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger" v-on:click="submit()">Delete</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>					
				</div>
			</div>
		</div>
	</div>				
 </div>
 <script>
 	var apiURL = '<?php echo base_url(); ?>';
 	var app = new Vue({
 		el: '#app',
 		data:{
 			allAdmin: <?php echo $allAdmin; ?>,
 			password:'',
 			selected_admin:'',
			message:{
				showmessage:false,
				alerttype:'',
				messageType:'',
				message:''
			}
 		},
 		methods:{
 			refresh: function(){
 				var vm = this;
 				var url = apiURL+'account/manageAccount?getAllAdmin';
 				axios.get(url).then(function(response){
 					vm.allAdmin = response.data;
 				})
 			},
 			submit: function(){
 				var vm = this;
 				var url = apiURL +'account/manageAccount?delete&id='+vm.selected_admin+'&password='+vm.password;
 				this.showmessages('alert-info','Loading...','');
 				axios.get(url).then(function(response){
 					if(response.data.status == 'success'){
 						vm.refresh();
 						vm.showmessages('alert-success','success',response.data.message);
 					}else{
 						vm.showmessages('alert-danger','Error',response.data.message);
 					}
 				}).catch(function(err){
 					console.log(err);
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
 		app.refresh();
 	}, 10000)
 </script>
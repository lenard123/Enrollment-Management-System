<div id="app">

	<div class="container">
		<div class="main-content">
			<div class="manageclass">
				<form action="#" v-on:submit.prevent="insertGrade">
					<label for="grade">Add Grade</label>
					<div class="input-group" v-bind:class="{'has-error':errors.has('grade')}">
						<input type="text" class="form-control" id="grade" v-validate="'required'" v-model="grade" name="grade" />
						<div class="input-group-btn">
							<button type="submit" class="btn btn-default">Submit</button>
						</div>
					</div>
					<div v-if="showmessage" class="alert" v-bind:class="alerttype">
						<strong>{{messageType}}</strong> {{message}}
					</div>				
				</form><br/>
				<small>Click the Grade to View the Sections</small>
				<div class="panel panel-info addstudent">
					<div class="panel-heading">Manage Grade</div>
					<div class="panel-body" style="padding:0px">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Grade</th>
										<th>Edit</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="grade in allGrade">
										<td v-on:click="manageGrade(grade.ID)">{{grade.GRADE}}</td>
										<td data-toggle="modal" data-target="#editGradeModal" v-on:click="selectedGrade=grade.GRADE;newGrade=grade.GRADE"><span class="glyphicon glyphicon-pencil"></span> Edit</td>
										<td data-toggle="modal" data-target="#deleteGradeModal" v-on:click="selectedGrade=grade.GRADE;selectedGradeId=grade.ID"><span class="glyphicon glyphicon-trash"></span> Delete</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Delete Grade Modal Start -->
	<div class="modal fade" id="deleteGradeModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Grade {{selectedGrade}} ?</h4>
				</div>

				<div class="modal-body">
					<p>Are you sure to delete Grade {{selectedGrade}} ?<br/>
					Deleting a grade will also delete all the sections associated with it.</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" v-on:click="deleteGrade(selectedGradeId)">Delete</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>

			</div>
		</div>
	</div>
	<!-- Delete Grade Modal End -->

	<!-- Edit Grade Modal Start -->
	<div class="modal fade" id="editGradeModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="#" v-on:submit.prevent="editGrade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Edit Grade</h4>
					</div>

					<div class="modal-body">
						
						<div class="input-group" v-bind:class="{'has-error':errors.has('newGrade')}">
							<span class="input-group-addon">Edit Grade</span>
							<input type="text" class="form-control" id="editGrade" v-validate="'required'" v-model="newGrade" name="newGrade" />
						</div>
						<div v-if="showMessageEditGrade" class="alert" v-bind:class="alertTypeEditGrade">
							<strong>{{messageTypeEditGrade}}</strong> {{messageEditGrade}}
						</div>				

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-info">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit Grade Modal End -->
</div>
<script>
	var apiURL = '<?php echo base_url();?>';
	Vue.use(VeeValidate);
	var app = new Vue({
		el:'#app',
		data:{
			grade:'',
			showmessage:false,
			alerttype:'',
			messageType:'',
			message:'',
			allGrade:[],
			selectedGrade:'',
			selectedGradeId:'',
			newGrade:'',			
			newGrade:'',
			showMessageEditGrade:false,
			alertTypeEditGrade:'',
			messageEditGrade:''
		},
		created(){
			this.getAllGrade();
		},
		methods:{
			insertGrade: function(){
				var vm = this;
				var url;
				this.showmessage =false;
				this.$validator.validate('grade',this.grade).then(function(isValid){
					if(isValid){
						vm.showmessages('alert-info', 'Loading','');
						url = apiURL+'home/addGrade';
						var params = new URLSearchParams();
						params.append('grade',vm.grade);
						axios.post(url,params.a())
						.then(function(response){
							if(response.data.status == 'success'){
								vm.showmessages('alert-success','Success',response.data.message);
								vm.getAllGrade();
							}else{
								vm.showmessages('alert-danger','Error',response.data.message);
							}							
						})
						.catch(function(error){
							console.log(error);
						})
					}
				})					
			},

			showmessages: function(alerttype, messageType, message){
				this.showmessage = true;
				this.alerttype = alerttype;
				this.messageType = messageType;
				this.message = message;
			},

			showMessagesEditGrade: function(alerttype, messageType, message){
				this.showMessageEditGrade = true;
				this.alertTypeEditGrade = alerttype;
				this.messageTypeEditGrade = messageType;
				this.messageEditGrade = message;
			},

			getAllGrade: function(){
				var vm = this;
				var url = apiURL+'home/getAllGrade';
				axios.get(url).then(function(response){
					vm.allGrade = response.data;
				}).catch(function(error){
					console.log(error);
				})
			},

			deleteGrade: function(grade){
				var vm = this;
				var url = apiURL+'home/deleteGrade/'+grade;
				axios.get(url).then(function(response){
					if(response.data.status=="success"){
						vm.showmessages('alert-success', 'Success', response.data.message);
						vm.getAllGrade();
						$("#deleteGradeModal").modal("hide");
					}else{
						vm.showmessages('alert-danger', 'failed', response.data.message);
					}
				}).catch(function(error){
					console.log(error);
				})
			},

			editGrade: function(){
				var vm = this;
				var url = apiURL+'home/editGrade/'+this.selectedGrade+'/'+this.newGrade;
				this.showMessageEditGrade = false;
				this.$validator.validate('newGrade',this.newGrade).then(function(isValid)
				{
					if(isValid)
					{
						vm.showMessagesEditGrade('alert-info','Loading','');
						axios.get(url)

						.then(function(response)
						{
							if(response.data.status == "success")
							{
								vm.showmessages('alert-success', 'Success', response.data.message);
								vm.getAllGrade();
								$("#editGradeModal").modal("hide");
							}else
							{
								vm.showMessagesEditGrade('alert-danger', 'Error', response.data.message);
							}

							$("#editGradeModal").on('hide.bs.modal',function()
							{
								vm.showMessageEditGrade = false;
							});

						})

						.catch(function(error){
							console.log(error);
						})
					}
				})
			},

			manageGrade: function(gradeId){
				var url = apiURL+'home/managegrade/'+gradeId;
				location.replace(url);
			}
		}
	});
	setInterval(function(){app.getAllGrade();},10000);
</script>
<div id="app">

	<div class="container">
		<div class="main-content">
			<div class="manageclass">
				<div class="panel panel-info addstudent">
					<div class="panel-heading">
						<table style="width: 100%">
							<tr>
								<td>Manage Section</td>
								<td style="text-align:right"><button class="btn btn-default" v-on:click="back()">Back</button></td>
							</tr>
						</table>
					</div>
					<div class="panel-body">
						<strong>Grade: </strong>{{section_info.GRADE}}<br/>
						<strong>Section: </strong>{{section_info.SECTION}}<br/>
						<strong>Teacher: </strong>{{section_info.TEACHER}}<br/>
						<strong>Students:</strong><br/>
						<div class="panel panel-info addstudent">
							<div class="panel-body" style="padding:0px">
								<div class="table-responsive">
									<table class="table table-strife table-hover">
										<thead>
											<tr>
												<th>Student Id</th>
												<th>Name</th>
												<th>Age</th>
												<th>Gender</th>
												<th>Update</th>
												<th>Delete</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="student in students">
												<td>{{student.STUDENT_ID}}</td>
												<td>{{student.NAME}}</td>
												<td>{{getAge(student.BIRTHDAY)}} old</td>
												<td>{{student.GENDER}}</td>
												<td><span v-on:click="update(student.ID)">Update</span></td>	
												<td><span data-toggle="modal" data-target="#delete_student_modal" v-on:click="selected_student=student.ID">Delete</span></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="delete_student_modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Delete Student?</h4>
					</div>

					<div class="modal-body">
						<p>Are you sure to sure to remove this student?<br/>
						this student will just be moved into the pendings students.</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" v-on:click="deleteStudent()">Delete</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
			</div>
		</div>
	</div>

</div>



<script type="text/javascript" src="<?php echo base_url();?>include/js/moment.js"></script>
<script>
	var apiURL = '<?php echo base_url();?>';
	var app = new Vue({
		el: '#app',
		data:{
			section_id:<?php echo $section_id; ?>,
			selected_student:'',
			section_info: <?php echo $section_info; ?>,
			students: <?php echo $students; ?>
		},
		methods: {
			getAge: function(birthday){
				return moment(birthday,"YYYY-MM-DD").fromNow(true);
			},

			back: function(){
				location.replace(apiURL+'home/managegrade/'+this.section_info.ID);
			},

			deleteStudent: function(){
				var vm = this;
				var url = apiURL+'home/removeStudent/'+vm.selected_student;
				axios.get(url).then(function(response){
					if(response.data.status == "success"){
						vm.refresh();
					}else{
						alert('Error occured');
					}
					$('#delete_student_modal').modal("hide");
				}).catch(function(error){
					console.log(error);
				})
			},

			update: function(id){
				location.href = (apiURL+'home/updatestudent/'+id);
			},

			refresh: function(){
				var vm = this;
				var url = apiURL+'home/manageSection/'+vm.section_id+'?view=false';
				axios.get(url).then(function(response){
					vm.students = response.data;
				})
			}
		}
	})
</script>
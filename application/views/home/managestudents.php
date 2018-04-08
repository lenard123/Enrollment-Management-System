<div id="app">

	<div class="container">
		<div class="main-content">
			<div class="manageclass">
				<div class="panel panel-info addstudent">
					<div class="panel-heading">Manage Student - <?php echo $view;?> {{page}}/{{totalPage}}</div>
					<div class="panel-body">
						<div class="student-list row" v-for="student in allStudent">
							<div class="col-md-6">
								<strong>{{student.FIRSTNAME}} {{student.LASTNAME}}</strong><br/>
								<span>GENDER : {{student.GENDER}}</span><br/>
								<span>AGE : {{getAge(student.BIRTHDAY)}} old</span>
							</div>
							<div class="col-md-3">
								<span>Student ID : {{student.ID}}</span><br/>
								<span>Status : {{getStatus(student.ISENROLL)}}</span><br/>
								<span>Add By : {{student.ADMIN}}</span>
							</div>
							<div class="col-md-3">
								<div class="dropdown">
									<button class="btn btn-default btn-option dropdown-toggle" data-toggle="dropdown">OPTION <span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="#" v-on:click="option(student.STUDENT_ID)">Update</a></li>
										<li><a href="#" v-on:click="selected_student=student.STUDENT_ID" data-toggle="modal" data-target="#delete_student_modal">Delete</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
							<?php echo $pagination; ?>
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
						<p>Are you sure to sure to delete this student?</p>
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
	var apiURL = "<?php echo base_url();?>";
	var view = "<?php echo $view1;?>";
	var app = new Vue({
		el: "#app",
		data: {
			selected_student:'',
			allStudent:[],
			page:<?php echo ($current_page/10)+1;?>,
			totalPage:<?php echo ceil($totalPage/10);?>
		},
		created(){
			this.getAllStudent();
		},
		methods: {
			getAge: function(birthday){
				return moment(birthday,"YYYY-MM-DD").fromNow(true);
			},
			getAllStudent: function(){
				var vm = this;
				var url = apiURL+"home/getStudent/"+view+"?page="+<?php echo $current_page; ?>;
				axios.get(url).then(function(response){
					vm.allStudent = response.data;
				}).catch(function(error){
					console.log(error);
				})
			},
			getStatus: function(Status){
				if(Status!=null){
					return "Enrolled";
				}else{
					return "Pending";
				}
			},
			option: function(id){
				location.href = (apiURL+'home/updatestudent/'+id);
			},
			deleteStudent: function(){
				var vm =this;
				var url = apiURL+'home/deleteStudent/'+vm.selected_student;
				axios.get(url).then(function(response){
					if(response.data.status == "success"){
						vm.getAllStudent();
					}else{
						alert('Error occured');
					}
					$('#delete_student_modal').modal("hide");
				}).catch(function(error){
					console.log(error);
				})
			}
		}
	})
</script>
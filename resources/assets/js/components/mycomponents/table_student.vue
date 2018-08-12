<template>
<div class="table-responsive">
	<table class="table table-hover table-striped">
		<thead>

			<th width="5%">ID</th>
			<th>Name</th>
			<th width="10%">Grade</th>
			<th width="10%">Age</th>
			<th style="width:110px">Phone</th>
			<th style="width:90px">Gender</th>
			<th style="width:80px">Edit</th>
			<th style="width:90px">Delete</th>

		</thead>
		<tbody>

			<tr v-if="loading">
				<td colspan="8">
					<center>Loading...<i class="fa fa-refresh fa-spin"></i></center>
				</td>
			</tr>

			<tr v-else-if="data.students.data.length < 1">
				<td colspan="8">No students</td>
			</tr>

			<tr v-else v-for="student in data.students.data">
				<td>{{ student.student_id }}</td>
				<td>{{ student.first_name + ' '+ student.last_name }}</td>
				<td>{{ getGrade(student.grade_id) }}</td>
				<td>{{ util.toAge(student.birthday) }}</td>
				<td>{{ student.phone }}</td>
				<td>{{ student.gender }}</td>
				<td @click="$router.push({name:'Edit Student', params:{id:student.id}})">
					<i class="fa fa-edit"></i> Edit
				</td>
				<td @click="id=student.id;util.showModal('#delete-student-modal')">
					<i class="fa fa-trash"></i> Delete
				</td>
			</tr>

		</tbody>
	</table>

	<center>
		<ul class="pagination">
			<li @click="prev()" :class="{'disabled':isFirstPage()}"><a>Prev</a></li>
			<router-link 
				tag="li"
				v-for="page in pages" 
				:key="page['pages']"
				:to="{query:{page:page['page']}}"
				:class="{'active':current_page==page['page']}"
				active-class=""
				exact>
				<a href="#">{{ page['page'] }}</a>
			</router-link>
			<li @click="next()" :class="{'disabled':isLastPage()}"><a>Next</a></li>
		</ul>
	</center>

	<modal id="delete-student-modal">
		<modal-header>Delete Student</modal-header>
		<modal-body>
			<h3>Are you sure to delete Student?</h3>
		</modal-body>
		<modal-footer>
			<button class="btn btn-danger" @click="deleteStudent()">Delete</button>
			<button class="btn btn-default" data-dismiss="modal">Cancel</button>
		</modal-footer>
	</modal>

</div>
</template>

<script>
export default{
	props: ['src', 'refresh'],
	data: function(){
		return {
			loading: false,
			id: 0
		}
	},
	created: function(){
		console.log(this)
		this.refreshStudent();
	},
	methods: {

		isLastPage: function () {
			return this.data.students.last_page == this.current_page || this.data.students.last_page == 0;
		},

		isFirstPage: function () {
			return this.current_page == 1;
		},

		prev: function () {
			if (this.isFirstPage()) return;
			this.current_page--;
		},

		next: function () {
			if (this.isLastPage()) return;
			this.current_page++;
		},

		deleteStudent: function(){
			this.util.hideModal('#delete-student-modal');
			let notif = this.util.notify('Deleting student', 'loading');
			let vm = this;
			axios.delete(this.data.API+'student/'+this.id)
				.then((response)=>{
					vm.util.showResult(response, 'success','axios', notif);
				})
				.catch((error)=>{
					vm.util.showResult(error, 'error','axios', notif);
				})
		},

		refreshStudent: function(){
			let vm = this;
			vm.loading = true;
			axios.get(this.src+'?page='+this.current_page)
				.then((response)=>{
					vm.loading = false;
					vm.data.students = response.data.student;
					vm.data.grades = response.data.grade;
				})
				.catch((error)=>{
					vm.loading = false;
					vm.util.showResult(error, 'error');
				});	
		},

		getGrade: function (id) {
			let grades = this.data.grades;
			let grade = grades.find((grade)=>grade.id==id);
			return grade.name;
		}		
	},

	watch: {
		current_page : function(){
			this.refreshStudent();
		},

		src: function(){
			if (this.current_page == 1)
				this.refreshStudent();
			else
				this.current_page = 1;
		},

		refresh: function(){
			this.refreshStudent();
		}
	},	

	computed: {
		pages: function () {
			var pages = [];
			if (this.data.students.last_page)
			for (var i = 1; i <= this.data.students.last_page;i++) {
				let x = {};
				x['page'] = i;
				pages.push(x);
			}
			return pages;
		},

		current_page: {
			get: function () {
				return this.$route.query.page ? 
						this.$route.query.page : 
							this.data.students.current_page ? 
								this.data.students.current_page : 1;
			},

			set: function (val) {
				this.$router.push({query:{page:val}});
			}
		}
	}

}
</script>

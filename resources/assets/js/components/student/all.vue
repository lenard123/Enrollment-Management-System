<template>
<panel-default l-class="table-responsive">
	<h4>All Students</h4><hr/>

	<div class="form-group">
		<router-link :to="{name: 'Add Student'}" class="btn btn-success">
			<i class="fa fa-plus"></i> Add Student
		</router-link>

		<button class="btn btn-default" @click="refreshStudent()">
			<i class="fa fa-refresh"></i> Refresh Student
		</button>

	</div>

	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th width="5%">ID</th>
				<th>Name</th>
				<th width="10%">Grade</th>
				<th width="10%">Age</th>
				<th style="width:110px">Phone</th>
				<th style="width:90px">Gender</th>
				<th style="width:80px">Edit</th>
				<th style="width:90px">Delete</th>
			</tr>
		</thead>
		<tbody>
			<tr v-if="loading">
				<td colspan="8"><center>Loading...<i class="fa fa-refresh fa-spin"></i></center></td>
			</tr>
			<tr v-else-if="data.students.length < 1">
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
				<td><i class="fa fa-trash"></i> Delete</td>
			</tr>
		</tbody>
	</table>

	<center>
		<ul class="pagination" v-if="pages.length > 1">
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

</panel-default>
</template>

<script>
export default{
	data: function () {
		return {
			loading: false
		}
	},

	created: function () {
		if (this.$route.query.loading !== false)
			this.refreshStudent();
	},

	methods: {
		isLastPage: function () {
			return this.data.students.last_page == this.current_page;
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

		refreshStudent: function () {
			var vm = this;
			this.loading = true;
			axios.get(this.data.API+'student?page='+this.current_page)
				.then(response=>{
					console.log(response)
					this.loading = false;
					vm.data.students = response.data.student;
					vm.data.grades = response.data.grade;
				})
				.catch(error=>{
					this.loading = true;
					vm.util.showResult(error, 'error');
				})
		},

		getGrade: function (id) {
			let grades = this.data.grades;
			for (var i in grades)
				if (grades[i]['id'] == id)
					return grades[i]['name'];
			return '';
		}
	},

	watch: {
		current_page : function (){
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

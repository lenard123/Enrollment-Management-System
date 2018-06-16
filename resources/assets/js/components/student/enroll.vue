<template>
<panel-default>
	<div v-if="status=='loading'" class="jumbotron">
		<h1>Loading...<i class="fa fa-refresh fa-spin"></i></h1>
	</div>
	<div v-else-if="status=='error'" class="jumbotron">
		<h1><i class="fa fa-warning"></i> An error occured</h1>
	</div>
	<div v-else>
		<h4>Enroll Student</h4><hr/>
		<div class="panel panel-info">
		<div class="panel-heading">Student's Information</div>
		<div class="panel-body row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Name : </label> {{ full_name }}
				</div>
				<div class="form-group">
					<label>Grade : </label> {{ getGrade(student.grade_id) }}
				</div>
				<div class="form-group">
					<label>Student ID : </label> {{ student.student_id }}
				</div>
				<div class="form-group">
					<label>Address : </label> {{ student.address }}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Phone : </label> {{ student.phone }}
				</div>
				<div class="form-group">
					<label>Birthday : </label> {{ student.birthday }}
				</div>
				<div class="form-group">
					<label>Gender : </label> {{ student.gender }}
				</div>
			</div>
		</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">Enroll Student</div>
			<div class="panel-body">
				<form>
					<div class="form-group" v-if="grade_requirements.length > 0">
						<label for="requirements">Requirements</label><br/>
						<label class="checkbox-inline" v-for="requirement in grade_requirements">
							<input type="checkbox" name="requirements" :value="requirement.requirement_id">
								{{ getRequirement(requirement.requirement_id) }}
						</label>
					</div>
					<div class="form-group">
						<label for="section_id">Section</label>
						<select class="form-control">
							<option>---Select Section---</option>
							<option v-for="section in sections" :value="section.id">
								{{ section.name }}
							</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" value="Submit" class="btn btn-success"/>
						<input type="button" value="Back" class="btn btn-default"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</panel-default>
</template>

<script>
export default{
	data: function () {
		return {
			status : 'loading',
			sections : [],
			grade_requirements: [],
			student_requirements: [],
			enroll: {}
		}
	},

	created: function () {
		console.log(this)
		this.getStudentInfo();
	},

	methods: {
		getRequirement: function (id) {
			let requirements = this.data.requirements;
			for (var i in requirements)
				if (requirements[i]['id'] == id)
					return requirements[i]['name'];
			return '';
		},

		getStudentInfo: function () {
			var vm = this;
			axios.get(this.data.API+'student/'+this.id)
				.then(response=>{
					console.log(response);
					vm.status= 'success';
					vm.data.requirements = response.data.requirement;
					vm.sections = response.data.section;
					vm.grade_requirements = response.data.grade_requirement;
					vm.enroll = response.data.enroll;
				})
				.catch(error=>{
					console.log(error);
					vm.status = 'error';
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

	computed: {
		full_name: function () {
			return this.student.first_name+ ' '+this.student.middle_name+ ' '+this.student.last_name; 
		},

		student : function () {
			let students = this.data.students.data;
			for (var i in students)
				if (students[i]['id'] == this.id)
					return students[i];
			return {};
		},

		id: function () {
			return this.$route.params.id;
		},

		hasPassedAllRequirements: function () {
			if ()
		}
	}
}
</script>
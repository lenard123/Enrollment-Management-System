<template>
<panel-default>
	<h4>Update Student</h4><hr/>

	<form class="row" id="edit_form" @submit.prevent="submit()">

		<div class="col-md-6">
			<div class="form-group">
				<label for="grade_id">Grade</label>
				<select name="grade_id" class="form-control" :value="student.grade_id" required>
					<option value="0" disabled>--- Select Grade ---</option>
					<option v-for="grade in data.grades" :value="grade.id">
						{{ grade.name }}
					</option>
				</select>
			</div>

			<form-group name="student_id" :value="student.student_id">Student ID</form-group>
			<form-group name="first_name" :value="student.first_name">First Name</form-group>
			<form-group name="middle_name" :l-required="false" :value="student.middle_name">Middle Name</form-group>
			<form-group name="last_name" :value="student.last_name">Last Name</form-group>
			
		</div>

		<div class="col-md-6">

			<div class="form-group">
				<label for="address">Address</label>
				<textarea class="form-control" name="address">{{student.address}}</textarea>
			</div>

			<div class="form-group">
				<label for="phone">Phone</label>
				<input type="number" name="phone" class="form-control" minlength="11" maxlength="11" :value="student.phone"/>
			</div>

			<div class="form-group">
				<label for="birthday">Birthday</label>
				<input type="date" class="form-control" :value="student.birthday" name="birthday" required/>
			</div>

			<div class="form-group">
				<label for="gender">Gender</label>
				<select class="form-control" name="gender" :value="student.gender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>

			<div class="form-group">
				<input type="submit" value="Submit" class="btn btn-success"/>
				<router-link tag="button" :to="{name:'Enroll Student', params:{id:id}}" class="btn btn-primary">Enroll Student</router-link>
				<input type="button" value="Back" @click="back()" class="btn btn-default"/>
			</div>
		</div>
	</form>

</panel-default>
</template>

<script>
export default{
	data: function () {
		return {
			loading: false
		}
	},

	methods: {
		back: function() {
			this.$router.push({name: 'All Student', query:{loading:false}});
			this.$nextTick(()=>this.$router.replace({name: 'All Student'}));
		},

		submit: function () {
			if (this.loading) return;
			this.loading = true;
			this.util.notify('Updating Students', 'loading');
			var vm = this;
			axios.put(this.data.API+'student/'+this.id, $('#edit_form').serialize())
				.then(response=>{
					vm.loading = false;
					$.notifyClose();
					if (vm.util.showResult(response, 'success')) {
						vm.student = response.data.student;
						vm.back();
					}
				})
				.catch(error=>{
					vm.loading = false;
					$.notifyClose();
					vm.util.showResult(error, 'error');
				})
		}
	},

	computed: {
		student: {
			get: function () {
				let students = this.data.students.data;
				for (var i in students)
					if (students[i]['id']==this.id)
						return students[i];
				return {};
			},

			set: function (val) {
				let students = this.data.students.data;
				for (var i in students)
					if (students[i]['id'] == this.id)
						students.splice(i,1,val);
			}
		},

		id: function () {
			return this.$route.params.id;
		}
	}
}
</script>
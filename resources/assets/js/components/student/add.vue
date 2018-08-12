<template>
<panel-default>
	<h4>Add Student</h4><hr/>

	<form class="row" id="add_form" @submit.prevent="submit()">

		<div class="col-md-6">
			<div class="form-group">
				<label for="grade_id">Grade</label>
				<select name="grade_id" class="form-control" required>
					<option value="0" disabled selected>--- Select Grade ---</option>
					<option v-for="grade in data.grades" :value="grade.id">
						{{ grade.name }}
					</option>
				</select>
			</div>

			<form-group name="student_id">Student ID</form-group>
			<form-group name="first_name">First Name</form-group>
			<form-group name="middle_name" :l-required="false">Middle Name</form-group>
			<form-group name="last_name">Last Name</form-group>
		</div>

		<div class="col-md-6">

			<div class="form-group">
				<label for="address">Address</label>
				<textarea class="form-control" name="address"></textarea>
			</div>

			<div class="form-group">
				<label for="phone">Phone</label>
				<input type="number" name="phone" class="form-control" minlength="11" maxlength="11" />
			</div>

			<div class="form-group">
				<label for="birthday">Birthday</label>
				<input type="date" class="form-control" name="birthday" required/>
			</div>

			<div class="form-group">
				<label for="gender">Gender</label>
				<select class="form-control" name="gender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>

			<div class="form-group">
				<input type="submit" value="Submit" class="btn btn-success"/>
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
			this.$router.go(-1)
		},

		submit: function() {
			if (this.loading) return;
			this.loading = true;
			this.util.notify('Adding Student', 'loading');
			var vm = this;
			axios.post(this.data.API+'student', $('#add_form').serialize())
				.then(response=>{
					$.notifyClose();
					vm.loading = false;
					if (vm.util.showResult(response, 'success')) {
						vm.data.students.data.push(response.data.student);
						vm.back();
					}
				})
				.catch(error=>{
					$.notifyClose();
					vm.loading = false;
					vm.util.showResult(error, 'error');
				})
		}
	}
}
</script>

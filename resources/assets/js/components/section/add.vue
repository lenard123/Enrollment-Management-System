<template>
<panel-default>
	<h4>Add Section</h4><hr/>
	<form @submit.prevent="submit" id="add_form">

		<div class="form-group">
			<label for="grade_id">Grade</label>
			<select class="form-control" name="grade_id" v-model="grade_id" required>
				<option value="0" disabled>--- Select Grade ---</option>
				<option v-for="grade in grades" :value="grade.id">{{ grade.name }}</option>
			</select>
		</div>

		<form-group>Name</form-group>
		<form-group name="teacher">Teacher</form-group>		

		<div class="form-group">
			<input type="submit" value="Submit" class="btn btn-success"/>
			<input type="button" value="Back" class="btn btn-default" @click="back()"/>
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
		back: function () {
			this.$router.push({name: 'Manage Section', query:{id:this.grade_id,loading:false}});
			this.$nextTick(()=>this.$router.replace({query:{id:this.grade_id}}));
		},

		submit: function () {
			if (this.loading) return;
			var vm = this;
			this.loading = true;
			this.util.notify('Adding Section', 'loading');
			axios.post(this.data.API+'section', $('#add_form').serialize())
				.then(response=>{
					$.notifyClose();
					vm.loading = false;
					if (vm.util.showResult(response, 'success')) {
						vm.sections = response.data.section;
						vm.back();
					}
				})
				.catch(error=>{
					$.notifyClose();
					vm.loading = false;
					vm.util.showResult(error, 'error');
				})
		}
	},

	computed: {

		grades: {
			get: function () {
				return this.data.grades;
			}
		},

		sections: {
			get: function () {
				return this.data.sections;
			},

			set: function (val) {
				this.data.sections.push(val);
			}
		},

		grade_id: {
			get: function () {
				return this.$route.query.id ? this.$route.query.id : 0;
			},

			set: function (val) {
				this.$router.replace({query:{id: val}});
			}
		}
	}
}
</script>

<template>
<panel-default>
	<h4>Add Requirements</h4><hr/>
	<form @submit.prevent="submit" id="add_form">

		<form-group>Requirement Name</form-group>

		<div class="form-group">
			<input type="submit" value="Submit" class="btn btn-success"/>
			<router-link :to="{name: 'Manage Requirement'}" class="btn btn-default">
				Back
			</router-link>
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
		submit: function () {
			if (this.loading) return;
			var vm = this;
			this.loading = true;
			this.util.notify('Adding Requirements', 'loading');
			axios.post(this.data.API+'requirement', $('#add_form').serialize())
				.then(response=>{
					$.notifyClose();
					vm.loading = false;
					if (vm.util.showResult(response, 'success')) {
						vm.data.requirements.push(response.data.requirement);
						vm.$router.push({name: 'Manage Requirement'});
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
<template>
<panel-default>
	<h4>Update Requirements</h4><hr/>
	<form @submit.prevent="submit" id="edit_form">

		<form-group :value="requirement.name">Requirement Name</form-group>

		<div class="form-group">
			<input type="submit" value="Submit" class="btn btn-success"/>
			<input type="button" value="Back" class="btn btn-default" @click="back()"/>
		</div>

	</form>
</panel-default>
</template>

<script>
export default{
	created: function () {
		if (!this.requirement.id)
			this.$router.push({name: 'Manage Requirement'});
	},

	data: function () {
		return {
			loading: false
		}
	},

	methods: {
		back: function() {
			this.$router.push({name: 'Manage Requirement', query: {loading:false}});
			this.$nextTick(()=>this.$router.push({name: 'Manage Requirement'}));
		},

		isSame: function() {
			return $('[name=name]').val() == this.requirement.name;
		},

		submit: function () {
			if (this.loading) return;
			if (this.isSame()) 
				return this.back();

			var vm = this;
			this.loading = true;
			this.util.notify('Updating Requirements', 'loading');
			axios.put(this.data.API+'requirement/'+this.id, $('#edit_form').serialize())
				.then(response=>{
					$.notifyClose();
					vm.loading = false;
					if (vm.util.showResult(response, 'success')) {
						vm.requirement  = response.data.requirement;
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
		id: function () {
			return this.$route.params.id;
		},

		requirement:{
			get: function () {
				let requirements = this.data.requirements;
				for (var i in requirements)
					if (requirements[i]['id'] == this.id)
						return requirements[i];
				return {};
			},

			set: function (val) {
				let requirements = this.data.requirements;
				for (var i in requirements)
					if (requirements[i]['id'] == this.id)
						requirements[i] = val;
			}
		}
	}
}
</script>
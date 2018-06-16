<template>
<panel-default l-class="table-responsive">
	<h4>Manage Requirements</h4><hr/>

	<div class="form-group">
		<router-link class="btn btn-success" :to="{name: 'Add Requirement'}">
			<i class="fa fa-plus"></i> Add Requirements
		</router-link>

		<button class="btn btn-default" @click="refreshRequirement()">
			<i class="fa fa-refresh"></i> Refresh Requirements
		</button>

	</div>

	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<tr v-if="data.requirements.length < 1">
				<td colspan="4">No Requirements</td>
			</tr>
			<tr v-for="requirement in data.requirements">
				<td>{{ requirement.id }}</td>
				<td>{{ requirement.name }}</td>
				<router-link tag="td" :to="{name: 'Edit Requirement', params: {id:requirement.id}}"><i class="fa fa-edit"></i> Edit</router-link>
				<td @click="id=requirement.id;util.showModal('#delete_requirement_modal')">
					<i class="fa fa-trash"></i> Delete
				</td>
			</tr>
		</tbody>
	</table>

	<modal id="delete_requirement_modal">
		<modal-header>Delete Requirement</modal-header>
		<modal-body><h3>Are you sure to delete requirement?</h3></modal-body>
		<modal-footer>
			<button @click="deleteRequirement()" class="btn btn-danger">Delete</button>
			<button data-dismiss="modal" class="btn btn-default">Cancel</button>
		</modal-footer>
	</modal>

</panel-default>
</template>

<script>
export default{
	data: function () {
		return {
			id: 0
		}
	},

	created: function () {
		if (this.$route.query.loading != false)
			this.refreshRequirement();
	},

	methods: {
		removeRequirement: function () {
			let requirements = this.data.requirements;
			for (var i in requirements)
				if (this.id == requirements[i]['id']) {
					this.id = 0;
					return requirements.splice(i, 1);
				}
		},

		deleteRequirement: function () {
			var vm = this;
			this.util.hideModal('#delete_requirement_modal');
			$.notifyClose();
			this.util.notify('Deleting requirement', 'loading');
			axios.delete(`${this.data.API}requirement/${this.id}`)
				.then(response=>{
					$.notifyClose();
					if (vm.util.showResult(response, 'success'))
						vm.removeRequirement();
				})	
				.catch(error=>{
					$.notifyClose();
					vm.util.showResult(error, 'error');
				})
		},

		refreshRequirement: function () {
			var vm = this;
			this.util.notify('Refreshing requirements', 'loading');
			axios.get(this.data.API+'requirement')
				.then(response=>{
					$.notifyClose();
					vm.data.requirements = response.data;
				})
				.catch(error=>{
					$.notifyClose();
					vm.util.showResult(error, 'error');
				})
		}
	}
}
</script>
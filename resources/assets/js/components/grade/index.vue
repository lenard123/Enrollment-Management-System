<template>
<panel-default l-class="table-responsive">
	<h4>Manage Grade levels</h4><hr/>

	<div class="form-group">

		<router-link :to="{name: 'Add Grade'}" class="btn btn-success">
			<i class="fa fa-plus"></i> Add Grade
		</router-link>
		
		<button class="btn btn-default" @click="refreshGrade()">
			<i class="fa fa-refresh"></i> Refresh Grade
		</button>

	</div>

	<table class="table table-hover table-striped">
		
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Requirements</th>
				<th>Edit</th>
				<th>Delete</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			<tr v-if="data.grades.length < 1">
				<th colspan="6">No Grades</th>
			</tr>
			<tr v-for="grade in data.grades">
				<td>{{ grade.id }}</td>
				<td>{{ grade.name }}</td>
				<td v-if="!grade.requirements">No Requirements</td>
				<td :class="{'dropup':grade.requirements.length>1}" v-else>
					
					<span v-if="grade.requirements.length < 1">No Requirements</span>
					
					<span v-if="grade.requirements.length == 1">
						{{ getRequirement(grade.requirements[0]['requirement_id']) }}
					</span>
					
					<span v-if="grade.requirements.length > 1" class="dropdown-toggle" id="menu1" data-toggle="dropdown">
						requirements <span class="caret"></span>
					</span>
					<ul v-if="grade.requirements.length > 1" class="dropdown-menu" role="menu" aria-labelledby="menu1">
				      <li role="presentation" v-for="requirement in grade.requirements">
				      	<a role="menuitem" tabindex="-1" href="#">
				      		{{ getRequirement(requirement.requirement_id) }}
				      	</a>
				      </li>
				    </ul>

				</td>
				<router-link tag="td" :to="{name:'Edit Grade', params:{id:grade.id}}">
					<i class="fa fa-edit"></i> Edit
				</router-link>

				<td @click="id=grade.id;util.showModal('#delete_grade_modal')">
					<i class="fa fa-trash"></i> Delete
				</td>

				<router-link tag="td" :to="{name: 'Manage Section', query:{id:grade.id}}">
					<button class="btn btn-primary">View Sections</button>
				</router-link>
			</tr>
		</tbody>

	</table>

	<modal id="delete_grade_modal">
		<modal-header>Delete Grade</modal-header>
		<modal-body><h3>Are you sure to delete grade?</h3></modal-body>
		<modal-footer>
			<button class="btn btn-danger" @click="deleteGrade()">Delete</button>
			<button class="btn btn-default" data-dismiss="modal">Cancel</button>
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
			this.refreshGrade();
	},

	methods: {
		removeGrade: function () {
			let grades = this.data.grades;
			for (var i in grades)
				if (grades[i]['id']==this.id)
					grades.splice(i,1);
		},

		deleteGrade: function () {
			this.util.hideModal('#delete_grade_modal');
			this.util.notify('Deleting grade', 'loading');
			var vm = this;
			axios.delete(this.data.API+'grade/'+this.id)
				.then(response=>{
					$.notifyClose();
					if (vm.util.showResult(response, 'success'))
						vm.removeGrade();
				})
				.catch(error=>{
					$.notifyClose();
					vm.util.showResult(error, 'error');
				})
		},

		getRequirement: function (id) {
			let requirements = this.data.requirements;
			for (var i in requirements)
				if (requirements[i]['id'] == id) return requirements[i]['name'];
			return '';
		},

		refreshGrade: function () {
			var vm = this;
			this.util.notify('Refreshing Grade', 'loading');
			axios.get(this.data.API+'grade')
				.then(response=>{
					$.notifyClose();
					vm.data.grades = response.data.grade;
					vm.data.requirements = response.data.requirement;
				})
				.catch(error=>{
					$.notifyClose();
					vm.util.showResult(error, 'error');
				})
		}
	}
}
</script>

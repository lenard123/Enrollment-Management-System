<template>
<div class="col-md-10 col-md-offset-1 row">

	<div class="col-md-3">
		<ul class="list-group">
			<li 
				class="list-group-item" 
				v-on:click="$router.replace({name: 'Manage Section', query:{id:grade.id}})"
	  			v-for="grade in grades" 
	  			:class="{'active':grade.id==id}">{{ grade.name }}
	  		</li>
	  	</ul>
	</div>

	<div class="col-md-8 panel panel-default">

		<div class="panel-body table-responsive">
			<h4>Manage Sections</h4><hr/>

			<div class="form-group">
				<button 
					class="btn btn-success" 
					@click="$router.push({name:'Add Section', query:{id:id}})">
					<i class="fa fa-plus"></i> Add Section
				</button>
				<button @click="refreshSection()" class="btn btn-default">
					<i class="fa fa-refresh"></i> Refresh Section
				</button>
			</div>

			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Teacher</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="!hasSections()">
						<th colspan="5">No Sections</th>
					</tr>
					<tr v-for="section in sections" v-if="section.grade_id==id">
						<td>{{ section.id }}</td>
						<td>{{ section.name }}</td>
						<td>{{ section.teacher }}</td>
						<router-link :to="{name: 'Edit Section', params:{id:section.id}}" tag="td">
							<i class="fa fa-edit"></i> Edit
						</router-link>
						<td @click="id1=section.id;util.showModal('#delete_section_modal')">
							<i class="fa fa-trash"></i> Delete
						</td>
						<router-link :to="{name: 'Section Student', params:{id:section.id}}" tag="td">
							<button class="btn btn-primary">View Students</button>
						</router-link>
					</tr>
				</tbody>
			</table>				
		</div>
	</div>

	<modal id="delete_section_modal">
		<modal-header>Delete Section</modal-header>
		<modal-body><h3>Are you sure delete section?</h3></modal-body>
		<modal-footer>
			<button class="btn btn-danger" @click="deleteSection()">Delete</button>
			<button class="btn btn-default" data-dismiss="modal">Cancel</button>
		</modal-footer>
	</modal>
</div>
</template>

<script>
export default{
	data: function () {
		return {
			id1: 0
		}
	},

	created: function () {
		if (this.$route.query.loading != false)
			this.refreshSection();
	},

	methods: {

		hasSections: function () {
			let sections = this.sections;
			for (var i in sections)
				if (sections[i]['grade_id'] == this.id)
					return true;
			return false;
		},

		removeSection: function () {
			let sections = this.sections;
			for (var i in sections)
				if (sections[i]['id']==this.id1)
					sections.splice(i,1);
			this.id1 = 0;
		},

		deleteSection: function () {
			this.util.hideModal('#delete_section_modal');
			this.util.notify('Deleting section', 'loading');
			var vm = this;
			axios.delete(this.data.API+'section/'+this.id1)
				.then(response=>{
					$.notifyClose();
					if (vm.util.showResult(response, 'success'))
						vm.removeSection();
				})
				.catch(error=>{
					$.notifyClose();
					vm.util.showResult(error, 'error');
				})
		},

		refreshSection: function () {
			var vm = this;
			this.util.notify('Refreshing sections', 'loading');
			axios.get(this.data.API+'section')
				.then(response=>{
					$.notifyClose();
					vm.data.sections = response.data.section;
					vm.data.grades = response.data.grade;
				})
				.catch(error=>{
					$.notifyClose();
					vm.util.showResult(error, 'error');
				})
		}
	},

	computed: {
		id: function () {
			if (this.$route.query.id)
				return this.$route.query.id;
			else if (this.grades[0])
				return this.grades[0]['id'];
			else return 0;
		},

		sections: {
			get: function () {
				return this.data.sections;
			},

			set: function (val) {
				let grades = this.grades;
				for (var i in grades)
					if (grades[i]['id'] == this.id)
						this.data.sections[i] = val;

			}
		},

		grades: function () {
			return this.data.grades;
		}
	}
}
</script>

<template>
<panel-default>
	<h4>Update Grade Level</h4><hr/>
	<form @submit.prevent="submit()" id="edit_form">
		<form-group :value="grade.name">Grade Name</form-group>

		<div class="form-group" v-if="data.requirements.length >= 1">
			<label for="requirements">Requirements</label><br/>
			<label class="checkbox-inline" v-for="requirement in data.requirements">
				<input type="checkbox" name="requirements" :value="requirement.id">
					{{ requirement.name }}
			</label>
		</div>

		<div class="form-group">
			<input type="submit" class="btn btn-success" value="Submit"/>
			<input type="button" class="btn btn-default" value="Back" @click="back()"/>
		</div>

	</form> 
</panel-default>
</template>

<script>
export default{
	created: function () {
		this.$nextTick(()=>{
			let requirements = this.grade.requirements;
			for (var i in requirements)
				$(`[value=${requirements[i]['requirement_id']}][type=checkbox]`).attr('checked', true);
		});
	},

	data: function () {
		return {
			loading: false
		}
	},

	methods: {
		back: function () {
			this.$router.push({name: 'Manage Grade', query: {loading: false}});
			this.$nextTick(()=>this.$router.push({name: 'Manage Grade'}));
		},

		submit: function () {
			if (this.loading) return;
			this.loading = true;
			var vm = this
			this.util.notify('Updating grade', 'loading')
			axios.put(this.data.API+'grade/'+this.id, this.getData())
				.then(response=>{
					$.notifyClose();
					vm.loading = false;
					if (vm.util.showResult(response, 'success')) {
						vm.grade = response.data.grade;
						vm.back();
					}
				})
				.catch(error=>{
					$.notifyClose();
					vm.loading = false;
					vm.util.showResult(error, 'error')
				})
		},

		getData: function () {
			let data = {};
			data['name'] = $('[name=name]').val();
			data['requirements'] = this.getRequirements();
			return data;
		},

		getRequirements: function () {
			let requirements = $('[name=requirements]').toArray();
			let x = [];
			for (var i in requirements)
				if (requirements[i].checked) x.push(requirements[i].value);
			return x;
		}
	},

	computed: {
		grade:{
			get: function () {
				let grades = this.data.grades;
				for (var i in grades)
					if (grades[i]['id'] == this.id)
						return grades[i];
				return {};
			},

			set: function (val) {
				let grades = this.data.grades;
				for (var i in grades)
					if (grades[i]['id'] == this.id)
						grades[i] = val;
			}
		},

		id: function () {
			return this.$route.params.id;
		}
	}
}
</script>
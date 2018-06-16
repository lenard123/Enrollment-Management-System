<template>
<panel-default>
	<h4>Update Section</h4><hr/>
	<form @submit.prevent="submit" id="edit_form">
		
		<form-group :value="section.name">Name</form-group>
		<form-group name="teacher" :value="section.teacher">Teacher</form-group>

		<div class="form-group">
			<label for="grade">Grade</label>
			<select class="form-control" name="grade_id" :value="section.grade_id">
				<option value="0" disabled>--- Select Grade ---</option>
				<option v-for="grade in grades" :value="grade.id">{{ grade.name }}</option>
			</select>
		</div>

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
		isSame: function () {
			let section = this.section;
			return section.name == $('[name=name]').val() && 
				   section.teacher == $('[name=teacher]').val() && 
				   section.grade_id == $('[name=grade_id]').val();
		},

		submit: function () {
			if (this.loading) return;
			if (this.isSame()) return this.back();
			this.loading = true;
			this.util.notify('Updating Section', 'loading');
			var vm = this;
			axios.put(this.data.API+'section/'+this.id, $('#edit_form').serialize())
				.then(response=>{
					vm.loading = false;
					$.notifyClose();
					if (vm.util.showResult(response, 'success')) {
						vm.section = response.data.section;
						vm.back();
					}
				})
				.catch(error=>{
					vm.loading = false;
					$.notifyClose();
					vm.util.showResult(error, 'error');
				})
		},

		back: function () {
			let id = this.section.grade_id;
			this.$router.push({name:'Manage Section', query:{id:id,loading:false}});
			this.$nextTick(()=>{
				this.$router.replace({name:'Manage Section', query:{id:id}});
			})
		}
	},

	computed:{
		grades: function () {
			return this.data.grades;
		},

		section: { 
			get: function () {
				let sections = this.data.sections;
				for (var i in sections)
					if (sections[i]['id'] == this.id)
						return sections[i];
				return {};
			},

			set: function (val) {
				let sections = this.data.sections;
				for (var i in sections)
					if (sections[i]['id'] == this.id)
						sections.splice(i, 1, val);			
			}
		},

		id: function () {
			return this.$route.params.id;
		}
	}
}
</script>
<template>
<panel-default l-class="table-responsive">
	<h4>{{type[0].toUpperCase()+type.substring(1)}} Students</h4><hr/>

	<div class="form-group">
		<router-link :to="{name: 'Add Student'}" class="btn btn-success">
			<i class="fa fa-plus"></i> Add Student
		</router-link>

		<button class="btn btn-default" @click="refresh++">
			<i class="fa fa-refresh"></i> Refresh Student
		</button>

	</div>

	<table-student :src="data.API+'student/'+types" :refresh="refresh"/>

</panel-default>
</template>

<script>
export default{
	props: ['type'],

	data: function(){
		return {
			refresh: 0
		}
	},

	computed: {

		types: function () {
			switch(this.type) {
				case 'enrolled':
					return 'enrolled';
					break;
				case 'pending':
					return 'pending';
					break;
				default:
					return '';
					break;
			}
		}
	}
}
</script> 

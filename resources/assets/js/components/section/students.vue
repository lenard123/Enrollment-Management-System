<template>
<panel-default>

	<h4>Section : {{ section.name }}</h4>
	<h5>Teacher : {{ section.teacher }}</h5>
	<hr/>

	<div class="form-group">
		<button class="btn btn-default" @click="$router.go(-1)">Back</button>
		<button class="btn btn-default" @click="refresh++">
			<i class="fa fa-refresh"></i> Refresh
		</button>
	</div>

	<table-student :src="data.API+'student/section/'+id" :refresh="refresh"/>

	</div>

</panel-default>
</template>

<script>
export default{
	props: ['id'],
	
	data: function(){
		return {
			loading: false,
			refresh: 0
		}
	},

	computed: {
		section: function(){
			let sections = this.data.sections;
			return sections.find((section)=>section.id==this.id);
		}
	}
}
</script>

<template>
	<student :type='type'/>
</template>

<script>
import student from './student.vue';
export default{
	components: {
		'student':student
	},

	computed: {
		type: function(){
			return this.$route.params.type;
		}
	}
}
</script>
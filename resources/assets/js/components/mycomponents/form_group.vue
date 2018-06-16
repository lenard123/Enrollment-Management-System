<template>
<div class="form-group">
	<label :for="name"><slot></slot></label>
	<input :type="type" :name="name" :class="lClass" :id="id" :value="value" required/>
</div>
</template>

<script>
export default{
	props: {
		name: {default: 'name'},
		type: {default: 'text'},
		lClass: {default: 'form-control'},
		lRequired: {type: Boolean, default: true},
		id: {},
		value: {}
	},

	created: function () {
		this.$nextTick(function(){
			if (!this.lRequired)
				$(`[name=${this.name}]`).removeAttr('required');
		});
	}
}	
</script>
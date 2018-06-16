<template>
<div class="panel panel-default col-md-8 col-md-offset-2" :class="lClass">
	<div class="panel-body">
		<slot></slot>
	</div>
</div>
</template>

<script>
export default{
	props:['lClass']
}
</script>
		<!-- Logout modal start-->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Logout</h4>
					</div>

					<div class="modal-body">
						<p>Are you sure to logout?</p>
					</div>
			
					<div class="modal-footer">
						<button type="button" class="btn btn-info" v-on:click="logout">Yes</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
					</div>
				</div>

			</div>
		</div>
		<!-- Logout modal end-->		
		<script>
			var logout = new Vue(
				{
					el:'#myModal',
					methods:
					{
						logout: function(){
							location.replace("<?php echo base_url();?>home/logout")
						},

					}
				});
			var nav = new Vue(
				{
					el:'#nav',
					methods:
					{
						goto: function(loc){
							location.replace("<?php echo base_url();?>home/"+loc)
						}
					}
				})
		</script>
	</body>
</html>
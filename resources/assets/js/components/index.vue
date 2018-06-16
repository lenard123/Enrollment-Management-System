<template>
<div>
	<div v-if="status == 'loading'" class="jumbotron" style="margin: 20px; padding: 20px;">
		<h1>Loading... <i class="fa fa-refresh fa-spin"></i></h1>
	</div>
	<div v-else-if="status == 'error'" class="jumbotron" style="margin: 20px; padding: 20px;"">
		<h1><i class="fa fa-warning"></i> An error occured</h1>
	</div>
	<div v-else>
		<nav class="navbar navbar-default navbar-fixed-top" id="nav">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>	
					<router-link :to="{name:'Home'}" class="navbar-brand" exact>
						EMS - HOME
					</router-link>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">

					<ul class="nav navbar-nav">

						<router-link tag="li" :to="{name: 'Manage Requirement'}">
							<a href="#">Manage Requirements</a>
						</router-link>

						<router-link tag="li" :to="{name: 'Manage Grade'}">
							<a href="#">Manage Grade Level</a>
						</router-link>
						
						<router-link tag="li" :to="{name: 'Manage Section'}">
							<a href="#">Manage Sections</a>
						</router-link>

						<li class="dropdown">
							<a 
								href="#" 
								class="dropdown-toggle"
								data-toggle="dropdown"
								role="button"
								aria-haspopup="true"
								aria-expanded="false">Manage Students 
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">

								<router-link 
									tag="li"
									:to="{name:'All Student'}"
									active-class="active">
									<a href="#">All Students</a>
								</router-link>
								
								<li><a href="#">Enrolled Students</a></li>
								<li><a href="#">Pending Students</a></li>
							</ul>
						</li>

					</ul>
					<ul class="nav navbar-right navbar-nav">
						<li class="dropdown">
							<a 
								href="#" 
								class="dropdown-toggle" 
								data-toggle="dropdown" 
								role="button" aria-haspopup="true" 
								aria-expanded="false">
								<span class="fa fa-user"></span> {{ data.user.name }} <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">

								<li><a href="#">Update Account</a></li>
								<li><a href="#">Manage Accounts</a></li>

								<li @click="logout()"><a>Logout</a></li>
							</ul>
						</li>
					</ul>
				</div> 
			</div>
		</nav>

		<router-view></router-view>

	</div>
</div>
</template>
<script>
export default{
	data: function () {
		return {
			status: 'loading'
		}
	},

	created: function() {
		if (!this.util.isLogin())
			this.$router.push({name: 'Login'});
		else
			this.getUser();
	},

	methods: {
		getUser: function () {
			var vm = this;
			axios.get(this.data.API+'admin/user')
				.then(response=>{
					vm.status = 'success';
					vm.data.user = response.data;
				})
				.catch(error=>{
					vm.util.log(error);
					vm.status = 'error';
				});
		}	
	}
}
</script>

<style>

body{
	padding: 70px 5px;
}

a.l-selected {
	color: #000 !important;
}

.l-selected a{
	color: #000 !important;
}
</style>
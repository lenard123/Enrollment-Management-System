<!Doctype html>
<html>
	<head>

		<title>EMS - <?php echo $title; ?></title>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1"> 
		<meta name="description" content="Enrollment Management System">		
		<meta name="keywords" content="Enrollment,Management,System">		
		<meta name="author" content="Lenard Mangay-ayam">
		
		<script src="<?php echo base_url();?>include/js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>include/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>include/js/vue.min.js"></script>
		<script src="<?php echo base_url();?>include/js/vee-validate.min.js"></script>
		<script src="<?php echo base_url();?>include/js/axios.min.js"></script>
		<script src="<?php echo base_url();?>include/js/index.js"></script>

		<link rel="stylesheet" href="<?php echo base_url();?>include/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>include/css/home.css" />

	</head>
	<body>
		
		<nav class="navbar navbar-inverse navbar-fixed-top" id="nav">
			<div class="container-fluid">

				<div class="navbar-header">
					
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span>
      				</button>
			    	
			    	<a class="navbar-brand" href="<?php echo base_url();?>home">EMS</a>

				</div>

				<div class="collapse navbar-collapse" id="myNavbar">
					
					<ul class="nav navbar-nav">
						<li <?php if($page=="addstudent") echo 'class="active"';?>><a href="#" v-on:click="goto('addstudent')">Add Student</a></li>
						<li <?php if($page=="manageclass") echo 'class="active"';?>><a href="#" v-on:click="goto('manageclass')">Manage Class</a></li>
						<li class="dropdown <?php if($page=="managestudent") echo 'active';?>">
							<a href="#" class="dropdown-toggle " data-toggle="dropdown">Manage Students<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li <?php if($page=="managestudent" && $view=="all") echo "class='active'";?>><a href="#" v-on:click="goto('managestudent/all')">Manage All Students</a></li>
								<li <?php if($page=="managestudent" && $view=="enrolled") echo "class='active'";?>><a href="#" v-on:click="goto('managestudent/enrolled')">Manage Enrolled Students</a></li>
								<li <?php if($page=="managestudent" && $view=="pending") echo "class='active'";?>><a href="#" v-on:click="goto('managestudent/pending')">Manage Pending Students</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown<?php if($page=="account") echo ' active';?>">
							<a href="#" class="dropdown-toggle " data-toggle="dropdown">Account<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#" v-on:click="goto('../account/updateAccount')"><span class="glyphicon glyphicon-upload"></span> Update Account</a></li>
								
								<?php if($_SESSION['ADMIN_ID'] == 1){ ?>
								<li><a href="#" v-on:click="goto('../account/addAccount')"><span class="glyphicon glyphicon-plus"></span> Add new Admin</a></li>
								<li><a href="#" v-on:click="goto('../account/manageAccount')"><span class="glyphicon glyphicon-user"></span> Manage Account</a></li>
								<?php } ?>

								<li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
							</ul>							
						</li>
						<!--<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
						<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>-->
					</ul>
					<form class="navbar-form navbar-right" action="<?php echo base_url();?>home/searchstudent" method="get">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search Student" name="q">
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit">
									<i class="glyphicon glyphicon-search"></i>
								</button>
							</div>
						</div>
					</form> 
				</div>				

			</div>
		</nav>

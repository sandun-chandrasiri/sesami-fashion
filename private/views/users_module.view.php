<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

<style>
	h1{
		font-size: 80px;
		color: limegreen;
	}

	a{
		text-decoration: none;
	}

	.card-header{
		font-weight: bold;
	}

	.card{
		min-width: 250px;
	}
</style>

	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>
	 
	 	<div class="row justify-content-center ">

		 	<?php if(Auth::access('head')):?>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/users">
		 			<div class="card-header text-center">MANAGING STAFF</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/managingStaff.jpg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View all Managing Staff</div>
	 				</a>
		 		</div>
		 		
		 	<?php endif;?>

		 	<?php if(Auth::access('teamLeader')):?>
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/teamLeaders">
		 			<div class="card-header text-center">TEAM LEADERS</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/teamLeader.jpg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View all Team Leaders</div>
		 			</a>
		 		</div>

		 	<?php endif;?>

	 	</div>
	</div>
 
<?php $this->view('includes/footer')?>

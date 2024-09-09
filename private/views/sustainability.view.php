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

		 	<?php if(Auth::access('dataEntryClerk')):?>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/electricity">
		 			<div class="card-header text-center">ELECTRICITY</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/electricity.jpeg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Electriciry Records</div>
	 				</a>
		 		</div>
		 		
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/water">
		 			<div class="card-header text-center">WATER</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/water.jpeg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Water Usage</div>
		 			</a>
		 		</div>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/recycle">
		 			<div class="card-header text-center">RECYCLE</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/recycle.png" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View all Recycle Details</div>
	 				</a>
		 		</div>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/reuse">
		 			<div class="card-header text-center">REUSE</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/reuse.jpg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View all Reuse Details</div>
		 			</a>
		 		</div>

		 	<?php endif;?>

	 	</div>
	</div>
 
<?php $this->view('includes/footer')?>

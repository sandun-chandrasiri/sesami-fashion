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
	 
	 	<div class="row justify-content-center ">

	 		<?php if(Auth::access('manager')):?>
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/products_module">
		 			<div class="card-header text-center">PRODUCT MANAGEMENT</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/factory.png" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Production DModule</div>
	 				</a>
		 		</div>
		 	<?php endif;?>	

		 	<?php if(Auth::access('teamLeader')):?>
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/users_module">
		 			<div class="card-header text-center">USER MANAGEMENT</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/managingStaff.jpg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View all Users</div>
		 			</a>
		 		</div>
		 	<?php endif;?>	
		 	
		 	<?php if(Auth::access('manager')):?>
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/customers_module">
		 			<div class="card-header text-center">CUSTOMER MANAGEMENT</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/customer.png" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Customer Module</div>
	 				</a>
		 		</div>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/suppliers_module">
		 			<div class="card-header text-center">SUPPLIER MANAGEMENT</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/supplier.png" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Supplier Module</div>
	 				</a>
		 		</div>
		 	<?php endif;?>

		 	<?php if(Auth::access('head')):?>
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/finances">
		 			<div class="card-header text-center">FINANCE MANAGEMENT</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/finance.png" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Financial Details</div>
	 				</a>
		 		</div>		 		
		 	<?php endif;?>

		 	<?php if(Auth::access('dataEntryClerk')):?>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/inventory">
		 			<div class="card-header text-center">INVENTORY MANAGEMENT</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/inventory.jpg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Inventory Records</div>
	 				</a>
		 		</div>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/sustainability">
		 			<div class="card-header text-center">SUSTAINABILITY DETAILS</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/sustainability.jpg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View Sustainability Details</div>
	 				</a>
		 		</div>
		 	<?php endif;?>

		 	<?php if(Auth::access('head')):?>
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/finances">
		 			<div class="card-header text-center">PROMOTIONS & OFFERS</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/offer.png" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View More Details</div>
	 				</a>
		 		</div>		 		
		 	<?php endif;?>
	 	</div>
	</div>
 
<?php $this->view('includes/footer')?>

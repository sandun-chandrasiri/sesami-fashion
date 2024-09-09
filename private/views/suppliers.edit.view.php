<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

		<?php if($row):?>
		<div class="card-group justify-content-center">
 

			 <form method="post">
			 	<h3>Edit Supplier Details</h3><br><br>

			 	<?php if(count($errors) > 0):?>
				<div class="alert alert-warning alert-dismissible fade show p-1" role="alert">
				  <strong>Errors:</strong>
				   <?php foreach($errors as $error):?>
				  	<br><?=$error?>
				  <?php endforeach;?>
				  <span  type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </span>
				</div>
				<?php endif;?>
			
			 	<div class="mb-3">
                	<input autofocus class="form-control" value="<?=get_var('supplier',$row[0]->supplier)?>" type="text" name="supplier" placeholder="Supplier Name">
	            </div>
	            <div class="mb-3">
	                <input class="form-control" value="<?=get_var('address',$row[0]->address)?>" type="text" name="address" placeholder="Address">
	            </div>
	            <div class="mb-3">
	                <input class="form-control" value="<?=get_var('contact',$row[0]->contact)?>" type="text" name="contact" placeholder="Contact Number">
	            </div>
	            <div class="mb-3">
	                <input class="form-control" value="<?=get_var('rating',$row[0]->rating)?>" type="text" name="rating" placeholder="Rating">
	            </div><br><br>
			 	<input class="btn btn-primary float-end" type="submit" value="Save">

			 	<a href="<?=ROOT?>/suppliers">
			 		<input class="btn btn-danger" type="button" value="Cancel">
			 	</a>
			 </form>
			
		</div>
		<?php else: ?>

			<div style="text-align: center;">
				<h3>That Supplier was not found!</h3>
				<div class="clearfix"></div>
				<br><br>
				<a href="<?=ROOT?>/suppliers">
			 		<input class="btn btn-danger" type="button" value="Cancel">
			 	</a>
		 	</div>
		<?php endif; ?>

		
	 
	</div>
 
<?php $this->view('includes/footer')?>
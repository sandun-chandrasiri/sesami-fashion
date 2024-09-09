<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

		<?php if($row):?>
		<div class="card-group justify-content-center">
 

			 <form method="post">
			 	<h3>Edit Purchase Order Details</h3><br><br>

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
	                <input autofocus class="form-control" value="<?=get_var('purchase_name',$row[0]->purchase_name)?>" type="text" name="purchase_name" placeholder="Purchase Name">
	            </div>
	            <div class="mb-3">
	                <input class="form-control" value="<?=get_var('description',$row[0]->description)?>" type="text" name="description" placeholder="Description">
	            </div>
	            <div class="mb-3">
	                <select class="my-2 form-control" name="category">
	                <option <?=get_select('category',$row[0]->category)?> value="$row[0]->category"><?=$row[0]->category?></option>
	                <option <?=get_select('category','Fabric')?> value="Fabric">Fabric</option>
	                <option <?=get_select('category','Trims and Accessories')?> value="Trims and Accessories">Trims and Accessories</option>
	                <option <?=get_select('category','Packaging')?> value="Packaging">Packaging</option>
	                <option <?=get_select('category','Sustainable and Ethical')?> value="Sustainable and Ethical">Sustainable and Ethical</option>
	                <option <?=get_select('category','Custom Design')?> value="Custom Design">Other</option>
	            </div><br><br>
			 	<input class="btn btn-primary float-end" type="submit" value="Save">

			 	<a href="<?=ROOT?>/purchases">
			 		<input class="btn btn-danger" type="button" value="Cancel">
			 	</a>
			 </form>
			
		</div>
		<?php else: ?>

			<div style="text-align: center;">
				<h3>That Supplier was not found!</h3>
				<div class="clearfix"></div>
				<br><br>
				<a href="<?=ROOT?>/purchases">
			 		<input class="btn btn-danger" type="button" value="Cancel">
			 	</a>
		 	</div>
		<?php endif; ?>

		
	 
	</div>
 
<?php $this->view('includes/footer')?>
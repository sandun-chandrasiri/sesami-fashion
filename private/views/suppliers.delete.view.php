<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

		<?php if($row):?>
		<div class="card-group justify-content-center">
 

			 <form method="post">
			 	<h3>Are you sure you want to delete?!</h3>
 
			 	<input disabled autofocus class="form-control" value="<?=get_var('supplier',$row[0]->supplier)?>" type="text" name="supplier" placeholder="Supplier Name"><br><br>
			 	<input type="hidden" name="id">
			 	<input class="btn btn-danger float-end" type="submit" value="Delete">

			 	<a href="<?=ROOT?>/suppliers">
			 		<input class="btn btn-success" type="button" value="Cancel">
			 	</a>
			 </form>
			
		</div>
		<?php else: ?>

			<div style="text-align: center;">
				<h3>That supplier was not found!</h3>
				<div class="clearfix"></div>
				<br><br>
				<a href="<?=ROOT?>/suppliers">
			 		<input class="btn btn-danger" type="button" value="Cancel">
			 	</a>
		 	</div>
		<?php endif; ?>

		
	 
	</div>
 
<?php $this->view('includes/footer')?>
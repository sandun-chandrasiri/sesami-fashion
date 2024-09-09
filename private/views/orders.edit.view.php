<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
	
	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

		<?php if($row):?>
		<div class="card-group justify-content-center">
 

			 <form method="post">
			 	<h3>Edit Order Details</h3><br><br>

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
                <input autofocus class="form-control" value="<?=get_var('order_name',$row[0]->order_name)?>" type="text" name="order_name" placeholder="Order Name">
	            </div>
	            <div class="mb-3">
	                <select class="my-2 form-control" name="category">
	                <option <?=get_select('category',$row[0]->category)?> value="$row[0]->category"><?=$row[0]->category?></option>
	                <option <?=get_select('category','Standard Production')?> value="Standard Production">Standard Production</option>
	                <option <?=get_select('category','Custom Design')?> value="Custom Design">Custom Design</option>
	                <option <?=get_select('category','Bulk')?> value="Bulk">Bulk</option>
	                <option <?=get_select('category','Small Batch')?> value="Small Batch">Small Batch</option>
	                <option <?=get_select('category','Seasonal')?> value="Seasonal">Seasonal</option>
	                <option <?=get_select('category','Urgent')?> value="Urgent">Urgent</option>
	                <option <?=get_select('category','Reorder')?> value="Reorder">Reorder</option>
	                <option <?=get_select('category','Prototype')?> value="Prototype">Prototype</option>
	                <option <?=get_select('category','Specialty Fabric')?> value="Specialty Fabric">Specialty Fabric</option>
	                <option <?=get_select('category','Collaboration')?> value="Collaboration">Collaboration</option>
	                <option <?=get_select('category','Made-to-Measure')?> value="Made-to-Measure">Made-to-Measure</option>
	                <option <?=get_select('category','Corporate')?> value="Corporate">Corporate</option>
	                <option <?=get_select('category','Sustainable')?> value="Sustainable">Sustainable</option>
	                <option <?=get_select('category','Trend-Based')?> value="Trend-Based">Trend-Based</option>
	                <option <?=get_select('category','Crowdfunding')?> value="Crowdfunding">Crowdfunding</option>
	                <option <?=get_select('category','Subscription Box')?> value="Subscription Box">Subscription Box</option>
	                <option <?=get_select('category','Event-Specific')?> value="Event-Specific">Event-Specific</option>
	                <option <?=get_select('category','Print-on-Demand')?> value="Print-on-Demand">Print-on-Demand</option>
	            </select>
	            </div>
	            <div class="mb-3">
	                <input class="form-control" value="<?=get_var('description',$row[0]->description)?>" type="text" name="description" placeholder="Description">
	            </div>
	            <div class="mb-3">
	                <select class="my-2 form-control" name="status">
		                <option <?=get_select('status',$row[0]->status)?> value="$row[0]->status"><?=$row[0]->status?></option>
		                <option <?=get_select('status','Not Started')?> value="Not Started">Not Started</option>
		                <option <?=get_select('status','on-going')?> value="on-going">On-Going</option>
		                <option <?=get_select('status','finished')?> value="finished">Finished</option>
		            </select>
	            </div>
	            <div class="mb-3">
	                <input autofocus class="form-control" value="<?=get_var('customer_name',$row[0]->customer_name)?>" type="text" name="customer_name" placeholder="Customer Name">
	            </div>
	            <div class="mb-3">
	                <input autofocus class="form-control" value="<?=get_var('address_line_one',$row[0]->address_line_one)?>" type="text" name="address_line_one" placeholder="Address Line One">
	            </div>
	            <div class="mb-3">
	                <input autofocus class="form-control" value="<?=get_var('address_line_two',$row[0]->address_line_two)?>" type="text" name="address_line_two" placeholder="Address Line Two">
	            </div>
	            <div class="mb-3">
	                <input autofocus class="form-control" value="<?=get_var('contact',$row[0]->contact)?>" type="text" name="contact" placeholder="Contact number">
	            </div>
	            <div class="mb-3">
	                <input autofocus class="form-control" value="<?=get_var('email',$row[0]->email)?>" type="text" name="email" placeholder="Email">
	            </div>
	            <div class="mb-3">
	                <select class="my-2 form-control" name="payment_type">
	                    <option <?=get_select('payment_type',$row[0]->payment_type)?> value="">--Select a Payment Type--</option>
	                    <option <?=get_select('payment_type','Cash')?> value="Cash">Cash</option>
	                    <option <?=get_select('payment_type','Cheque')?> value="Cheque">Cheque</option>
	                </select>
	            </div>
	            <div class="mb-3">
	                <input autofocus class="form-control" value="<?=get_var('quantity',$row[0]->quantity)?>" type="text" name="quantity" placeholder="Quantity">
	            </div>
	            <div class="mb-3">
	                <input autofocus class="form-control" value="<?=get_var('total',$row[0]->total)?>" type="text" name="total" placeholder="Total">
	            </div><br><br>
			 	<input class="btn btn-primary float-end" type="submit" value="Save">

			 	<a href="<?=ROOT?>/orders">
			 		<input class="btn btn-danger" type="button" value="Cancel">
			 	</a>
			 </form>
			
		</div>
		<?php else: ?>

			<div style="text-align: center;">
				<h3>That order was not found!</h3>
				<div class="clearfix"></div>
				<br><br>
				<a href="<?=ROOT?>/orders">
			 		<input class="btn btn-danger" type="button" value="Cancel">
			 	</a>
		 	</div>
		<?php endif; ?>

		
	 
	</div>
 
<?php $this->view('includes/footer')?>
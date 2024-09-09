<div class="card-group justify-content-center">

	<table class="table table-striped table-hover">
		<tr><th></th><th>Order Name</th><th>Category</th><th>Description</th><th>Status</th>
			<th>
				
			</th>
		</tr>
		<?php if(isset($rows) && $rows):?>
			 
			<?php foreach ($rows as $row):?>
			 
			 <tr>
			 	<td>
			 		<a href="">
			 			<button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i></button>
			 		</a>
			 	</td>
			 	<td><?=$row->order_name?></td><td><?=$row->category?></td><td><?=$row->description?></td><td><?=$row->status?></td>

			 	<td>
			 		<?php if(Auth::access('head')):?>
				 		<a href="<?=ROOT?>/orders/edit/<?=$row->id?>">
				 			<button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
				 		</a>

				 		<a href="<?=ROOT?>/orders/delete/<?=$row->id?>">
				 			<button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
				 		</a>
				 		<a href="<?= ROOT ?>/Orders_pdf/<?=$row->order_id?>">
						    <button class="btn-sm btn btn-success float">Invoice</button>
						</a>
				 	<?php endif;?>
			 	</td>

			 </tr>

 			<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="5"><center>No Orders were found at this time</center></td></tr>
			<?php endif;?>

	</table>
</div>
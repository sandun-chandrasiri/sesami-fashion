<div class="card-group justify-content-center">

	<table class="table table-striped table-hover">
		<tr><th></th><th>Item Name</th><th>Description</th><th>Quantity</th><th>Type</th>
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
			 	<td><?=$row->inventory?></td><td><?=$row->description?></td><td><?=$row->quantity?></td><td><?=$row->type?></td>

			 	<td>
			 		<?php if(Auth::access('head') || Auth::access('dataEntryClerk')):?>
				 		<a href="<?=ROOT?>/inventory/edit/<?=$row->id?>">
				 			<button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
				 		</a>

				 		<a href="<?=ROOT?>/inventory/delete/<?=$row->id?>">
				 			<button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
				 		</a>
				 	<?php endif;?>
			 	</td>

			 </tr>

 			<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="5"><center>No Inventory Items were found at this time</center></td></tr>
			<?php endif;?>

	</table>
</div>
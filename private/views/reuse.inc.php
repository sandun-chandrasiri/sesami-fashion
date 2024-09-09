<div class="card-group justify-content-center">

	<table class="table table-striped table-hover">
		<tr><th></th><th>Reesed Item</th><th>Description</th><th>Quantity</th>
			<th>
				
			</th>
		</tr>
		<?php if(isset($rows) && $rows):?>
			 
			<?php foreach ($rows as $row):?>
			 
			 <tr>
			 	<td>
			 		<a href="<?=ROOT?>/single_team/<?=$row->team_id?>?tab=teamLeaders">
			 			<button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i></button>
			 		</a>
			 	</td>
			 	<td><?=$row->reuse?></td><td><?=$row->description?></td><td><?=$row->quantity?></td>

			 	<td>
			 		<?php if(Auth::access('dataEntryClerk')):?>
				 		<a href="<?=ROOT?>/reuse/edit/<?=$row->id?>">
				 			<button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
				 		</a>

				 		<a href="<?=ROOT?>/reuse/delete/<?=$row->id?>">
				 			<button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
				 		</a>
				 	<?php endif;?>
			 	</td>

			 </tr>

 			<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="5"><center>No reuse records were found at this time</center></td></tr>
			<?php endif;?>

	</table>
</div>   
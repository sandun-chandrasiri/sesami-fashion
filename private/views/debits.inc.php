<div class="card-group justify-content-center">

	<table class="table table-striped table-hover">
		<tr><th></th><th>Name</th><th>Description</th><th>Amount</th><th>Status</th>
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
			 	<td><?=$row->name?></td><td><?=$row->description?></td><td><?=$row->amount?></td><td><?=$row->status?></td>

			 	<td>
			 		<?php if(Auth::access('head')):?>
				 		<a href="<?=ROOT?>/debits/edit/<?=$row->id?>">
				 			<button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
				 		</a>

				 		<a href="<?=ROOT?>/debits/delete/<?=$row->id?>">
				 			<button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
				 		</a>
				 	<?php endif;?>
			 	</td>

			 </tr>

 			<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="5"><center>No Debit records were found at this time</center></td></tr>
			<?php endif;?>

	</table>
</div>
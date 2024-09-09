<div class="card-group justify-content-center">

	<table class="table table-striped table-hover">
		<tr><th></th><th>Customer Name</th><th>Address</th><th>Contact Details</th>
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
			 	<td><?=$row->customer?></td><td><?=$row->address?></td><td><?=$row->contact?></td>

			 	<td>
			 		<?php if(Auth::access('head')):?>
				 		<a href="<?=ROOT?>/customers/edit/<?=$row->id?>">
				 			<button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
				 		</a>

				 		<a href="<?=ROOT?>/customers/delete/<?=$row->id?>">
				 			<button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
				 		</a>
				 	<?php endif;?>
			 	</td>

			 </tr>

 			<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="5"><center>No Customers were found at this time</center></td></tr>
			<?php endif;?>

	</table>
</div>